<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    $samples = [
        [
            'available' => false,
            'imageName' => 'hologram_01.png',
        ],
        [
            'available' => false,
            'imageName' => 'hologram_02.png',
        ],
        [
            'available' => true,
            'imageName' => 'hologram_03.png',
        ],
        [
            'available' => false,
            'imageName' => 'hologram_04.png',
        ],
        [
            'available' => true,
            'imageName' => 'hologram_05.png',
        ],
        [
            'available' => false,
            'imageName' => 'hologram_06.png',
        ],
    ];
    return json_encode($samples);
});
