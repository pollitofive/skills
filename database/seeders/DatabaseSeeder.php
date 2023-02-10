<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Developer;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();

        $skills = [ 1 => 'PHP',
                    2 => 'Laravel',
                    3 => 'Javascript',
                    4 => 'Vue.Js',
                    5 => 'MySql',
                    6 => 'Docker',
                    7 => 'Linux',
                    8 => 'Bootstrap',
                    9 => 'Livewire',
                    10 => 'Redis',
                    11 => 'Html',
                    12 => 'Css'
                ];

        foreach($skills as $skill) {
            Skill::factory()->create(['user_id' => 1, 'description' => $skill]);
        }

        $developers = Developer::factory(20)->create();
        foreach($developers as $developer) {
            $number_of_skills = rand(2,6);
            $rand_keys = array_rand($skills, $number_of_skills);
            foreach($rand_keys as $key => $element) {
                $developer->skills_x_developer()->create(['skill_id' => $element]);
            }
        }
    }
}
