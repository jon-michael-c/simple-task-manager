<div x-data="{ editing: false, name: '{{ addslashes($task->name) }}' }"
    class="p-4 border rounded shadow-sm bg-zinc-800">
    <template x-if="!editing">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold">
                    {{ $task->priority }}. <span x-text="name"></span>
                </h3>
                @if($task->project)
                    <p class="text-sm text-gray-500">Project: {{ $task->project->name }}</p>
                @endif
            </div>
            <div class="space-x-2">
                <!-- Toggle edit mode -->
                <button @click="editing = true" class="text-blue-500 hover:underline">Edit</button>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                </form>
            </div>
        </div>
    </template>

    <template x-if="editing">
        <form x-on:submit.prevent="
            fetch('{{ route('tasks.update', $task) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-HTTP-Method-Override': 'PUT'
                },
                body: JSON.stringify({ name: name })
            }).then(response => {
                if (response.ok) { editing = false; }
                else { alert('Update failed'); }
            });
        " class="flex items-center space-x-2">
            <input type="text" x-model="name" class="bg-gray-900 border border-gray-700 p-1 rounded text-gray-100">
            <button type="submit" class="text-green-500 hover:underline">Save</button>
            <button type="button" @click="editing = false" class="text-red-500 hover:underline">Cancel</button>
        </form>
    </template>
</div>