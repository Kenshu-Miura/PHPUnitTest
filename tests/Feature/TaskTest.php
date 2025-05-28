<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_task(): void
    {
        $response = $this->post('/tasks', [
            'title' => 'テストタスク',
            'description' => 'テスト用のタスクです'
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('tasks', [
            'title' => 'テストタスク',
            'description' => 'テスト用のタスクです',
            'is_completed' => false
        ]);
    }

    public function test_can_toggle_task_completion(): void
    {
        $task = Task::create([
            'title' => 'テストタスク',
            'description' => 'テスト用のタスクです'
        ]);

        $response = $this->patch("/tasks/{$task->id}/toggle");

        $response->assertRedirect('/');
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_completed' => true
        ]);
    }

    public function test_can_delete_task(): void
    {
        $task = Task::create([
            'title' => 'テストタスク',
            'description' => 'テスト用のタスクです'
        ]);

        $response = $this->delete("/tasks/{$task->id}");

        $response->assertRedirect('/');
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id
        ]);
    }
} 