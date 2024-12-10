<?php

namespace App\Livewire\Llm;

use Livewire\Component;
use EchoLabs\Prism\Prism;
use EchoLabs\Prism\Enums\Provider;
use EchoLabs\Prism\Exceptions\PrismException;

class RecodeResponse extends Component
{
    public string $llmSolution = '';

    private string $prismText = '';
    private bool $isError = false;
    private string $errorMessage = '';

    protected $listeners = [
        'sendQuery',
        'clearResponse',
    ];

    public function clearResponse()
    {
        $this->llmSolution = '';
        $this->dispatch('clearStatistic');
    }

    public function sendQuery($query)
    {
        $startTime = microtime(true);

        try {
            $prism = Prism::text()
                ->using(Provider::Ollama, 'dolphin-mistral')
                ->withPrompt($query)
                ->withClientOptions(['timeout' => 120])
                ->generate();

            $this->prismText = $prism->text;

            $this->llmSolution = ! empty($this->prismText) ? $this->prismText : "Sorry, I couldn't find a valid solution.";
        } catch (PrismException $pe) {
            $this->isError = true;
            $this->errorMessage = $pe->getMessage();
        }

        $elapsedTime = microtime(true) - $startTime;

        $data = [
            'query' => $query,
            'response' => $this->llmSolution,
            'elapsed' => $elapsedTime,
            'error' => $this->isError,
            'message' => $this->errorMessage,
        ];

        $this->dispatch(
            'grabData',
            data: $data,
        );
    }

    public function render()
    {
        return view('livewire.llm.recode-response');
    }
}
