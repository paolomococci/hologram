<?php
namespace App\Livewire;

use Livewire\Component;

/**
 * Feedback
 */
class Feedback extends Component
{
    /**
     * @var string|null
     *
     * can be null
     */
    public string|null $message;

    /** @var string
     *
     * can be 'success', 'error', 'warning', 'info'
     */
    public string $type = 'success';

    /**
     * The component may receive a message/type from the view.
     * If none is provided, we pull the value from the session flash data.
     */
    public function mount(?string $message = null, string $type = 'success')
    {
        $this->type = $type;

        // Prefer the explicit $message passed from the view
        // Otherwise read from session (e.g. session('success'))
        $this->message = $message ?? session($type);
    }

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.feedback');
    }
}
