<div class="p-4 border rounded shadow-sm bg-zinc-800 hover:cursor-grab">
    @if($editingTaskId === $task->id)
        <form wire:submit.prevent="updateTask" class="flex items-center space-x-2">
            <input type="text" 
                   wire:model="editingTaskName"
                   class="flex-1 bg-gray-900 border border-gray-700 p-1 rounded text-gray-100"
                   wire:keydown.escape="cancelEdit">
            @error('editingTaskName') 
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            <x-button 
                type="submit"
                variant="success">
                <x-icon name="check" />
            </x-button>
            <x-button 
                type="button"
                variant="danger"
                wire:click="cancelEdit">
                <x-icon name="x" />
            </x-button>
        </form>
    @else
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold">
                    {{ $task->priority }}. {{ $task->name }}
                </h3>
                @if($task->project)
                    <p class="text-sm text-gray-500">Project: {{ $task->project->name }}</p>
                @endif
            </div>
            <div class="space-x-2">
                <x-button 
                    wire:click="startEditing({{ $task->id }})"
                    variant="primary">
                    <x-icon name="edit" />
                </x-button>
                @if($confirmingDelete === $task->id)
                    <div class="inline-flex space-x-2">
                        <x-button 
                            wire:click="deleteTask({{ $task->id }})"
                            variant="success">
                            <x-icon name="check" />
                        </x-button>
                        <x-button 
                            wire:click="cancelDelete"
                            variant="danger">
                            <x-icon name="x" />
                        </x-button>
                    </div>
                @else
                    <x-button 
                        wire:click="confirmDelete({{ $task->id }})"
                        variant="danger">
                        <x-icon name="trash" />
                    </x-button>
                @endif
            </div>
        </div>
    @endif
</div>