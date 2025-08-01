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

class TaskController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = Auth::user()->tasks()->create($request->validated());

        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tasks $task)
    {
        $this->authorize('view', $task);

        return new TaskResource($task
            ->load(['categories', 'priorities']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Tasks $task)
    {
        $this->authorize('update', $task);

        $task->update($request->validated());
        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tasks $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->noContent(); // Standar response untuk delete (204 No Content)
    }
}
