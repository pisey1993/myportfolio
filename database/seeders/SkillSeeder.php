<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            ['name' => 'PHP', 'category' => 'Backend', 'level' => 90],
            ['name' => 'Laravel', 'category' => 'Backend', 'level' => 90],
            ['name' => 'MySQL', 'category' => 'Backend', 'level' => 80],
            ['name' => 'JavaScript', 'category' => 'Frontend', 'level' => 75],
            ['name' => 'Tailwind CSS', 'category' => 'Frontend', 'level' => 85],
            ['name' => 'Vue.js', 'category' => 'Frontend', 'level' => 65],
            ['name' => 'Git', 'category' => 'Tools', 'level' => 85],
            ['name' => 'Docker', 'category' => 'Tools', 'level' => 60],
        ];

        foreach ($skills as $i => $skill) {
            Skill::updateOrCreate(
                ['name' => $skill['name']],
                $skill + ['sort_order' => $i]
            );
        }
    }
}
