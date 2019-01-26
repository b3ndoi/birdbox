<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Task;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /** @test
     * A basic test example.
     *
     * @return void
     */
    
    public function it_has_a_path()
    {
        $task = factory(Task::class)->create();

        $this->assertEquals('/projects/'.$task->project->id.'/tasks/'.$task->id, $task->path());
    }
    /** @test
     * A basic test example.
     *
     * @return void
     */
    public function it_belongs_to_a_project(){
        $task = factory(Task::class)->create();
        $this->assertInstanceOf('App\Project', $task->project);
    }
    /** @test
     * A basic test example.
     *
     * @return void
     */
    public function it_can_be_completed(){
        $task = factory(Task::class)->create();
        $this->assertFalse( $task->completed);
        $task->complete();
        $this->assertTrue( $task->completed);
    }
}
