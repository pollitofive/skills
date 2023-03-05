<?php

namespace Tests\Feature;

use App\Http\Livewire\ListDevelopers;
use App\Models\{SkillXDeveloper,User};
use Illuminate\Support\Collection;
use Livewire\Livewire;
use Tests\TestCase;

class ListDeveloperTest extends TestCase
{
    /** @test */
    public function main_page_contains_list_developers_livewire_component()
    {
        $this->get('developers')->assertSeeLivewire('list-developers');
    }

    /** @test */
    public function can_show_own_data()
    {
        $list_developers = \App\Models\Developer::factory(5)->create([
            'user_id' => auth()->user()->id
        ]);

        $list_skills = \App\Models\Skill::factory(10)->create([
            'user_id' => auth()->user()->id
        ]);

        foreach($list_developers as $developer) {
            foreach($list_skills->random(3) as $skill) {
                $skill_model = new SkillXDeveloper(['skill_id' => $skill->id]);
                $developer->skills_x_developer()->save($skill_model);
            }
        }

        $test = Livewire::test(ListDevelopers::class)
            ->set('search','%')
            ->call('render');

        foreach($list_developers as $developer) {
            $test->assertSee($developer->firtname)
                ->assertSee($developer->lastname)
                ->assertSee($developer->nid)
                ->assertSee($developer->email)
                ->assertSee($developer->birthday)
                ->assertSee($developer->id)
                ->assertSee('Active');
        }
    }

    /** @test */
    public function dont_show_other_data()
    {
        $list_own_developers = \App\Models\Developer::factory(5)->create([
            'user_id' => auth()->user()->id
        ]);

        $list_own_skills = \App\Models\Skill::factory(10)->create([
            'user_id' => auth()->user()->id
        ]);

        foreach($list_own_developers as $developer) {
            foreach($list_own_skills->random(3) as $skill) {
                $skill_model = new SkillXDeveloper(['skill_id' => $skill->id]);
                $developer->skills_x_developer()->save($skill_model);
            }
        }

        $list_other_developers = \App\Models\Developer::factory(3)->create([
            'user_id' => User::factory()->create()
        ]);

        $list_other_skills = \App\Models\Skill::factory(3)->create([
            'user_id' => User::factory()->create()
        ]);

        foreach($list_other_developers as $developer) {
            foreach($list_other_skills->random(3) as $skill) {
                $skill_model = new SkillXDeveloper(['skill_id' => $skill->id]);
                $developer->skills_x_developer()->save($skill_model);
            }
        }

        $test = Livewire::test(ListDevelopers::class)
            ->call('render');

        foreach($list_own_developers as $developer) {
            $test->assertSee($developer->firstname)
                ->assertSee($developer->lastname)
                ->assertSee($developer->nid)
                ->assertSee($developer->email)
                ->assertSee($developer->birthday)
                ->assertSee('Active');
        }

        foreach($list_other_developers as $developer) {
            $test->assertDontSee($developer->firsname)
                ->assertDontSee($developer->lastname)
                ->assertDontSee($developer->nid)
                ->assertDontSee($developer->email)
                ->assertDontSee($developer->birthday);
        }
    }

    /** @test */
    public function dont_show_inactive_data_if_is_not_checked_the_option()
    {
        $list_developers = \App\Models\Developer::factory(3)->create([
            'user_id' => auth()->user()->id
        ]);

        $list_developers = $this->createSkills($list_developers);

        $developer_inactive = \App\Models\Developer::factory()->trashed()->create([
            'user_id' => auth()->user()->id,
        ]);

        $developer_inactive = $this->createSkills($developer_inactive);

        $test = Livewire::test(ListDevelopers::class)
            ->call('render');

        foreach($list_developers as $developer) {
            $test->assertSee($developer->firstname)
                ->assertSee($developer->lastname)
                ->assertSee($developer->nid)
                ->assertSee($developer->email)
                ->assertSee($developer->birthday)
                ->assertSee('Active');
        }

        $test->assertDontSee($developer_inactive->firsname)
            ->assertDontSee($developer_inactive->lastname)
            ->assertDontSee($developer_inactive->nid)
            ->assertDontSee($developer_inactive->email)
            ->assertDontSee($developer_inactive->birthday);
    }

    /** @test */
    public function show_inactive_data_if_is_checked_the_option()
    {
        $list_developers = \App\Models\Developer::factory(3)->create([
            'user_id' => auth()->user()->id
        ]);

        $list_developers = $this->createSkills($list_developers);

        $developer_inactive = \App\Models\Developer::factory()->trashed()->create([
            'user_id' => auth()->user()->id,
        ]);

        $developer_inactive = $this->createSkills($developer_inactive);

        $test = Livewire::test(ListDevelopers::class)
            ->set('active',false)
            ->call('render');

        foreach($list_developers as $developer) {
            $test->assertSee($developer->firstname)
                ->assertSee($developer->lastname)
                ->assertSee($developer->nid)
                ->assertSee($developer->email)
                ->assertSee($developer->birthday)
                ->assertSee('Active');
        }

        $test->assertSee($developer_inactive->firsname)
            ->assertSee($developer_inactive->lastname)
            ->assertSee($developer_inactive->nid)
            ->assertSee($developer_inactive->email)
            ->assertSee($developer_inactive->birthday);
    }

