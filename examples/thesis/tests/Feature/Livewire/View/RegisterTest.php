<?php

use Livewire\Volt\Volt;

it('can render', function () {
    $component = Volt::test('view.register');

    $component->assertSee('');
});
