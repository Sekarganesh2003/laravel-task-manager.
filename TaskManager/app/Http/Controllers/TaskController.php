<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller {
    public function index() {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request) {
        $request->validate(['title' => 'required']);
        Task::create($request->all());
        return redirect()->back()->with('success', 'Task added successfully!');
    }

    public function update(Request $request, Task $task) {
        $request->validate(['title' => 'required']);
        $task->update($request->all());
        return redirect()->back()->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task) {
        $task->delete();
        return redirect()->back()->with('success', 'Task deleted successfully!');
    }
    public function updateStatus(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->status = $request->status;
        $task->save();
        
        return redirect()->back()->with('success', 'Task status updated successfully!');
    }
    

}
