<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_has_a_path()
    {
        $project = factory('App\Project')->create();

        $this->assertEquals('/projects/'.$project->id, $project->path());
    }
    /** @test */
    public function belongs_to_user()
    {
        $project = factory('App\Project')->create();
        $this->assertInstanceOf('App\User', $project->owner);
    }
    /** @test */
    public function can_have_many_tasks()
    {
        $project = factory('App\Project')->create();
        $this->assertInstanceOf(Collection::class, $project->tasks);
    }
    /** @test */
    public function can_add_a_task()
    {
        $project = factory('App\Project')->create();
        $task = $project->addTask('Test task');
        
        $this->assertCount(1, $project->tasks);

        $this->assertTrue($project->tasks->contains($task));
    }
}
