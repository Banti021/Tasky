<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return TaskResource::collection($tasks);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id'     => 'required|exists:users,id',
            'due_date'    => 'nullable|date',
        ]);

        try {
            $task = Task::create($validatedData);
            return new TaskResource($task); // Using API Resource
        } catch (\Exception $e) {
            // Handle exception and return an error response
            return response()->json(['error' => 'Task creation failed'], 500);
        }
    }

    public function complete(Task $task){
        Log::debug($task);
        try{
            $task->update([
                'completed' => true,
            ]);
        }catch (\Exception $e) {
            // Handle exception and return an error response
            return response()->json(['error' => 'Task completion failed'], 500);
        }
    }

    public function update(Request $request, Task $task)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'sometimes|exists:users,id',
            'due_date' => 'nullable|date',
            'completed' => 'sometimes|boolean',
        ]);

        try {
            // Update the task
            $task->update($validatedData);

            return new TaskResource($task);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Task update failed'], 500);
        }
    }


    public function destroy(Task $task)
    {
        try {
            $task->delete();

            return response()->json(['message' => 'Task deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Task deletion failed'], 500);
        }
    }

}
