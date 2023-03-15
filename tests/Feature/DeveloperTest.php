<?php

namespace Tests\Feature;

use App\Http\Livewire\Developer;
use App\Models\Skill;
use Livewire\Livewire;
use Tests\TestCase;

class DeveloperTest extends TestCase
{
    /** @test */
    public function main_page_contains_developers_form_livewire_component()
    {
        $this->withoutExceptionHandling();
        $this->get('developers')->assertSeeLivewire('developer');
    }

    /** @test */
    public function developer_form_sends_save_data()
    {
        $skills = Skill::factory(3)->create([
            'user_id' => auth()->user()->id,
        ]);

        $data = $this->getData();

        Livewire::test(Developer::class)
            ->set('firstname', $data['firstname'])
            ->set('lastname', $data['lastname'])
            ->set('nid', $data['nid'])
            ->set('email', $data['email'])
            ->set('birthday', $data['birthday'])
            ->set('skills', $skills->pluck('id')->toArray())
            ->call('submitForm')
            ->assertSee('Developer successfully saved.');

        $this->assertDatabaseHas('developers', $data);

        foreach ($skills as $skill) {
            $this->assertDatabaseHas('skill_x_developers', [
                'skill_id' => $skill->id,
                'developer_id' => 1,
            ]);
        }
    }

    /** @test */
    public function developer_form_validates_basic_data()
    {
        Livewire::test(Developer::class)
            ->set('firstname', '')
            ->set('lastname', '')
            ->set('nid', 'A')
            ->set('email', '')
            ->set('birthday', 'A')
            ->set('skills', [])
            ->call('submitForm')
            ->assertSee('The firstname field is required.')
            ->assertSee('The lastname field is required.')
            ->assertSee('The nid must be a number.')
            ->assertSee('The email field is required.')
            ->assertSee('The birthday is not a valid date.')
            ->assertSee('The birthday is not a valid date.')
            ->assertSee('You should select at least one skill.');
    }

    /** @test */
    public function nid_must_be_unique()
    {
        \App\Models\Developer::factory()->create([
            'nid' => '33333333',
            'user_id' => auth()->user()->id,
        ]);

        Livewire::test(Developer::class)
            ->set('nid', '33333333')
            ->call('submitForm')
            ->assertSee('The nid has already been taken.');
    }

    /** @test */
    public function email_must_be_unique()
    {
        \App\Models\Developer::factory()->create([
            'email' => 'damianladiani@gmail.com',
            'user_id' => auth()->user()->id,
        ]);

        Livewire::test(Developer::class)
            ->set('email', 'damianladiani@gmail.com')
            ->call('submitForm')
            ->assertSee('The email has already been taken.');
    }

    /** @test */
    public function page_edit_shows_the_selected_developer()
    {
        $developer = \App\Models\Developer::factory()->create($this->getData());
        Livewire::test(Developer::class)
            ->call('edit', $developer->id)
            ->assertSet('firstname', $developer->firstname)
            ->assertSet('lastname', $developer->lastname)
            ->assertSet('nid', $developer->nid)
            ->assertSet('birthday', $developer->birthday)
            ->assertSet('email', $developer->email)
            ->assertSet('developer_id', $developer->id);
    }

    /** @test */
    public function developer_can_be_edited()
    {
        $skills = Skill::factory(3)->create([
            'user_id' => auth()->user()->id,
        ]);

        $data = $this->getData();
        $developer = \App\Models\Developer::factory()->create($data);
        $new_data = [
            'firstname' => 'Damian Leandro',
            'lastname' => 'Ladini',
            'nid' => '44444444',
            'email' => 'damianladiani2@gmail.com',
            'birthday' => '1989-12-31',
        ];
        Livewire::test(Developer::class)
            ->set('developer_id', $developer->id)
            ->set('firstname', $new_data['firstname'])
            ->set('lastname', $new_data['lastname'])
            ->set('nid', $new_data['nid'])
            ->set('email', $new_data['email'])
            ->set('birthday', $new_data['birthday'])
            ->set('skills', $skills->pluck('id')->toArray())
            ->call('submitForm')
            ->assertSee('Developer successfully saved.');

        $this->assertDatabaseMissing('developers', $data);

        $this->assertDatabaseHas('developers', $new_data);
    }

    /** @test */
    public function skill_can_be_deleted()
    {
        $data = $this->getData();
        $developer = \App\Models\Developer::factory()->create($data);

        Livewire::test(Developer::class)
            ->call('delete', $developer->id);

        $this->assertSoftDeleted('developers', [
            ...$data,
            'user_id' => auth()->user()->id,
        ]
        );
    }

    /** @test */
    public function skill_can_be_activated()
    {
        $data = $this->getData();
        $developer = \App\Models\Developer::factory()->trashed()->create($data);

        Livewire::test(Developer::class)
            ->call('activate', $developer->id);

        $this->assertNotSoftDeleted('developers', [
            'user_id' => auth()->user()->id,
            ...$data,
        ]);
    }

    private function getData()
    {
        return [
            'user_id' => auth()->user()->id,
            'firstname' => 'Damian',
            'lastname' => 'Ladiani',
            'nid' => '33333333',
            'email' => 'damianladiani@gmail.com',
            'birthday' => '1988-12-31',
        ];
    }
}
