<?php
namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;

/**
 * FabCanceled
 */
class FabCanceled extends Component
{
    /**
     * task
     *
     * @var Task
     */
    private Task $task;

    /**
     * delete
     *
     * @param  string $uri
     */
    public function delete(string $uri)
    {
        if (preg_match('#/tasks/(\d+)(?:/|$)#', $uri, $num)) {
            $id                  = $num[1];
            $this->task          = Task::findOrFail($id);
            $this->task->delete();
            $this->dispatch(
                'fab-done-console-log',
                json_decode(
                    json_encode(['msg' => "The task with id: $id has been deleted!"])
                )
            );
            // Redirect
            return redirect()
                ->route('home')
                ->with('success', "Task deleted successfully!");
        }
    }

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.fab-canceled');
    }
}
