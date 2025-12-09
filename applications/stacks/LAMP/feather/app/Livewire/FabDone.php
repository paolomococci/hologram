<?php
namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;

/**
 * FabDone
 */
class FabDone extends Component
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
     * It sets the Task to be "done".
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function done()
    {
        // If the event hasn't arrived yet, it does nothing.
        if (! $this->task) {
            return redirect()
                ->route('home')
                ->with('error', 'Task not loaded.');
        }

        $this->task->is_done = true;
        $this->task->save();

        // Custom event for the console.log (Livewire 3 emits to window).
        $this->dispatch('fab-done-console-log', [
            'msg' => "The task with id: {$this->task->id} was set to be done!",
        ]);

        // Redirect after the update.
        return redirect()
            ->route('show-task', $this->task->id)
            ->with('success', 'Task set to status done successfully!');
    }

    /**
     * View rendering.
     */
    public function render()
    {
        return view('livewire.fab-done');
    }
}
