<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test  */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => $this->faker->paragraph,
        ];
        $response = $this->post('/projects', $attributes);

        $project = \App\Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }
    /** @test */
    public function a_user_can_update_their_project()
    {
       
        $project = ProjectFactory::create();
        
        $this->actingAs($project->owner)->patch($project->path(),[
            'notes' => 'New note'
        ])->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', ['notes' => 'New note']);
    }
    /** @test */
    public function only_the_owner_of_the_project_can_update_it()
    {
        // $this->withoutExceptionHandling();
        
        $this->signIn();
        $project = ProjectFactory::create();

        $this->patch($project->path(), [])->assertStatus(403);

        // $this->assertDatabaseMissing('projects', ['notes' => 'New note']);
    }

    /** @test */
    public function a_project_requires_a_title(){
        $this->signIn();

        $attributes = factory('App\Project')->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');

    }
    /** @test */
    public function a_project_requires_a_description(){
        $this->signIn();
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
        
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->get($project->path())
            ->assertSee($project->title)
            ->assertSee(str_limit($project->description, 100));
    }
    /** @test */
    public function an_auth_user_cant_view_projects_of_others(){

        // $this->withoutExceptionHandling();

        $this->signIn();
        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }

}
