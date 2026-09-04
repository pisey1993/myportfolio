<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Post;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function home(): View
    {
        $featuredProjects = Project::orderBy('sort_order')
            ->orderByDesc('is_featured')
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        $skills = Skill::orderBy('sort_order')->orderBy('name')->get()->groupBy('category');

        $latestPosts = Post::published()->latest('published_at')->limit(3)->get();

        return view('site.home', compact('featuredProjects', 'skills', 'latestPosts'));
    }

    public function about(): View
    {
        $skills = Skill::orderBy('sort_order')->orderBy('name')->get()->groupBy('category');

        return view('site.about', compact('skills'));
    }

    public function projects(): View
    {
        $projects = Project::orderBy('sort_order')->orderByDesc('id')->get();

        return view('site.projects.index', compact('projects'));
    }

    public function projectShow(Project $project): View
    {
        return view('site.projects.show', compact('project'));
    }

    public function blog(): View
    {
        $posts = Post::published()->latest('published_at')->paginate(6);

        return view('site.blog.index', compact('posts'));
    }

    public function blogShow(Post $post): View
    {
        abort_unless($post->is_published, 404);

        return view('site.blog.show', compact('post'));
    }

    public function contact(): View
    {
        return view('site.contact');
    }

    public function contactStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::create($validated);

        return back()->with('status', 'Thanks for reaching out! I\'ll get back to you soon.');
    }
}
