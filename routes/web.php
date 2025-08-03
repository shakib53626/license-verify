<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/license-verify', function () {
    return Inertia::render('Adminend/License/Verify', [
        'route' => [
            'name' => Route::currentRouteName(),
        ],
    ]);
})->name('license.verify');
