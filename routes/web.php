<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Contact Routes
|--------------------------------------------------------------------------
|
| Hier definiëren we de routes voor de Contact package.
|
*/

Route::middleware(['web', 'auth:staff'])->prefix(config('manta-page.route_prefix'))
    ->name('page.')
    ->group(function () {
        Route::get("", Darvis\MantaPage\Livewire\Page\PageList::class)->name('list');
        Route::get("/toevoegen", Darvis\MantaPage\Livewire\Page\PageCreate::class)->name('create');
        Route::get("/aanpassen/{page}", Darvis\MantaPage\Livewire\Page\PageUpdate::class)->name('update');
        Route::get("/lezen/{page}", Darvis\MantaPage\Livewire\Page\PageRead::class)->name('read');
        Route::get("/bestanden/{page}", Darvis\MantaPage\Livewire\Page\PageUpload::class)->name('upload');
    });
