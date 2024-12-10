<?php

namespace App\Livewire\Llm;

use App\Models\Statistic;
use Livewire\Component;

class RecodeStatistic extends Component
{
    public int $timeElapsedInSecs = 0;

    protected $listeners = [
        'grabData',
        'clearStatistic',
    ];

    public function clearStatistic()
    {
        $this->timeElapsedInSecs = 0;
    }

    public function grabData($data) {
        $this->timeElapsedInSecs = $data['elapsed'];
        Statistic::create([
            'query' => $data['query'],
            'response' => $data['response'],
            'elapsed' => $data['elapsed'],
            'error' => $data['error'],
            'message' => $data['message'],
        ]);
    }

    public function render()
    {
        return view('livewire.llm.recode-statistic');
    }
}
