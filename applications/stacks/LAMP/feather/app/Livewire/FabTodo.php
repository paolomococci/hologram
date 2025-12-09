<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;

/**
 * FabTodo
 */
class FabTodo extends Component
{
    /**
     * @var Task|null
     *
     * Initially, it was null.
     */
    public ?Task $task = null;

    /**
     * Listener for the custom event that passes the ID of the Task.
     */
    protected $listeners = [
        'task-id-event' => 'handleShowTaskEvent',
    ];

    /**
     * It receives the ID, loads the Task, or fails with a 404.
     */
    public function handleShowTaskEvent(int $id): void
    {
        $this->task = Task::findOrFail($id);
    }

    /**
     * It sets the Task to be todo.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function todo()
    {
        // If the event hasn't arrived yet, it does nothing.
        if (! $this->task) {
            return redirect()
                ->route('home')
                ->with('error', 'Task not loaded.');
        }

        $this->task->is_done = false;
        $this->task->save();

        // Custom event for the console.log (Livewire 3 emits to window).
        $this->dispatch('fab-todo-console-log', [
            'msg' => "The task with id: {$this->task->id} was set to be todo!",
        ]);

        // Redirect after the update.
        return redirect()
            ->route('show-task', $this->task->id)
            ->with('success', 'Task set to status todo successfully!');
    }

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.fab-todo');
    }
}
