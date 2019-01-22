<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test  */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];
        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */
    public function a_project_requires_a_title(){
        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Project')->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');

    }
    /** @test */
    public function a_project_requires_a_description(){
        $this->actingAs(factory('App\User')->create());
        $attributes = factory('App\Project')->raw(['description' => '']);

        $this->post('/projects', [])->assertSessionHasErrors('description');

    }
    /** @test */
    public function guests_may_not_create_projects(){

        // $this->withoutExceptionHandling();
        $attributes = factory('App\Project')->raw();

        $this->post('/projects', $attributes)->assertRedirect('login');

    }
    /** @test */
    public function guests_may_not_view_projects(){

        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');

    }
    /** @test */
    public function guests_may_not_view_a_single_projects(){

        $project = factory('App\Project')->create();
        $this->get( $project->path())->assertRedirect('login');

    }

    /** @test */
    public function a_user_can_view_their_project(){

        $this->withoutExceptionHandling();
        
        $this->actingAs(factory('App\User')->create());
        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->get($project->path())->assertSee($project->title)->assertSee($project->description);
    }
    /** @test */
    public function an_auth_user_cant_view_projects_of_others(){

        // $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());
        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }
}
