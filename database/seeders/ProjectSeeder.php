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
                'title' => 'Insurance Core System Modernization',
                'summary' => 'Migrated a decade of legacy FileMaker data and workflows to a modern web-based Insurance Core System, with zero business disruption.',
                'description' => "Planned and led the migration of the company's Insurance Core System from a legacy FileMaker platform to a modern web-based system, coordinating business stakeholders and the technical team.\n\nResearched Docker, Coolify, and Virtual Private Server-based deployment options to guide the rollout strategy. Completed May 2026 after migrating over ten years of legacy data and workflows with zero business disruption.",
                'tech_stack' => 'PHP, Laravel, Docker, Coolify, MySQL',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'CRM & Data Insight System',
                'summary' => 'A Laravel-built CRM covering agency and policy management, claims tracking, and sales channel reporting.',
                'description' => "Directing ongoing development of a web-based Customer Relationship Management and Data Insight System covering agency and policy management, claims tracking, and sales channel reporting, delivered using Jira-managed agile sprints.\n\nThis system now underpins the company's customer portal, agent portal, and future partner integrations.",
                'tech_stack' => 'Laravel, MySQL, Vue.js, REST API',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Google Gemini AI Assistant & Automated Reporting',
                'summary' => 'An AI assistant embedded in the CRM, giving staff verified answers on policies, claims, and underwriting turnaround time.',
                'description' => "Designed and integrated REST APIs connecting the CRM system with the Google Gemini AI assistant and external partner platforms, combining live database queries with generative AI so staff get answers that reconcile exactly with core business reports.\n\nExpanded this into automated pipelines for FAQ generation and daily market intelligence reporting — competitor landscape, reinsurance trends, and product recommendations — grounded in the company's own sales and claims data.",
                'tech_stack' => 'Laravel, Google Gemini API, REST API',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Finance System with Vendor-Side Integration',
                'summary' => 'An in-progress Finance System reconciling policy management, premium collection, claims payments, and settlement into one workflow.',
                'description' => "Currently developing a Finance System connecting policy management, premium collection, claims payments, and settlement into a single reconciled workflow.",
                'tech_stack' => 'Laravel, MySQL',
                'is_featured' => false,
                'sort_order' => 4,
            ],
            [
                'title' => 'IT Support, Employee Management & Leave Systems',
                'summary' => 'A company-wide IT helpdesk ticketing system, an internal Employee Management System, and an electronic leave request workflow.',
                'description' => "Led the development team in building a company-wide IT support and help desk ticketing system, an internal Employee Management System, and an electronic leave request and approval system.",
                'tech_stack' => 'PHP, Laravel, MySQL',
                'is_featured' => false,
                'sort_order' => 5,
            ],
            [
                'title' => 'Personal Portfolio',
                'summary' => 'This site — a Laravel-powered portfolio with a blog and a full admin panel.',
                'description' => "Built with Laravel, Breeze, and Tailwind CSS. Includes a lightweight admin panel for managing projects, blog posts, skills, and site settings without touching code.",
                'tech_stack' => 'Laravel, Blade, Tailwind CSS',
                'is_featured' => false,
                'sort_order' => 6,
            ],
        ];

        Project::query()->delete();

        foreach ($projects as $project) {
            Project::create($project + ['slug' => Str::slug($project['title'])]);
        }
    }
}
