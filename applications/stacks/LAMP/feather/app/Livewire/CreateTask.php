<?php
namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;

/**
 * CreateTask
 */
class CreateTask extends Component
{
    /**
     * tag field
     *
     * @var string
     */
    public string $tag         = '';

    /**
     * description field
     *
     * @var string
     */
    public string $description = '';

    /**
     * rules
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'tag'         => 'required|string|max:255|regex:/^[\pL\s\-\'\.]+$/u',
            'description' => 'required|string|regex:/^[\pL\s\-\'\.]+$/u',
        ];
    }

    /**
     * store
     *
     * @return void
     */
    public function store()
    {
        // Validation
        $this->validate();

        // Create new
        $task = Task::create([
            'tag'         => $this->tag,
            'description' => $this->description,
        ]);

        // Feedback
        // Superfluous with redirection.
        session()->flash('success', 'Task created successfully!');

        // Redirect
        return redirect()
            ->route('show-task', $task)
            ->with('success', 'Task created successfully!');
    }

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.create-task');
    }
}
