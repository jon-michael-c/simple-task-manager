<div>
    <div>
        <label for="project_filter">Filter by Project:</label>
        <select wire:model.live="selectedProject" id="project_filter" class="border p-2 rounded bg-gray-800 text-gray-100">
            <option value="">All Projects</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Project Section -->
    <div class="mt-8 p-6 border border-gray-700 rounded-lg bg-gray-900">
        <h2 class="text-xl font-semibold mb-4">Manage Projects</h2>
        <div class="space-y-4">
            @if($showNewProjectInput)
                <form wire:submit.prevent="createProject" class="space-y-4">
                    <div class="flex gap-2">
                        <div class="flex-1">
                            <input type="text" 
                                   wire:model="newProjectName" 
                                   placeholder="New Project Name"
                                   class="w-full border p-2 rounded bg-gray-800 text-gray-100">
                            @error('newProjectName') 
                                <span class="text-red-500 text-sm block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex gap-2">
                            <x-button 
                                type="submit"
                                variant="success">
                                Add Project
                            </x-button>
                            <x-button 
                                wire:click.prevent="toggleNewProjectInput"
                                variant="secondary">
                                Cancel
                            </x-button>
                        </div>
                    </div>
                </form>
            @else
                <div class="flex justify-end">
                    <x-button 
                        wire:click.prevent="toggleNewProjectInput"
                        variant="primary">
                        Create New Project
                    </x-button>
                </div>
            @endif
        </div>
    </div>

    <!-- Task Section -->
    <div class="mt-8 p-6 border border-gray-700 rounded-lg bg-gray-900">
        <h2 class="text-xl font-semibold mb-4">Create Task</h2>
        <form wire:submit.prevent="createTask" class="space-y-4">
            <div class="space-y-4">
                <div>
                    <input type="text" 
                           wire:model="newTaskName" 
                           placeholder="Task Name"
                           class="w-full border p-2 rounded bg-gray-800 text-gray-100">
                    @error('newTaskName') 
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
                <div>
                    <select wire:model="newTaskProject" class="w-full border p-2 rounded bg-gray-800 text-gray-100">
                        <option value="">Select Project (optional)</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end">
                <x-button 
                    type="submit"
                    variant="primary">
                    Add Task
                </x-button>
            </div>
        </form>
    </div>

    <!-- Task List -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold">Task List</h2>
        <ul wire:sortable="reorder" class="grid gap-4 mt-4">
            @foreach($tasks as $task)
                <li wire:sortable.item="{{ $task->id }}" wire:key="task-{{ $task->id }}"
                    class="task-item p-1 rounded-md">
                    <div wire:sortable.handle>
                        @include('components.task', ['task' => $task, 'editingTaskId' => $editingTaskId])
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
