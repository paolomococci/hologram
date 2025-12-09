<?php
namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

/**
 * FabEdit
 */
class FabEdit extends Component
{
    /**
     * id
     *
     * @var int
     */
    public int $id;

    /**
     * isEditable
     *
     * @var bool
     */
    public bool $isEditable = false;

    /**
     * handleShowTaskEvent
     *
     * @param  mixed $id
     * @param  mixed $isEditable
     * @return void
     */
    #[On('show-task-event')]
    public function handleShowTaskEvent($id, $isEditable)
    {
        $this->id         = $id;
        $this->isEditable = $isEditable;
    }

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.fab-edit');
    }
}
