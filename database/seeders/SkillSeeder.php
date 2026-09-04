<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            ['name' => 'Strategic IT Planning', 'category' => 'Leadership', 'level' => 95],
            ['name' => 'Team Leadership & Mentorship', 'category' => 'Leadership', 'level' => 95],
            ['name' => 'Vendor Management', 'category' => 'Leadership', 'level' => 85],
            ['name' => 'Business Consulting', 'category' => 'Leadership', 'level' => 90],

            ['name' => 'PHP & Laravel', 'category' => 'Development', 'level' => 90],
            ['name' => 'Vue.js', 'category' => 'Development', 'level' => 75],
            ['name' => 'REST API Development', 'category' => 'Development', 'level' => 85],
            ['name' => 'FileMaker Pro', 'category' => 'Development', 'level' => 90],

            ['name' => 'Google Gemini API', 'category' => 'AI & Integration', 'level' => 85],
            ['name' => 'AI-Assisted Development', 'category' => 'AI & Integration', 'level' => 85],
            ['name' => 'Jira / Agile PM', 'category' => 'AI & Integration', 'level' => 80],

            ['name' => 'Windows Server & Active Directory', 'category' => 'Systems & Security', 'level' => 85],
            ['name' => 'Docker & Coolify', 'category' => 'Systems & Security', 'level' => 75],
            ['name' => 'Compliance & Audit Remediation', 'category' => 'Systems & Security', 'level' => 85],
        ];

        Skill::query()->delete();

        foreach ($skills as $i => $skill) {
            Skill::create($skill + ['sort_order' => $i]);
        }
    }
}
