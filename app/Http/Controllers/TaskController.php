<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;   
use App\Models\Task;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



class TaskController extends Controller
{
    use AuthorizesRequests;
public function index()
    {
        $tasks = Task::where('user_id', auth()->id())->latest()->get();

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline'    => 'nullable|date',
        ]);

        auth()->user()->tasks()->create($validated);

        return redirect()->back();
    }
    
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'deadline'    => 'nullable|date',
            'completed'   => 'sometimes|boolean',
        ]);

        $task->update($validated);
        return redirect()->back();
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->back();
    }

}
