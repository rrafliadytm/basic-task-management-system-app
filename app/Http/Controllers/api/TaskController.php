<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\Info(
 * version="1.0.0",
 * title="Task Management API Documentation",
 * description="API Documentation for the Task Management System"
 * )
 * @OA\SecurityScheme(
 * securityScheme="bearerAuth",
 * type="http",
 * scheme="bearer"
 * )
 * @OA\Schema(
 * schema="Task",
 * required={"id", "title", "status"},
 * @OA\Property(property="id", type="integer", readOnly=true, example=1),
 * @OA\Property(property="title", type="string", example="Finalize Report"),
 * @OA\Property(property="description", type="string", nullable=true, example="Monthly sales report."),
 * @OA\Property(property="status", type="string", enum={"pending", "in-progress", "completed"}, example="pending"),
 * @OA\Property(property="deadline", type="string", format="date-time", nullable=true, example="2025-12-31T23:59:59Z"),
 * @OA\Property(property="category", type="string", readOnly=true, example="Work"),
 * @OA\Property(property="priority", type="string", readOnly=true, example="High"),
 * @OA\Property(property="created_at", type="string", format="date-time", readOnly=true, example="2025-08-01T10:00:00Z")
 * )
 * @OA\Schema(
 * schema="TaskRequest",
 * required={"title", "category_id", "priority_id", "status"},
 * @OA\Property(property="title", type="string", example="New Task Title"),
 * @OA\Property(property="description", type="string", nullable=true),
 * @OA\Property(property="category_id", type="integer", example=1),
 * @OA\Property(property="priority_id", type="integer", example=2),
 * @OA\Property(property="deadline", type="string", format="date-time", nullable=true),
 * @OA\Property(property="status", type="string", enum={"pending", "in-progress", "completed"})
 * )
 */
class TaskController extends Controller
{
    use AuthorizesRequests;

    /**
     * @OA\Get(
     * path="/tasks",
     * summary="Get list of tasks",
     * tags={"Tasks"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Successful operation",
     * @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Task"))
     * ),
     * @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function index()
    {
        $tasks = Auth::user()
            ->tasks()
            ->with(['categories', 'priorities'])
            ->latest()
            ->paginate(10);

        return response()->json(['data' => $tasks]);
    }

    /**
     * @OA\Post(
     * path="/tasks",
     * summary="Create a new task",
     * tags={"Tasks"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/Task")
     * ),
     * @OA\Response(
     * response=201,
     * description="Task created successfully",
     * @OA\JsonContent(ref="#/components/schemas/Task")
     * ),
     * @OA\Response(response=401, description="Unauthenticated"),
     * @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(StoreTaskRequest $request)
    {
        $task = Auth::user()->tasks()->create($request->validated());

        return new TaskResource($task);
    }

    /**
     * @OA\Get(
     * path="/tasks/{id}",
     * summary="Get a specific task",
     * tags={"Tasks"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(response=200, description="Successful operation", @OA\JsonContent(ref="#/components/schemas/Task")),
     * @OA\Response(response=403, description="Forbidden"),
     * @OA\Response(response=404, description="Not Found")
     * )
     */
    public function show(Tasks $task)
    {
        $this->authorize('view', $task);

        return new TaskResource($task
            ->load(['categories', 'priorities']));
    }

    /**
     * @OA\Put(
     * path="/tasks/{id}",
     * summary="Update an existing task",
     * tags={"Tasks"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID of the task to update",
     * @OA\Schema(type="integer")
     * ),
     * @OA\RequestBody(
     * required=true,
     * description="Data to update the task",
     * @OA\JsonContent(ref="#/components/schemas/TaskRequest")
     * ),
     * @OA\Response(
     * response=200,
     * description="Task updated successfully",
     * @OA\JsonContent(ref="#/components/schemas/Task")
     * ),
     * @OA\Response(response=403, description="Forbidden"),
     * @OA\Response(response=404, description="Task not found"),
     * @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(UpdateTaskRequest $request, Tasks $task)
    {
        $this->authorize('update', $task);

        $task->update($request->validated());
        return new TaskResource($task);
    }

    /**
     * @OA\Delete(
     * path="/tasks/{id}",
     * summary="Delete a task",
     * tags={"Tasks"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID of the task to delete",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=204,
     * description="Task deleted successfully"
     * ),
     * @OA\Response(response=403, description="Forbidden"),
     * @OA\Response(response=404, description="Task not found")
     * )
     */

    public function destroy(Tasks $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->noContent(); // Standar response untuk delete (204 No Content)
    }
}
