<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'CRM Platform',
                'summary' => 'A customer relationship management system built for internal sales and support teams.',
                'description' => "A full-featured CRM built with Laravel, covering renewal reporting, aging analysis, and multi-database integrations across several internal systems.\n\nHighlights: role-based access, scheduled reporting, and a dashboard for account managers.",
                'tech_stack' => 'Laravel, MySQL, Alpine.js, Tailwind CSS',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Renewal & Aging Reports',
                'summary' => 'Automated reporting module for policy renewals and account aging.',
                'description' => "Generates scheduled renewal and aging reports, replacing a manual spreadsheet process with automated, filterable dashboards.",
                'tech_stack' => 'Laravel, MySQL, Chart.js',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Personal Portfolio',
                'summary' => 'This site — a Laravel-powered portfolio with a blog and admin panel.',
                'description' => "Built with Laravel, Breeze, and Tailwind CSS. Includes a lightweight admin panel for managing projects, blog posts, and skills without touching code.",
                'tech_stack' => 'Laravel, Blade, Tailwind CSS',
                'is_featured' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['slug' => Str::slug($project['title'])],
                $project + ['slug' => Str::slug($project['title'])]
            );
        }
    }
}
