<?php

namespace Tests\Feature\Tasks\Api;

use App\Models\Tasks;
use Tests\TestCase;
use App\Models\Categories;
use App\Models\Priorities;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\CategoryAndPrioritySeeder;

uses(RefreshDatabase::class);

// 'beforeEach' running before each test
beforeEach(function () {
    $this->seed(CategoryAndPrioritySeeder::class);
    // create a user and authenticate
    // This will create a user and set it as the currently authenticated user
    $this->user = User::factory()->create();
    Sanctum::actingAs($this->user);

    // Create a category and priority for the task
    // This will ensure that the category and priority exist in the database
    $this->category = Categories::first();
    $this->priority = Priorities::first();
});

test('can retrieve a list of tasks', function () {
    // Create 1 tasks for the authenticated user
    Tasks::factory(1)->create([
        'user_id' => $this->user->id,
    ]);
    // Create 2 tasks for other users to ensure filtering works
    Tasks::factory(2)->create();

    $response = $this->getJson('/api/tasks');

    $response->assertStatus(200)
             ->assertJsonCount(1, 'data.data'); // Check the actual tasks array within pagination
});

test('can create a new task', function () {
    $taskData = [
        'title' => 'My First API Task',
        'description' => 'This is the description.',
        'category_id' => $this->category->id,
        'priority_id' => $this->priority->id,
        'deadline' => now()->addDay()->toIso8601String(), // Example: deadline besok
        'status' => 'pending',
    ];

    $response = $this->postJson('/api/tasks', $taskData);

    $response->assertStatus(201) // 201 = Created
             ->assertJsonFragment(['title' => 'My First API Task']);

    $this->assertDatabaseHas('tasks', [
        'title' => 'My First API Task',
        'user_id' => $this->user->id, // Ensure that the task is associated with the authenticated user
    ]);
});

test('can retrieve a specific task', function () {
    $task = Tasks::factory()->create(['user_id' => $this->user->id]);

    $response = $this->getJson('/api/tasks/' . $task->id);

    $response->assertStatus(200)
             ->assertJsonFragment(['id' => $task->id]);
});

test('can update a task', function () {
    $task = Tasks::factory()->create(['user_id' => $this->user->id]);

    $updateData = ['title' => 'Updated Title'];

    $response = $this->putJson('/api/tasks/' . $task->id, $updateData);

    $response->assertStatus(200)
             ->assertJsonFragment(['title' => 'Updated Title']);

    $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Updated Title']);
});

test('can delete a task', function () {
    $task = Tasks::factory()->create(['user_id' => $this->user->id]);

    $response = $this->deleteJson('/api/tasks/' . $task->id);

    $response->assertStatus(204); // 204 = No Content

    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
});

test('cannot view a task from another user', function() {
    // Create tasks for the authenticated user
    $otherUserTask = Tasks::factory()->create();

    $response = $this->getJson('/api/tasks/' . $otherUserTask->id);

    $response->assertStatus(403); // 403 = Forbidden
});
