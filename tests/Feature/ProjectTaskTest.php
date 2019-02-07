<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use App\Project;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $this->post($project->path().'/tasks', ['body'=>'Test ipsum']);
        $this->get($project->path())
            ->assertSee('Test ipsum');
    }

    /** @test */
    public function only_the_owner_of_the_project_can_add_tasks(){

        $this->signIn();
        $project = factory('App\Project')->create();
        
        $this->post($project->path().'/tasks', ['body'=>'Test ipsum'])->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body'=>'Test ipsum']);
    }
    /** @test */
    public function only_the_owner_of_the_project_can_update_tasks(){
        $this->signIn();
        $project = ProjectFactory::withTasks(1)->create();
        $this->patch($project->tasks[0]->path(), ['body'=>'Test ipsum'])->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body'=>'Test ipsum']);
    }

    /** @test */
    public function a_task_can_be_updated(){
        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        $this->patch($project->tasks[0]->path(),[
            'body'=>'Changed',
        ]);
        $this->assertDatabaseHas('tasks', [
            'body'=>'Changed',
        ]);
    }
    /** @test */
    public function a_task_can_be_completed(){
        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        $this->patch($project->tasks[0]->path(),[
            'body'=>'Changed',
            'completed'=>true,
        ]);
        $this->assertDatabaseHas('tasks', [
            'body'=>'Changed',
            'completed'=>true,
        ]);
    }
    /** @test */
    public function a_task_can_be_marked_as_incompleted(){
        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        $this->patch($project->tasks[0]->path(),[
            'completed'=>true,
        ]);
        $this->patch($project->tasks[0]->path(),[
            'completed'=>false,
        ]);
        $this->assertDatabaseHas('tasks', [
            'completed'=>false,
        ]);
    }
    /** @test */
    public function a_task_requires_a_body(){
        $this->signIn();
        
        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);
        $attributes = factory('App\Task')->raw(['body' => '']);

        $this->post($project->path().'/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
