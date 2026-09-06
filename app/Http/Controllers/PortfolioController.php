<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\Experience;
use App\Models\Post;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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

        $latestPosts = Post::published()->articles()->latest('published_at')->limit(3)->get();

        $settings = SiteSetting::current();

        return view('site.home', compact('featuredProjects', 'skills', 'latestPosts', 'settings'));
    }

    public function about(): View
    {
        $skills = Skill::orderBy('sort_order')->orderBy('name')->get()->groupBy('category');
        $experiences = Experience::orderBy('sort_order')->orderByDesc('id')->get();
        $settings = SiteSetting::current();

        return view('site.about', compact('skills', 'experiences', 'settings'));
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
        $posts = Post::published()->articles()->latest('published_at')->paginate(6);

        return view('site.blog.index', compact('posts'));
    }

    public function blogShow(Post $post): View
    {
        abort_unless($post->is_published, 404);

        return view('site.blog.show', compact('post'));
    }

    public function videoBlog(): View
    {
        $posts = Post::published()->videos()->latest('published_at')->paginate(6);

        return view('site.blog.video-index', compact('posts'));
    }

    public function contact(): View
    {
        $settings = SiteSetting::current();

        return view('site.contact', compact('settings'));
    }

    public function contactStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $contactMessage = ContactMessage::create($validated);

        try {
            Mail::to('mrsey9999@gmail.com')->send(new ContactMessageReceived($contactMessage));

            $status = 'Message sent successfully! I\'ll get back to you soon.';
            $statusType = 'success';
        } catch (\Throwable $e) {
            Log::warning('Contact message email failed: '.$e->getMessage());

            $status = 'Thanks for reaching out! Your message was saved and I\'ll get back to you soon.';
            $statusType = 'info';
        }

        return back()->with('status', $status)->with('status_type', $statusType);
    }
}
