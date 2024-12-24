<?php

use EchoLabs\Prism\Enums\FinishReason;
use EchoLabs\Prism\Enums\Provider;
use EchoLabs\Prism\Prism;
use EchoLabs\Prism\Providers\ProviderResponse;
use EchoLabs\Prism\ValueObjects\Usage;

test('basic LLM unit test', function () {

    $fakeProvidedResponse = new ProviderResponse(
        text: 'This is a basic LLM test!',
        toolCalls: [],
        usage: new Usage(10, 20),
        finishReason: FinishReason::Stop,
        response: ['id' => 'fake_provided_1', 'model' => 'fake_model']
    );

    $fakePrism = Prism::fake([$fakeProvidedResponse]);

    $prismResponse = Prism::text()
        ->using(Provider::Ollama, 'llama3.2')
        ->withPrompt('Hello!')
        ->generate();

    var_dump($prismResponse->text);

    expect($prismResponse->text)->toBe('This is a basic LLM test!');
});
