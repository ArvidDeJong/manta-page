<?php

namespace Darvis\MantaPage;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class PageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register package services
        $this->mergeConfigFrom(
            __DIR__ . '/../config/manta-page.php',
            'manta-page'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Publiceer configuratie
        $this->publishes([
            __DIR__ . '/../config/manta-page.php' => config_path('manta-page.php'),
        ], 'manta-page-config');

        // Publiceer migrations
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'manta-page-migrations');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'manta-page');

        // Register console commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Darvis\MantaPage\Console\Commands\InstallCommand::class,
            ]);
        }

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Register Livewire components
        $this->registerLivewireComponents();
    }

    /**
     * Register all Livewire components
     */
    private function registerLivewireComponents(): void
    {
        // Page components
        Livewire::component('page.page-create', \Darvis\MantaPage\Livewire\Page\PageCreate::class);
        Livewire::component('page.page-list', \Darvis\MantaPage\Livewire\Page\PageList::class);
        Livewire::component('page.page-read', \Darvis\MantaPage\Livewire\Page\PageRead::class);
        Livewire::component('page.page-update', \Darvis\MantaPage\Livewire\Page\PageUpdate::class);
        Livewire::component('page.page-upload', \Darvis\MantaPage\Livewire\Page\PageUpload::class);
    }
}
