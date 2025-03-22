<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    // List tasks with optional filtering by project.
    public function index(Request $request)
    {
        $projectId = $request->input('project_id');
        $projects = Project::all();

        $tasks = $projectId
            ? Task::where('project_id', $projectId)->orderBy('priority')->get()
            : Task::orderBy('priority')->get();

        return view('tasks.index', compact('tasks', 'projects', 'projectId'));
    }

    // Store a new task.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $maxPriority = Task::max('priority');
        Task::create([
            'name' => $validated['name'],
            'project_id' => $validated['project_id'] ?? null,
            'priority' => $maxPriority ? $maxPriority + 1 : 1,
        ]);

        return redirect()->route('tasks.index');
    }

    // Show edit form.
    public function edit(Task $task)
    {
        $projects = Project::all();
        return view('tasks.edit', compact('task', 'projects'));
    }

    // Update an existing task.
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $task->update([
            'name' => $validated['name'],
            'project_id' => $validated['project_id'] ?? null,
        ]);

        return redirect()->route('tasks.index');
    }

    // Delete a task.
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }

    // Update task order via drag and drop.
    public function reorder(Request $request)
    {
        $orderedIds = $request->input('order'); // array of task IDs in new order

        foreach ($orderedIds as $index => $id) {
            Task::where('id', $id)->update(['priority' => $index + 1]);
        }

        return response()->json(['status' => 'success']);
    }
}
