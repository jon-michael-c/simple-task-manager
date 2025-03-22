@extends('layouts.app')

@section('content')
    <div>
        <form method="GET" action="{{ route('tasks.index') }}">
            <label for="project_id">Filter by Project:</label>
            <select name="project_id" onchange="this.form.submit()">
                <option value="">All Projects</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ (isset($projectId) && $projectId == $project->id) ? 'selected' : '' }}>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <h2 class="text-xl font-semibold mt-8">Create Task</h2>
    <form method="POST" action="{{ route('tasks.store') }}" class="mt-4">
        @csrf
        <input type="text" name="name" placeholder="Task Name" required
            class="border p-2 rounded bg-gray-800 text-gray-100">
        <select name="project_id" class="border p-2 rounded bg-gray-800 text-gray-100">
            <option value="">Select Project (optional)</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white p-2 rounded">Add Task</button>
    </form>

    <h2 class="text-xl font-semibold mt-8">Task List</h2>
    <ul id="task-list" class="grid gap-4 mt-4">
        @foreach($tasks as $task)
            <li class="task-item p-2 border bg-gray-800 rounded" data-id="{{ $task->id }}">
                <x-task :task="$task" />
            </li>
        @endforeach
    </ul>
@endsection