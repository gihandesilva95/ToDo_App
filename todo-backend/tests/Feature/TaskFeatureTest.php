<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;


class TaskFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_task()
    {
        $data = [
            'task_name' => 'Write tests',
            'description' => 'Create Laravel unit & feature tests',
            'status' => 'pending',
        ];

        $response = $this->postJson('/api/tasks', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['task_name' => 'Write tests']);

        $this->assertDatabaseHas('task', $data);
    }

    public function test_can_list_tasks()
    {
        Task::factory()->count(6)->create(['status' => 'pending']);

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
                 ->assertJsonCount(5);
    }

    public function test_can_update_task_status()
    {
        $task = Task::factory()->create(['status' => 'pending']);

        $response = $this->putJson("/api/tasks/{$task->task_id}", [
            'status' => 'done'
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['status' => 'done']);

        $this->assertDatabaseHas('task', [
            'task_id' => $task->task_id,
            'status' => 'done',
        ]);
    }


    public function test_create_task_validation()
    {
        $data = [
            // Intentionally missing 'task_name' and 'description'
            // 'task_name' => 'New Task', 
            // 'description' => 'Test creating a task',
            // 'status' => 'pending' // You can also remove the 'status' field if you prefer
        ];

        $response = $this->postJson('/api/tasks', $data);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['task_name', 'description', 'status']);  // Now also checking 'status'
    }

}

