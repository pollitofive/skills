<?php

namespace Tests\Feature;

use App\Livewire\Skill;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SkillTest extends TestCase
{
    #[Test]
    public function main_page_contains_skills_form_livewire_component()
    {
        $this->get('skills')->assertSeeLivewire('skill');
    }

    #[Test]
    public function skill_form_sends_save_data()
    {
        Livewire::test(Skill::class)
            ->set('name', 'Livewire')
            ->call('submitForm')
            ->assertSee('Skill successfully saved.');

        $this->assertDatabaseHas('skills', [
            'user_id' => auth()->user()->id,
            'description' => 'Livewire',
        ]);
    }

    #[Test]
    public function form_skill_is_required()
    {
        Livewire::test(Skill::class)
            ->call('submitForm')
            ->assertHasErrors(['name' => 'required'])
            ->assertSee('The name field is required.');

        $this->assertDatabaseMissing('skills', [
            'user_id' => auth()->user()->id,
            'description' => 'Livewire',
        ]);
    }

    #[Test]
    public function skill_can_not_be_repeat()
    {
        \App\Models\Skill::create([
            'description' => 'Livewire',
            'user_id' => auth()->user()->id,
        ]);

        Livewire::test(Skill::class)
            ->set('name', 'Livewire')
            ->call('submitForm')
            ->assertSee('The skill already exist.');
    }

    #[Test]
    public function page_edit_shows_the_selected_skill()
    {
        $skill = \App\Models\Skill::create([
            'description' => 'Livewire',
            'user_id' => auth()->user()->id,
        ]);

        Livewire::test(Skill::class)
            ->call('edit', $skill->id)
            ->assertSet('name', $skill->description)
            ->assertSet('skill_id', $skill->id);
    }

    #[Test]
    public function skill_can_be_edited()
    {
        $skill = \App\Models\Skill::create([
            'description' => 'Livewire',
            'user_id' => auth()->user()->id,
        ]);

        Livewire::test(Skill::class)
            ->set('skill_id', $skill->id)
            ->set('name', 'Laravel')
            ->call('submitForm')
            ->assertSee('Skill successfully saved.');

        $this->assertDatabaseMissing('skills', [
            'user_id' => auth()->user()->id,
            'description' => 'Livewire',
        ]);

        $this->assertDatabaseHas('skills', [
            'user_id' => auth()->user()->id,
            'description' => 'Laravel',
        ]);
    }

    #[Test]
    public function skill_can_be_deleted()
    {
        $skill = \App\Models\Skill::create([
            'description' => 'Livewire',
            'user_id' => auth()->user()->id,
        ]);

        Livewire::test(Skill::class)
            ->call('delete', $skill->id);

        $this->assertSoftDeleted('skills', [
            'user_id' => auth()->user()->id,
            'description' => 'Livewire',
        ]);
    }

    #[Test]
    public function skill_can_be_activated()
    {
        $skill = \App\Models\Skill::create([
            'description' => 'Livewire',
            'user_id' => auth()->user()->id,
        ]);
        $skill->delete();

        Livewire::test(Skill::class)
            ->call('activate', $skill->id);

        $this->assertNotSoftDeleted('skills', [
            'user_id' => auth()->user()->id,
            'description' => 'Livewire',
        ]);
    }
}
