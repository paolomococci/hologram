<?php

namespace App\Livewire\Author;

use App\Models\Author;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateAuthor extends Component
{
    #[Validate('required|min:2|max:255')]
    public $name;

    #[Validate('required|min:2|max:255')]
    public $surname;

    #[Validate('required|min:1|max:255')]
    public $nickname;

    #[Validate('required|max:255')]
    public $email;

    /**
     * resetFields
     *
     * @return void
     */
    public function resetFields(): void
    {
        $this->name = '';
        $this->surname = '';
        $this->nickname = '';
        $this->email = '';
    }

    /**
     * save
     *
     * saves author data in the database and log this action
     *
     * @return RedirectResponse
     */
    public function save(): RedirectResponse
    {
        $operator = ['email' => Auth::user()->email];
        try {
            $this->validate();
            $author = Author::create([
                'name' => $this->name,
                'surname' => $this->surname,
                'nickname' => $this->nickname,
                'email' => $this->email,
            ]);
            $jsonArrayDataLog = [
                'operator' => $operator,
                'author' => $author,
                'performed' => 'creation',
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/author_create_info.log'),
            ])->info(json_encode($jsonArrayDataLog));
            return redirect()->to('/author')->with('status', 'Added a new author');
        } catch (\Exception $e) {
            $jsonArrayDataLog = [
                'operator' => $operator,
                'performed' => 'creation',
                'error_message' => $e->getMessage(),
            ];
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/author_create_error.log'),
            ])->error(json_encode($jsonArrayDataLog));
            session()->flash('status', $e->getMessage());
            $this->resetFields();
            return redirect()->to('/author')->with('status', $e->getMessage());
        }
    }

    /**
     * render
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.author.create-author');
    }
}
