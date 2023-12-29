<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function statistics(): \Illuminate\Http\JsonResponse
    {
        $totalTasks = Task::count();
        $completedTasks = Task::where('completed', true)->count();
        $pendingTasks = Task::where('completed', false)->count();

        return response()->json([
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'pendingTasks' => $pendingTasks,
        ]);
    }


    public function getTasksWithNearDueDate(): \Illuminate\Http\JsonResponse
    {
        $nearDueDate = Carbon::today()->addDays(3); // Tasks due in the next 3 days

        $tasks = Task::where('due_date', '<=', $nearDueDate)
            ->where('completed', false)
            ->orderBy('due_date', 'asc')
            ->get();

        return response()->json($tasks);
    }


}
