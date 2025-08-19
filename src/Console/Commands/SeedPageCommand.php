<?php

namespace Darvis\MantaPage\Console\Commands;

use Darvis\MantaPage\Models\Page;
use Illuminate\Console\Command;

class SeedPageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manta-page:seed 
                            {--force : Force seeding even if pages already exist}
                            {--fresh : Delete existing pages before seeding}
                            {--with-navigation : Also seed navigation items for page management}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with sample pages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🌱 Seeding Manta Pages...');
        $this->newLine();

        // Check if pages already exist
        $existingCount = Page::count();
        
        if ($existingCount > 0 && !$this->option('force') && !$this->option('fresh')) {
            $this->warn("⚠️  Found {$existingCount} existing pages.");
            
            if (!$this->confirm('Do you want to continue seeding? This will add more items.', false)) {
                $this->info('Seeding cancelled.');
                return self::SUCCESS;
            }
        }

        // Handle fresh option
        if ($this->option('fresh')) {
            if ($this->confirm('This will delete ALL existing pages. Are you sure?', false)) {
                $this->info('🗑️  Deleting existing pages...');
                Page::truncate();
                $this->line('   ✅ Existing pages deleted');
            } else {
                $this->info('Fresh seeding cancelled.');
                return self::SUCCESS;
            }
        }

        // Run the seeder
        $this->info('📄 Creating sample pages...');
        
        try {
            $this->seedPageItems();
            
            $totalCount = Page::count();
            $this->newLine();
            $this->info("🎉 Page seeding completed successfully!");
            $this->line("   📊 Total pages in database: {$totalCount}");
            
        } catch (\Exception $e) {
            $this->error('❌ Error during seeding: ' . $e->getMessage());
            return self::FAILURE;
        }

        // Seed navigation if requested
        if ($this->option('with-navigation')) {
            $this->seedNavigation();
        }

        $this->newLine();
        $this->comment('💡 Tips:');
        $this->line('• Use --fresh to start with a clean slate');
        $this->line('• Use --force to skip confirmation prompts');
        $this->line('• Use --with-navigation to also seed navigation items');
        $this->line('• Check your page management interface to see the seeded items');
        
        return self::SUCCESS;
    }

    /**
     * Seed the page items into the database
     */
    private function seedPageItems(): void
    {
        $pageItems = [
            [
                'created_by' => 'Page Seeder',
                'updated_by' => null,
                'deleted_by' => null,
                'company_id' => 1,
                'host' => request()->getHost() ?? 'localhost',
                'pid' => null,
                'locale' => 'nl',
                'description' => 'Homepage van de website',
                'title' => 'Welkom op onze website',
                'title_2' => null,
                'title_3' => null,
                'title_4' => null,
                'slug' => 'home',
                'seo_title' => 'Welkom - Onze Website',
                'seo_description' => 'Welkom op onze website. Ontdek onze diensten en producten.',
                'excerpt' => 'De startpagina van onze website met alle belangrijke informatie.',
                'content' => '<h1>Welkom op onze website</h1><p>Dit is de homepage van onze website. Hier vindt u alle belangrijke informatie over onze organisatie.</p><p>Enkele hoogtepunten:</p><ul><li>Moderne website</li><li>Gebruiksvriendelijk</li><li>Responsive design</li><li>SEO-geoptimaliseerd</li></ul>',
                'template' => 'default',
                'homepage' => true,
                'homepageSort' => 1,
                'locked' => false,
                'fullpage' => false,
                'link' => null,
                'route' => null,
                'route_title' => null,
                'option_1' => false,
                'option_2' => false,
                'option_3' => false,
                'option_4' => false,
                'data' => json_encode([]),
            ],
            [
                'created_by' => 'Page Seeder',
                'updated_by' => null,
                'deleted_by' => null,
                'company_id' => 1,
                'host' => request()->getHost() ?? 'localhost',
                'pid' => null,
                'locale' => 'nl',
                'description' => 'Informatie over onze organisatie',
                'title' => 'Over ons',
                'title_2' => null,
                'title_3' => null,
                'title_4' => null,
                'slug' => 'over-ons',
                'seo_title' => 'Over ons - Onze Website',
                'seo_description' => 'Leer meer over onze organisatie, onze missie en onze waarden.',
                'excerpt' => 'Informatie over wie we zijn en wat we doen.',
                'content' => '<h1>Over ons</h1><p>Wij zijn een organisatie die zich inzet voor kwaliteit en innovatie. Onze missie is om de beste service te bieden aan onze klanten.</p><h2>Onze waarden</h2><ul><li>Kwaliteit</li><li>Innovatie</li><li>Betrouwbaarheid</li><li>Klanttevredenheid</li></ul><p>Neem gerust contact met ons op voor meer informatie.</p>',
                'template' => 'default',
                'homepage' => false,
                'homepageSort' => 0,
                'locked' => false,
                'fullpage' => false,
                'link' => null,
                'route' => null,
                'route_title' => null,
                'option_1' => false,
                'option_2' => false,
                'option_3' => false,
                'option_4' => false,
                'data' => json_encode([]),
            ],
            [
                'created_by' => 'Page Seeder',
                'updated_by' => null,
                'deleted_by' => null,
                'company_id' => 1,
                'host' => request()->getHost() ?? 'localhost',
                'pid' => null,
                'locale' => 'nl',
                'description' => 'Onze diensten en producten',
                'title' => 'Diensten',
                'title_2' => null,
                'title_3' => null,
                'title_4' => null,
                'slug' => 'diensten',
                'seo_title' => 'Diensten - Onze Website',
                'seo_description' => 'Ontdek onze uitgebreide dienstverlening en producten.',
                'excerpt' => 'Een overzicht van alle diensten die wij aanbieden.',
                'content' => '<h1>Onze diensten</h1><p>Wij bieden een breed scala aan diensten om aan uw behoeften te voldoen.</p><h2>Hoofddiensten</h2><ul><li>Consultancy</li><li>Ontwikkeling</li><li>Support</li><li>Training</li></ul><p>Voor meer informatie over onze specifieke diensten, neem contact met ons op.</p>',
                'template' => 'default',
                'homepage' => false,
                'homepageSort' => 0,
                'locked' => false,
                'fullpage' => false,
                'link' => null,
                'route' => null,
                'route_title' => null,
                'option_1' => false,
                'option_2' => false,
                'option_3' => false,
                'option_4' => false,
                'data' => json_encode([]),
            ],
            [
                'created_by' => 'Page Seeder',
                'updated_by' => null,
                'deleted_by' => null,
                'company_id' => 1,
                'host' => request()->getHost() ?? 'localhost',
                'pid' => null,
                'locale' => 'nl',
                'description' => 'Contactgegevens en contactformulier',
                'title' => 'Contact',
                'title_2' => null,
                'title_3' => null,
                'title_4' => null,
                'slug' => 'contact',
                'seo_title' => 'Contact - Onze Website',
                'seo_description' => 'Neem contact met ons op. Hier vindt u onze contactgegevens.',
                'excerpt' => 'Contactinformatie en mogelijkheden om contact op te nemen.',
                'content' => '<h1>Contact</h1><p>Wij staan altijd klaar om u te helpen. Neem gerust contact met ons op.</p><h2>Contactgegevens</h2><p><strong>Adres:</strong><br>Voorbeeldstraat 123<br>1234 AB Voorbeeldstad</p><p><strong>Telefoon:</strong> 012-3456789<br><strong>E-mail:</strong> info@voorbeeld.nl</p><h2>Openingstijden</h2><p>Maandag t/m vrijdag: 09:00 - 17:00<br>Zaterdag: 10:00 - 16:00<br>Zondag: Gesloten</p>',
                'template' => 'default',
                'homepage' => false,
                'homepageSort' => 0,
                'locked' => false,
                'fullpage' => false,
                'link' => null,
                'route' => null,
                'route_title' => null,
                'option_1' => false,
                'option_2' => false,
                'option_3' => false,
                'option_4' => false,
                'data' => json_encode([]),
            ],
        ];

        $created = 0;
        $existing = 0;

        foreach ($pageItems as $item) {
            // Check if page already exists based on slug and locale
            $existingPage = Page::where('slug', $item['slug'])
                ->where('locale', $item['locale'])
                ->first();

            if (!$existingPage) {
                Page::create($item);
                $this->info("   ✅ Page '{$item['title']}' created.");
                $created++;
            } else {
                $this->info("   ℹ️  Page '{$item['title']}' already exists.");
                $existing++;
            }
        }

        $this->info("   📊 {$created} pages created, {$existing} pages already existed.");
    }

    /**
     * Seed navigation items by calling the manta:seed-navigation command
     */
    private function seedNavigation(): void
    {
        $this->info('🧭 Seeding navigation items...');
        
        try {
            // First, call the general manta:seed-navigation command from manta-laravel-flux-cms
            $exitCode = $this->call('manta:seed-navigation', [
                '--force' => true // Always force navigation seeding
            ]);
            
            if ($exitCode === 0) {
                $this->info('   ✅ General navigation items seeded successfully.');
            } else {
                $this->warn('   ⚠️  General navigation seeding completed with warnings.');
            }
            
            // Then seed page-specific navigation items
            $this->seedPageNavigation();
            
        } catch (\Exception $e) {
            $this->warn('   ⚠️  Navigation seeding failed: ' . $e->getMessage());
            $this->warn('   💡 You can manually run "php artisan manta:seed-navigation" later.');
        }
    }

    /**
     * Seed page-specific navigation items
     */
    private function seedPageNavigation(): void
    {
        $this->info('📄 Seeding page navigation items...');
        
        try {
            // Check if MantaNav model exists
            if (!class_exists('\Manta\FluxCMS\Models\MantaNav')) {
                $this->warn('   ⚠️  MantaNav model not found. Skipping page navigation seeding.');
                return;
            }
            
            $pageNavItems = [
                [
                    'title' => 'Pagina\'s',
                    'route' => 'page.list',
                    'sort' => 5,
                    'type' => 'module',
                    'description' => 'Beheer pagina\'s'
                ]
            ];

            $MantaNav = '\Manta\FluxCMS\Models\MantaNav';
            $created = 0;
            $existing = 0;

            foreach ($pageNavItems as $item) {
                // Check if navigation item already exists
                $existingNav = $MantaNav::where('route', $item['route'])
                    ->where('locale', 'nl')
                    ->first();

                if (!$existingNav) {
                    $MantaNav::create([
                        'created_by' => 'Page Seeder',
                        'updated_by' => null,
                        'deleted_by' => null,
                        'company_id' => 1, // Default company
                        'host' => request()->getHost() ?? 'localhost',
                        'pid' => null,
                        'locale' => 'nl',
                        'active' => true,
                        'sort' => $item['sort'],
                        'title' => $item['title'],
                        'route' => $item['route'],
                        'url' => null,
                        'type' => $item['type'],
                        'rights' => null,
                        'data' => json_encode([
                            'description' => $item['description'],
                            'icon' => 'document-text',
                            'module' => 'manta-page'
                        ]),
                    ]);
                    
                    $this->info("   ✅ Page navigation item '{$item['title']}' created.");
                    $created++;
                } else {
                    $this->info("   ℹ️  Page navigation item '{$item['title']}' already exists.");
                    $existing++;
                }
            }
            
            $this->info("   📊 {$created} items created, {$existing} items already existed.");
            
        } catch (\Exception $e) {
            $this->warn('   ⚠️  Page navigation seeding failed: ' . $e->getMessage());
            $this->warn('   💡 This may be due to missing MantaNav model or database table.');
        }
    }
}
