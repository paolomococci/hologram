<?php
namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class Toggle extends Component
{

    /**
     * The visibility of toggle component.
     *
     * @var bool default false
     */
    public bool $isVisible = false;

    /**
     * Current mode of the toggle.
     *
     * @var bool  false → “show unfinished”, true → “show finished”.
     */
    public bool $isOn = false; // default to false

    /**
     * mount
     *
     * When this component mounts, it dispatch the initial state so that
     * the Search component can sync its filter (and vice‑versa).
     *
     * @return void
     */
    public function mount(): void
    {
        // Inform the Search component about the default state.
        $this->dispatch('toggle-filter', $this->isOn);
    }

    #[On('show-toggle')]
    /**
     * syncVisibility
     *
     * Listen to the browser event that comes from Search
     *
     * @param  bool $isVisible
     * @return void
     */
    public function syncVisibility(bool $isVisible): void
    {
        $this->isVisible = $isVisible;
    }

    /**
     * Listen to the `toggle-filter` event fired by the Search component.
     *
     * This keeps the toggle icon in sync if the filter state is changed
     * programmatically (e.g. when the user navigates away and comes back).
     *
     * @On registers this method as an event handler.
     *
     * @param bool $value The new state (true / false).
     */
    #[On('toggle-filter')]
    public function syncState(bool $value): void
    {
        $this->isOn = $value;
    }

    /**
     * User clicked the button → flip the flag and inform the Search
     * component that the filter has changed.
     */
    public function toggle(): void
    {
        $this->isOn = ! $this->isOn;
        $this->dispatch('toggle-filter', $this->isOn);
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.toggle');
    }
}
