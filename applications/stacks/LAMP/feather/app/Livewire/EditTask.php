<?php
namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;

/**
 * EditTask
 */
class EditTask extends Component
{
    /**
     * task
     *
     * @var Task
     */
    public Task $task;

    /**
     * tag field
     *
     * @var string
     */
    public string $tag;

    /**
     * description field
     *
     * @var string
     */
    public string $description;

    /**
     * mount
     *
     * In this Laravel checks the parameter's type and automatically resolves the instance
     * using the primary key taken from the URL, in practice,
     * Laravel implicitly performs the query with Task::findOrFail($id) and returns the model to me.
     *
     * @param  Task $task
     * @return void
     */
    public function mount(Task $task):void
    {
        $this->task        = $task;
        $this->tag         = $this->task->tag;
        $this->description = $this->task->description;
    }


    /**
     * update
     *
     * handle submission
     *
     * @return mixed
     */
    public function update()
    {
        // Validation
        $this->validate([
            'task.tag'         => 'required|string|max:255|regex:/^[\pL\s\-\'\.]+$/u',
            'task.description' => 'required|string|regex:/^[\pL\s\-\'\.]+$/u',
        ]);

        // Save
        $this->task->tag         = $this->tag;
        $this->task->description = $this->description;
        $this->task->save();

        // Optional feedback shown to the user.
        // Superfluous with redirection.
        session()->flash('success', 'Task updated successfully!');

        // Redirect
        return redirect()
            ->route('show-task', $this->task->id)
            ->with('success', 'Task updated successfully!');
        // Optional emission of an event.
        // $this->emit('task-updated', $this->task->id);
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.edit-task');
    }
}
