<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Collection;

class TaskList extends Component
{
    /** @var Collection */
    public $tasks;
    
    /** @var Collection */
    public $projects;
    
    public $selectedProject = '';
    
    #[Rule('required|min:3')]
    public $newTaskName = '';
    
    public $newTaskProject = '';
    public $newProjectName = '';
    public $showNewProjectInput = false;
    
    public $editingTaskId = null;
    
    #[Rule('required|min:3')]
    public $editingTaskName = '';

    public $confirmingDelete = null;

    public function mount()
    {
        $this->projects = Project::all();
        $this->loadTasks();
    }

    public function updatedSelectedProject()
    {
        $this->loadTasks();
    }

    public function loadTasks()
    {
        $query = Task::query()->orderBy('priority');
        
        if ($this->selectedProject) {
            $query->where('project_id', $this->selectedProject);
        }
        
        $this->tasks = $query->get();
    }

    public function toggleNewProjectInput()
    {
        $this->showNewProjectInput = !$this->showNewProjectInput;
        if (!$this->showNewProjectInput) {
            $this->newProjectName = '';
        }
    }

    public function createProject()
    {
        $this->validate([
            'newProjectName' => 'required|min:3|unique:projects,name'
        ]);

        $project = Project::create(['name' => $this->newProjectName]);
        $this->newTaskProject = $project->id;
        $this->projects = Project::all();
        $this->newProjectName = '';
        $this->showNewProjectInput = false;
    }

    public function filterByProject($projectId)
    {
        $this->selectedProject = $projectId;
        $this->loadTasks();
    }

    public function createTask()
    {
        $this->validate([
            'newTaskName' => 'required|min:3'
        ]);

        Task::create([
            'name' => $this->newTaskName,
            'project_id' => $this->newTaskProject ?: null,
            'priority' => Task::max('priority') + 1
        ]);

        $this->reset(['newTaskName', 'newTaskProject']);
        $this->loadTasks();
    }

    public function startEditing(Task $task)
    {
        $this->editingTaskId = $task->id;
        $this->editingTaskName = $task->name;
    }

    public function updateTask()
    {
        $this->validate([
            'editingTaskName' => 'required|min:3'
        ]);

        $task = Task::find($this->editingTaskId);
        if ($task) {
            $task->update(['name' => $this->editingTaskName]);
        }

        $this->reset(['editingTaskId', 'editingTaskName']);
        $this->loadTasks();
    }

    public function cancelEdit()
    {
        $this->reset(['editingTaskId', 'editingTaskName']);
    }

    public function confirmDelete($taskId)
    {
        $this->confirmingDelete = $taskId;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = null;
    }

    public function deleteTask($taskId)
    {
        Task::destroy($taskId);
        $this->confirmingDelete = null;
        $this->loadTasks();
    }

    public function reorder($orderedIds)
    {
        foreach ($orderedIds as $priority => $id) {
            Task::where('id', $id)->update(['priority' => $priority + 1]);
        }
        $this->loadTasks();
    }

    public function render()
    {
        return view('livewire.task-list');
    }
}
