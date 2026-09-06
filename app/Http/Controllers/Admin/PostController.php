<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::latest()->get();

        return view('admin.posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('admin.posts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['slug'] = $this->uniqueSlug($validated['title']);
        $validated['is_published'] = $request->boolean('is_published');

        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        Post::create($validated);

        return redirect()->route('admin.posts.index')->with('status', 'Post created.');
    }

    public function edit(Post $post): View
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['is_published'] = $request->boolean('is_published');

        if ($validated['title'] !== $post->title) {
            $validated['slug'] = $this->uniqueSlug($validated['title'], $post->id);
        }

        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        return redirect()->route('admin.posts.index')->with('status', 'Post updated.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('status', 'Post deleted.');
    }

    public function youtubeMeta(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'url' => ['required', 'string', 'max:500'],
        ]);

        try {
            $response = Http::timeout(5)->get('https://www.youtube.com/oembed', [
                'url' => $validated['url'],
                'format' => 'json',
            ]);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Could not reach YouTube.'], 422);
        }

        if (! $response->successful()) {
            return response()->json(['message' => 'Video not found or is private.'], 422);
        }

        return response()->json([
            'title' => $response->json('title'),
            'thumbnail_url' => $response->json('thumbnail_url'),
        ]);
    }

    public function generateFromNews(Request $request): JsonResponse
    {
        try {
            $data = $this->generatePostDataFromNews();
        } catch (\RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 502);
        }

        return response()->json($data);
    }

    public function generateAndCreate(Request $request): RedirectResponse
    {
        try {
            $data = $this->generatePostDataFromNews();
        } catch (\RuntimeException $e) {
            return redirect()->route('admin.posts.index')->with('status', $e->getMessage())->with('status_type', 'error');
        }

        $post = Post::create([
            'title' => $data['title'],
            'slug' => $this->uniqueSlug($data['title']),
            'excerpt' => $data['excerpt'],
            'body' => $data['body'],
            'cover_image' => $data['image_url'],
            'type' => Post::TYPE_ARTICLE,
            'is_published' => false,
        ]);

        return redirect()->route('admin.posts.edit', $post)->with('status', 'Draft generated. Review and publish when ready.');
    }

    private function fetchTechHeadline(): ?array
    {
        try {
            $ids = Http::timeout(10)->get('https://hacker-news.firebaseio.com/v0/topstories.json')->json();
        } catch (\Throwable $e) {
            return null;
        }

        if (! is_array($ids) || empty($ids)) {
            return null;
        }

        $ids = array_slice($ids, 0, 40);

        try {
            $responses = Http::pool(fn (Pool $pool) => collect($ids)->map(
                fn ($id) => $pool->as((string) $id)->timeout(5)->get("https://hacker-news.firebaseio.com/v0/item/{$id}.json")
            )->all());
        } catch (\Throwable $e) {
            return null;
        }

        $stories = [];

        foreach ($ids as $id) {
            $response = $responses[$id] ?? null;
            $item = $response instanceof \Illuminate\Http\Client\Response ? $response->json() : null;

            if (is_array($item) && ($item['type'] ?? null) === 'story' && ! empty($item['title'])) {
                $stories[] = $item;
            }
        }

        if (empty($stories)) {
            return null;
        }

        $keywords = [
            // AI companies / products
            'openai', 'anthropic', 'claude', 'gemini', 'chatgpt', 'gpt-4', 'gpt-5', 'deepmind',
            'meta ai', 'mistral', 'xai', 'grok', 'llama', 'copilot', 'perplexity', 'hugging face',
            'ai', 'llm', 'machine learning',
            // frameworks
            'react', 'vue', 'angular', 'svelte', 'next.js', 'nextjs', 'nuxt', 'laravel', 'django',
            'rails', 'spring boot', 'express', 'flask', 'fastapi', 'remix', 'astro', 'framework',
            // frontend
            'frontend', 'front-end', 'css', 'tailwind', 'javascript', 'typescript', 'webpack', 'vite',
            // backend
            'backend', 'back-end', 'node.js', 'nodejs', 'api', 'microservice', 'php', 'golang', 'rust',
            // database
            'database', 'sql', 'postgres', 'postgresql', 'mysql', 'mongodb', 'redis', 'sqlite', 'nosql', 'mariadb',
        ];

        foreach ($stories as $story) {
            $titleLower = strtolower($story['title']);

            foreach ($keywords as $keyword) {
                if (str_contains($titleLower, $keyword)) {
                    return $this->formatHeadline($story);
                }
            }
        }

        // No story among the current top ones matches AI/framework/frontend/backend/database
        // topics — don't fall back to an unrelated top story, since that would break the
        // topic scope. The caller falls back to a general (still topic-scoped) prompt instead.
        return null;
    }

    private function formatHeadline(array $story): array
    {
        return [
            'title' => $story['title'],
            'url' => $story['url'] ?? "https://news.ycombinator.com/item?id={$story['id']}",
            'published_at' => isset($story['time']) ? date('F j, Y', $story['time']) : 'recently',
        ];
    }

    private function generatePostDataFromNews(): array
    {
        $apiKey = config('services.gemini.key');
        $model = config('services.gemini.model');

        if (! $apiKey) {
            throw new \RuntimeException('Gemini API key is not configured.');
        }

        $headline = $this->fetchTechHeadline();

        $scope = 'AI companies (like OpenAI, Anthropic, Google, Meta), programming frameworks (like React, Vue, Laravel, Next.js, Django), frontend development, backend development, or databases';

        if ($headline) {
            $prompt = <<<PROMPT
            You are a tech blog writer for a software engineer's personal portfolio blog. This blog covers only: {$scope}.

            Here is a real, current story from Hacker News, a tech news aggregator, posted on {$headline['published_at']}:
            Headline: "{$headline['title']}"
            Link: {$headline['url']}

            Write a blog post reacting to this real story from an engineer's perspective. Naturally mention that you came across this on Hacker News and reference the headline. Use what you already know about this topic to add context and opinion; if you don't know further specifics beyond the headline, focus on the broader implications rather than inventing details you're not sure of.

            Respond with ONLY a raw JSON object (no markdown code fences, no extra text before or after) with exactly these keys:
            - "title": an engaging blog post title (max 100 characters)
            - "excerpt": a 1-2 sentence summary (max 200 characters)
            - "body": the blog post body, 4-6 short paragraphs separated by blank lines, plain text (no markdown, no headings), written in first person as the blog author
            - "image_query": 2-4 words describing a relevant photo to illustrate this story (e.g. "artificial intelligence robot")
            PROMPT;
        } else {
            $prompt = <<<PROMPT
            You are a tech blog writer for a software engineer's personal portfolio blog. This blog covers only: {$scope}.

            Write about one genuinely notable, specific recent development strictly within that scope that you know of. Prefer your most recent knowledge.

            Respond with ONLY a raw JSON object (no markdown code fences, no extra text before or after) with exactly these keys:
            - "title": an engaging blog post title (max 100 characters)
            - "excerpt": a 1-2 sentence summary (max 200 characters)
            - "body": the blog post body, 4-6 short paragraphs separated by blank lines, plain text (no markdown, no headings), written in first person as the blog author
            - "image_query": 2-4 words describing a relevant photo to illustrate this story (e.g. "artificial intelligence robot")
            PROMPT;
        }

        $payload = [
            'contents' => [
                ['role' => 'user', 'parts' => [['text' => $prompt]]],
            ],
        ];

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        try {
            $response = $this->postGeminiWithRetry($url, $payload);
        } catch (\Throwable $e) {
            throw new \RuntimeException('Could not reach Gemini.');
        }

        if (! $response->successful()) {
            throw new \RuntimeException('Gemini request failed: '.$response->json('error.message', 'unknown error'));
        }

        $text = data_get($response->json(), 'candidates.0.content.parts.0.text', '');
        $clean = trim(preg_replace('/^```(?:json)?|```$/m', '', (string) $text));
        $data = json_decode($clean, true);

        if (! is_array($data) || empty($data['title']) || empty($data['body'])) {
            throw new \RuntimeException('Gemini returned an unexpected response.');
        }

        $title = Str::limit($data['title'], 255, '');

        return [
            'title' => $title,
            'excerpt' => isset($data['excerpt']) ? Str::limit($data['excerpt'], 255, '') : null,
            'body' => $data['body'],
            'image_url' => $this->findCoverImage($data['image_query'] ?? $title, $title),
        ];
    }

    private function findCoverImage(string $imageQuery, string $title): ?string
    {
        $candidates = array_values(array_unique(array_filter([
            $imageQuery,
            Str::of($title)->words(5, '')->toString(),
            'technology programming computer',
        ])));

        foreach ($candidates as $query) {
            $url = $this->searchOpenverseImage($query) ?? $this->searchCommonsImage($query);

            if ($url) {
                return $url;
            }
        }

        return null;
    }

    private function searchOpenverseImage(string $query): ?string
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'PiseyPortfolioBlog/1.0 ('.config('app.url').')',
            ])->timeout(10)->get('https://api.openverse.org/v1/images/', [
                'q' => $query,
                'license_type' => 'commercial,modification',
                'page_size' => 5,
            ]);
        } catch (\Throwable $e) {
            return null;
        }

        if (! $response->successful()) {
            return null;
        }

        foreach ($response->json('results', []) as $result) {
            $url = $result['thumbnail'] ?? $result['url'] ?? null;

            if ($url) {
                return $url;
            }
        }

        return null;
    }

    private function postGeminiWithRetry(string $url, array $payload): \Illuminate\Http\Client\Response
    {
        for ($attempt = 1; $attempt <= 3; $attempt++) {
            $response = Http::timeout(30)->post($url, $payload);

            if ($response->successful() || $attempt === 3) {
                return $response;
            }

            $retriable = $response->status() === 503 || str_contains($response->body(), 'high demand');

            if (! $retriable) {
                return $response;
            }

            usleep(800_000);
        }

        return $response;
    }

    private function searchCommonsImage(string $query): ?string
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'PiseyPortfolioBlog/1.0 ('.config('app.url').')',
            ])->timeout(10)->get('https://commons.wikimedia.org/w/api.php', [
                'action' => 'query',
                'generator' => 'search',
                'gsrsearch' => $query,
                'gsrnamespace' => 6,
                'gsrlimit' => 5,
                'prop' => 'imageinfo',
                'iiprop' => 'url|mime',
                'iiurlwidth' => 1200,
                'format' => 'json',
            ]);
        } catch (\Throwable $e) {
            return null;
        }

        if (! $response->successful()) {
            return null;
        }

        foreach (data_get($response->json(), 'query.pages', []) as $page) {
            $mime = data_get($page, 'imageinfo.0.mime');
            $url = data_get($page, 'imageinfo.0.thumburl') ?? data_get($page, 'imageinfo.0.url');

            if ($url && in_array($mime, ['image/jpeg', 'image/png'], true)) {
                return $url;
            }
        }

        return null;
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'cover_image' => ['nullable', 'string', 'max:2048'],
            'video_url' => ['nullable', 'string', 'max:2048'],
            'type' => ['required', 'in:'.Post::TYPE_ARTICLE.','.Post::TYPE_VIDEO],
            'published_at' => ['nullable', 'date'],
        ]);
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (
            Post::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
