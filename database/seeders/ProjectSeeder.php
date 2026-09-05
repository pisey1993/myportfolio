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
                'description' => "Originally designed and built the company's Insurance Core System in FileMaker, then years later planned and led its complete migration to a modern web-based platform, coordinating business stakeholders and the technical team throughout.\n\nThis is the system of record the whole business runs on. It covers:\n- Policy management — issuing and maintaining policies across every product line\n- Quote issuance — generating and tracking quotes through to bound policies\n- Underwriting — task and turn-around-time (TAT) tracking by sales channel (Direct Sale, Broker, Banca)\n- Claims register — the full claims lifecycle from registration through BTA, settlement, and BFA\n- Invoicing — debit/credit note (DCN) issuance reconciled against receipt vouchers for premium collection\nEvery other internal system — the CRM, the agency self-service portal, and the AI assistant — reads from and reports on this database. Researched Docker, Coolify, and Virtual Private Server-based deployment options to guide the rollout strategy. Completed May 2026 after migrating over ten years of accumulated data and workflows with zero business disruption.\n\nTech stack:\n- Laravel & PHP — power the full system of record\n- MySQL — stores every policy, claim, and financial record that other internal systems read from\n- Docker — packages the app for deployment\n- Coolify — manages the self-hosted rollout on a VPS",
                'tech_stack' => 'PHP, Laravel, Docker, Coolify, MySQL',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'CRM & Data Insight System',
                'summary' => 'A Laravel-built CRM covering agency and policy management, claims tracking, and sales channel reporting.',
                'description' => "Directed ongoing development of a web-based CRM and Data Insight System that federates six-plus separate company databases — the legacy Insurance Core System (PPICIS), HR, IT support, assets, and underwriting — into one unified reporting and workflow platform, built on Laravel and delivered via Jira-managed agile sprints.\n\nWhat started as agency and policy management has grown into the company's primary business-intelligence layer: claims and underwriting analytics, a full production-reporting suite, per-channel sales dashboards, an AI assistant with tool-calling into live CRM data, and a self-service portal for external agencies.\n\nTech stack:\n- Laravel — serves the backend and business logic\n- MySQL — the primary store federating data from the other internal systems\n- Vue.js — drives the interactive dashboards and self-service agency portal\n- REST API — integrates the CRM with the Core System, HR, IT, and other databases\n- Chart.js — renders the sales, claims, and underwriting visualizations\n- BigQuery — handles the heavier analytical queries as a separate data warehouse",
                'tech_stack' => 'Laravel, MySQL, Vue.js, REST API, Chart.js, BigQuery',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Google Gemini AI Assistant & Automated Reporting',
                'summary' => 'An AI assistant embedded in the CRM, giving staff verified answers on policies, claims, and underwriting turnaround time.',
                'description' => "Designed and integrated REST APIs connecting the CRM to a Google Gemini-based AI assistant, giving staff a conversational way to query the company's own data — not a generic chatbot bolted on top, but one with genuine tool-calling into the CRM's reporting layer.\n\nBuilt out from there into automated FAQ generation and daily market and competitor intelligence pipelines, grounded in the company's own sales and claims data rather than generic AI output.\n\nTech stack:\n- Laravel — hosts the integration layer\n- Google Gemini API — provides the generative model, wired with tool-calling so it queries live CRM data instead of answering generically\n- REST API — connects the CRM, Gemini, and external partner platforms, and drives the automated FAQ and market-report pipelines",
                'tech_stack' => 'Laravel, Google Gemini API, REST API',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Finance System with Vendor-Side Integration',
                'summary' => 'An in-progress Finance System reconciling policy management, premium collection, claims payments, and settlement into one workflow.',
                'description' => "Built the company's Finance dashboard and premium-calculation engine on top of the Insurance Core System — invoice and premium summaries, receipt-voucher and claim-payment-voucher tracking, and division income against target, all in one place for the first time.\n\nCurrently extending this into a full Finance System that reconciles policy management, premium collection, claims payments, and vendor-side settlement into a single workflow.\n\nTech stack:\n- Laravel — runs the dashboard and premium-calculation engine on top of the Core System\n- MySQL — stores invoice, premium, and voucher data\n- PhpSpreadsheet — generates the Excel-based financial reports and reconciliation sheets",
                'tech_stack' => 'Laravel, MySQL, PhpSpreadsheet',
                'is_featured' => false,
                'sort_order' => 4,
            ],
            [
                'title' => 'IT Support & Helpdesk System',
                'summary' => 'A company-wide IT helpdesk ticketing system built around a formal SLA framework.',
                'description' => "After auditing how IT support requests were actually coming in and getting handled, I designed the company's IT Service Level Agreement (SLA) framework to define response and resolution targets.\n\nI then designed and led the development team in building the IT Support Request System that puts that SLA into practice — every request is logged, routed, and assigned to a specific team member, so nothing sits unaddressed.\n\nTech stack:\n- Laravel & PHP — run the ticket logging, routing, and SLA-tracking engine\n- MySQL — stores tickets and assignment history\n- Telegram Bot API — notifies assigned staff of new or overdue tickets directly in Telegram",
                'tech_stack' => 'PHP, Laravel, MySQL, Telegram Bot API',
                'is_featured' => false,
                'sort_order' => 5,
            ],
            [
                'title' => 'HR & Employee Management System',
                'summary' => 'An internal Employee Management System covering the directory, leave, attendance, and org chart.',
                'description' => "Led development of an internal Employee Management System covering the employee directory, leave requests and approvals, attendance, and the company's org chart — built to sit alongside the IT Support system as part of the same internal-tools push.\n\nLeave balances are computed automatically per Cambodian labor law (18 days/year), and attendance is synced from biometric check-in/check-out devices rather than entered manually.\n\nTech stack:\n- Laravel & PHP — handle the employee directory, leave workflow, and org chart\n- MySQL — stores employee records and attendance data synced in from biometric check-in/check-out devices, with leave balances computed automatically per Cambodian labor law",
                'tech_stack' => 'PHP, Laravel, MySQL',
                'is_featured' => false,
                'sort_order' => 6,
            ],
            [
                'title' => 'Personal Portfolio',
                'summary' => 'This site — a Laravel-powered portfolio with a blog and a full admin panel.',
                'description' => "Built with Laravel, Breeze, and Tailwind CSS. Includes a lightweight admin panel for managing projects, blog posts, skills, and site settings without touching code.\n\nTech stack:\n- Laravel & Breeze — provide the app structure and auth scaffolding\n- Blade — renders all pages and admin views server-side\n- Tailwind CSS — handles styling across the site and admin panel",
                'tech_stack' => 'Laravel, Blade, Tailwind CSS',
                'is_featured' => false,
                'sort_order' => 7,
            ],
        ];

        Project::query()->delete();

        foreach ($projects as $project) {
            Project::create($project + ['slug' => Str::slug($project['title'])]);
        }
    }
}
