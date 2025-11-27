<?php
namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;

/**
 * ShowTask
 */
class ShowTask extends Component
{
    /**
     * That is currently being displayed.
     * @var Task the task
     */
    public Task $task;

    /**
     * @var int properties to store the minimum and maximum ID values in the tasks table.
     *
     * These are used to determine if the current task is at either end of the list.
     */
    public int $minId, $maxId;

    /**
     * mount
     *
     * Mount the component with a specific task ID.
     *
     * The ID of the task to display.
     * @param  mixed $id
     * @return void
     */
    public function mount(int $id)
    {
        // Retrieve the task by ID or throw a 404 if not found.
        $this->task = Task::findOrFail($id);

        // Cache the smallest and largest task IDs for later use.
        $this->minId = Task::min('id');
        $this->maxId = Task::max('id');
    }

    /**
     * prev
     *
     * Move to the previous task.
     * Finds the task with the next lower ID and sets it as the current task.
     *
     * @return void
     */
    public function prev()
    {
        // Find the task whose ID is less than the current one, order by ID descending to get the immediate predecessor.
        $prevTask = Task::where('id', '<', $this->task->id)->orderBy('id', 'desc')->first();

        // If a predecessor exists, update the component's task.
        if ($prevTask) {
            $this->task = $prevTask;
        }
    }

    /**
     * next
     *
     * Move to the next task.
     * Finds the task with the next higher ID and sets it as the current task.
     *
     * @return void
     */
    public function next()
    {
        // Find the task whose ID is greater than the current one, order by ID ascending to get the immediate successor.
        $nextTask = Task::where('id', '>', $this->task->id)->orderBy('id')->first();

        // If a successor exists, update the component's task.
        if ($nextTask) {
            $this->task = $nextTask;
        }
    }

    /**
     * render
     *
     * Render the component's view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Return the Blade view that displays the task details.
        return view('livewire.show-task');
    }
}
