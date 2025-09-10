<?php

namespace Darvis\MantaPage\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manta-page:install
                            {--force : Overwrite existing files}
                            {--migrate : Run migrations after installation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Manta Page package';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Installing Manta Page Package...');
        $this->newLine();

        // Step 1: Publish configuration
        $this->publishConfiguration();

        // Step 2: Publish migrations
        $this->publishMigrations();

        // Step 3: Run migrations
        $this->runMigrations();

        // Step 4: Import module settings
        $this->importModuleSettings();

        // Step 5: Create default configuration
        $this->createDefaultConfiguration();

        // Step 6: Show completion message
        $this->showCompletionMessage();

        return self::SUCCESS;
    }

    /**
     * Publish configuration files
     */
    protected function publishConfiguration(): void
    {
        $this->info('📝 Publishing configuration files...');

        $params = [
            '--provider' => 'Darvis\MantaPage\PageServiceProvider',
            '--tag' => 'manta-page-config'
        ];

        if ($this->option('force')) {
            $params['--force'] = true;
        }

        Artisan::call('vendor:publish', $params);

        $this->line('   ✅ Configuration published to config/manta-page.php');
    }

    /**
     * Publish migration files
     */
    protected function publishMigrations(): void
    {
        $this->info('📦 Publishing migration files...');

        $params = [
            '--provider' => 'Darvis\MantaPage\PageServiceProvider',
            '--tag' => 'manta-page-migrations'
        ];

        if ($this->option('force')) {
            $params['--force'] = true;
        }

        Artisan::call('vendor:publish', $params);

        $this->line('   ✅ Migrations published to database/migrations/');
    }

    /**
     * Run database migrations
     */
    protected function runMigrations(): void
    {
        $this->info('🗄️  Running database migrations...');

        if ($this->confirm('This will run the database migrations. Continue?', true)) {
            Artisan::call('migrate');
            $this->line('   ✅ Migrations completed successfully');
        } else {
            $this->warn('   ⚠️  Migrations skipped. Run "php artisan migrate" manually later.');
        }
    }

    /**
     * Import module settings
     */
    protected function importModuleSettings(): void
    {
        $this->info('📋 Importing module settings...');

        try {
            Artisan::call('manta:import-module-settings', [
                'package' => 'darvis/manta-page',
                '--all' => true
            ]);

            $this->line('   ✅ Module settings imported successfully');
        } catch (\Exception $e) {
            $this->warn('   ⚠️  Module settings import failed: ' . $e->getMessage());
            $this->warn('   ⚠️  You can run this manually: php artisan manta:import-module-settings darvis/manta-page --all');
        }
    }

    /**
     * Create default configuration if it doesn't exist
     */
    protected function createDefaultConfiguration(): void
    {
        $this->info('⚙️  Setting up default configuration...');

        $configPath = config_path('manta-page.php');

        if (File::exists($configPath)) {
            $config = include $configPath;

            // Check if configuration needs updating
            if (!isset($config['route_prefix'])) {
                $this->warn('   ⚠️  Configuration file exists but may need manual updates');
            } else {
                $this->line('   ✅ Configuration file is ready');
            }
        } else {
            $this->error('   ❌ Configuration file not found. Please run the install command again.');
        }
    }

    /**
     * Show completion message with next steps
     */
    protected function showCompletionMessage(): void
    {
        $this->newLine();
        $this->info('🎉 Manta Page Package installed successfully!');
        $this->newLine();

        $this->comment('Next steps:');
        $this->line('1. Configure your settings in config/manta-page.php');

        if (!$this->option('migrate')) {
            $this->line('2. Run migrations: php artisan migrate');
        }

        $this->line('3. Access the page management at: /cms/page (or your configured route)');
        $this->newLine();

        $this->comment('Available routes:');
        $this->line('• GET /cms/page - Page list');
        $this->line('• GET /cms/page/toevoegen - Create new page');
        $this->line('• GET /cms/page/aanpassen/{id} - Edit page');
        $this->line('• GET /cms/page/lezen/{id} - View page');
        $this->line('• GET /cms/page/bestanden/{id} - Manage page files');
        $this->newLine();

        $this->info('📚 For more information, check the README.md file.');
    }
}