    /** @test */
    public function show_data_with_search_filter_in_firstname()
    {
        $this->createDeveloperWithSkill(firstname: 'Damian Leandro');
        $this->createDeveloperWithSkill(firstname: 'Damian Javier');
        $this->createDeveloperWithSkill(firstname: 'Lucas');

        $test = Livewire::test(ListDevelopers::class)
            ->set('search','Damian')
            ->call('render');

        $test->assertSee('Damian Leandro')
            ->assertSee('Damian Javier');

        $test->assertDontSee('Lucas');
    }

    /** @test */
    public function show_data_with_search_filter_in_lastname()
    {
        $this->createDeveloperWithSkill(lastname: 'Ladiani Perez');
        $this->createDeveloperWithSkill(lastname: 'Blitman Perez');
        $this->createDeveloperWithSkill(lastname: 'Blitsisi Hidalgo');

        $test = Livewire::test(ListDevelopers::class)
            ->set('search','Perez')
            ->call('render');

        $test->assertSee('Ladiani Perez')
            ->assertSee('Blitman Perez');

        $test->assertDontSee('Blitsisi Hidalgo');
    }

    /** @test */
    public function show_data_with_search_filter_in_nid()
    {
        $this->createDeveloperWithSkill(firstname: 'Damian', nid: '33500666');
        $this->createDeveloperWithSkill(firstname: 'Daniel', nid: '33600777');
        $this->createDeveloperWithSkill(firstname: 'Lucas', nid: '33600888');

        $test = Livewire::test(ListDevelopers::class)
            ->set('search','600')
            ->call('render');

        $test->assertSee('Daniel')
            ->assertSee('33600777')
            ->assertSee('Lucas')
            ->assertSee('33600888');

        $test->assertDontSee('Damian')
                ->assertDontSee('33500666');
    }

    /** @test */
    public function show_data_with_search_filter_in_email()
    {
        $this->createDeveloperWithSkill(firstname: 'Damian', email: 'damian@gmail.com');
        $this->createDeveloperWithSkill(firstname: 'Daniel', email: 'daniel@hotmail.com');
        $this->createDeveloperWithSkill(firstname: 'Lucas', email: 'lucas@gmail.com');

        $test = Livewire::test(ListDevelopers::class)
            ->set('search','gmail')
            ->call('render');

        $test->assertSee('Damian')
            ->assertSee('damian@gmail.com')
            ->assertSee('Lucas')
            ->assertSee('lucas@gmail.com');

        $test->assertDontSee('Daniel')
            ->assertDontSee('daniel@hotmail.com');
    }

    /** @test */
    public function show_data_with_search_filter_in_birthday()
    {
        $this->createDeveloperWithSkill(firstname: 'Damian', birthday: '1988-01-01');
        $this->createDeveloperWithSkill(firstname: 'Daniel', birthday: '1988-03-03');
        $this->createDeveloperWithSkill(firstname: 'Lucas', birthday: '1989-05-05');

        $test = Livewire::test(ListDevelopers::class)
            ->set('search','1988')
            ->call('render');

        $test->assertSee('Damian')
            ->assertSee('1988-01-01')
            ->assertSee('Daniel')
            ->assertSee('1988-03-03');

        $test->assertDontSee('Lucas')
            ->assertDontSee('1989-05-05');
    }

    /** @test */
    public function show_data_with_search_filter_in_skills()
    {
        $skill_laravel = \App\Models\Skill::factory()->create([
            'user_id' => auth()->user()->id,
            'description' => 'Laravel'
        ]);

        $developer1 = $this->createDeveloperWithSkill(firstname: 'Damian');

        $skill_x_developer_model = new SkillXDeveloper(['skill_id' => $skill_laravel->id]);
        $developer1->skills_x_developer()->save($skill_x_developer_model);

        $developer2 = $this->createDeveloperWithSkill(firstname: 'Daniel');

        $skill_x_developer_model = new SkillXDeveloper(['skill_id' => $skill_laravel->id]);
        $developer2->skills_x_developer()->save($skill_x_developer_model);

        $this->createDeveloperWithSkill(firstname: 'Lucas');

        $test = Livewire::test(ListDevelopers::class)
            ->set('search','Laravel')
            ->call('render');

        $test->assertSee('Damian')
            ->assertSee('Laravel')
            ->assertSee('Daniel');

        $test->assertDontSee('Lucas');
    }


    private function createSkills($list_developers)
    {
        $list_own_skills = \App\Models\Skill::factory(10)->create([
            'user_id' => auth()->user()->id
        ]);

        if(! $list_developers instanceof Collection ) {
            foreach($list_own_skills->random(3) as $skill) {
                $skill_model = new SkillXDeveloper(['skill_id' => $skill->id]);
                $list_developers->skills_x_developer()->save($skill_model);
            }
            return $list_developers;
        }

        foreach($list_developers as $developer) {
            foreach($list_own_skills->random(3) as $skill) {
                $skill_model = new SkillXDeveloper(['skill_id' => $skill->id]);
                $developer->skills_x_developer()->save($skill_model);
            }
        }

        return $list_developers;
    }

    private function createDeveloperWithSkill($firstname='',$lastname='',$nid='',$email='',$birthday='')
    {
        $data = [];
        if($firstname) $data['firstname'] = $firstname;
        if($lastname) $data['lastname'] = $lastname;
        if($nid) $data['nid'] = $nid;
        if($email) $data['email'] = $email;
        if($birthday) $data['birthday'] = $birthday;


        $developer = \App\Models\Developer::factory()->create([
            'user_id' => auth()->user()->id,
            ...$data
        ]);

        $this->createSkills($developer);

        return $developer;

    }




}
