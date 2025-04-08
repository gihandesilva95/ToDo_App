<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        return response()->json($tasks);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'task_name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,done',
        ]);
        

        $task = Task::create($request->all());
        return response()->json($task, 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        $task->update($request->all());
        return response()->json($task, 200);
    }

}
