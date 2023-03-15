<?php

namespace Tests\Feature;

use App\Http\Livewire\ListSkill;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class ListSkillTest extends TestCase
{
    /** @test */
    public function main_page_contains_list_skills_livewire_component()
    {
        $this->get('skills')->assertSeeLivewire('list-skill');
    }

    /** @test */
    public function can_show_own_data()
    {
        $list_skills = \App\Models\Skill::factory(5)->create([
            'user_id' => auth()->user()->id,
        ]);

        $test = Livewire::test(ListSkill::class)
            ->call('render');

        foreach ($list_skills as $skill) {
            $test->assertSee($skill->description)
                ->assertSee($skill->id)
                ->assertSee('Active');
        }
    }

    /** @test */
    public function dont_show_other_data()
    {
        $list_own_skills = \App\Models\Skill::factory(3)->create([
            'user_id' => auth()->user()->id,
        ]);

        $list_other_skills = \App\Models\Skill::factory(3)->create([
            'user_id' => User::factory()->create(),
        ]);

        $test = Livewire::test(ListSkill::class)
            ->call('render');

        foreach ($list_own_skills as $skill) {
            $test->assertSee($skill->description)
                ->assertSee($skill->id)
                ->assertSee('Active');
        }

        foreach ($list_other_skills as $skill) {
            $test->assertDontSee($skill->description);
        }
    }

    /** @test */
    public function dont_show_inactive_data_if_is_not_checked_the_option()
    {
        $list_own_skills = \App\Models\Skill::factory(3)->create([
            'user_id' => auth()->user()->id,
        ]);

        $skill_inactive = \App\Models\Skill::factory()->trashed()->create([
            'user_id' => auth()->user()->id,

        ]);

        $test = Livewire::test(ListSkill::class)
            ->call('render');

        foreach ($list_own_skills as $skill) {
            $test->assertSee($skill->description)
                ->assertSee($skill->id)
                ->assertSee('Active');
        }

        $test->assertDontSee($skill_inactive->description);
    }

    /** @test */
    public function show_inactive_data_if_is_checked_the_option()
    {
        $list_own_skills = \App\Models\Skill::factory(3)->create([
            'user_id' => auth()->user()->id,
        ]);

        $skill_inactive = \App\Models\Skill::factory()->trashed()->create([
            'user_id' => auth()->user()->id,
        ]);

        $test = Livewire::test(ListSkill::class)
            ->set('active', false)
            ->call('render');

        foreach ($list_own_skills as $skill) {
            $test->assertSee($skill->description)
                ->assertSee($skill->id)
                ->assertSee('Active');
        }

        $test->assertSee($skill_inactive->description);
    }

    /** @test */
    public function show_data_with_search_filter()
    {
        \App\Models\Skill::factory()->create(['user_id' => auth()->user()->id, 'description' => 'Livewire']);
        \App\Models\Skill::factory()->create(['user_id' => auth()->user()->id, 'description' => 'Laravel']);
        \App\Models\Skill::factory()->create(['user_id' => auth()->user()->id, 'description' => 'Vue']);

        $test = Livewire::test(ListSkill::class)
            ->set('search', 'L')
            ->call('render');

        $test->assertSee('Laravel')
            ->assertSee('Livewire');

        $test->assertDontSee('Vue');
    }
}
