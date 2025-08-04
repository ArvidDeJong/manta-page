# Manta Page Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/darvis/manta-page.svg?style=flat-square)](https://packagist.org/packages/darvis/manta-page)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

Een Laravel package voor het beheren van pagina's en content. Deze module integreert naadloos met het **darvis/manta-laravel-flux-cms** systeem en biedt een complete oplossing voor pagina beheer.

## Features

-   📄 **Pagina Beheer**: Volledige CRUD functionaliteit voor pagina's
-   📝 **Content Management**: Uitgebreid systeem voor het beheren van content
-   🌍 **Meertalig**: Ondersteuning voor meerdere talen via Manta CMS
-   📁 **Bestandsbeheer**: Geïntegreerde upload functionaliteit voor afbeeldingen en documenten
-   🔍 **Zoek & Filter**: Geavanceerde zoek- en filtermogelijkheden
-   🎨 **Template Systeem**: Flexibele template ondersteuning
-   🔗 **SEO Optimalisatie**: Uitgebreide SEO velden en slug beheer
-   🏠 **Homepage Beheer**: Speciale homepage functionaliteit

## Installatie

### Stap 1: Package installeren

```bash
composer require darvis/manta-page:@dev
```

### Stap 2: Package configureren

```bash
php artisan manta-page:install
```

### Stap 3: Module settings importeren

```bash
# Page module importeren
php artisan manta:import-module-settings darvis/manta-page --settings-file=export/settings-page.php
```

### Stap 4: Database migraties uitvoeren

```bash
php artisan migrate
```

## Beschikbare Routes

Na installatie zijn de volgende routes beschikbaar:

### Pagina Beheer

-   `GET /cms/page` - Overzicht van pagina's
-   `GET /cms/page/toevoegen` - Nieuwe pagina aanmaken
-   `GET /cms/page/aanpassen/{id}` - Pagina bewerken
-   `GET /cms/page/lezen/{id}` - Pagina bekijken
-   `GET /cms/page/bestanden/{id}` - Bestanden beheer

### Basis Gebruik

```php
use Darvis\MantaPage\Models\Page;

// Nieuwe pagina aanmaken
$page = Page::create([
    'title' => 'Over Ons',
    'description' => 'Informatie over ons bedrijf',
    'content' => 'Welkom bij ons bedrijf. Wij zijn...',
    'slug' => 'over-ons',
    'seo_title' => 'Over Ons - Bedrijfsnaam',
    'seo_description' => 'Leer meer over ons bedrijf en onze missie',
    'active' => true,
    'template' => 'default'
]);

// Homepage instellen
$homepage = Page::create([
    'title' => 'Welkom',
    'content' => 'Welkom op onze website!',
    'homepage' => true,
    'homepageSort' => 1,
    'active' => true
]);
```

## Documentation

For detailed documentation, please see the `/docs` directory:

-   📚 **[Installation Guide](docs/installation.md)** - Complete installation instructions
-   ⚙️ **[Configuration](docs/configuration.md)** - Configuration options and settings
-   🚀 **[Usage Guide](docs/usage.md)** - How to use the package
-   🗄️ **[Database Schema](docs/database.md)** - Complete database documentation
-   🔧 **[Troubleshooting](docs/troubleshooting.md)** - Common issues and solutions
-   🔌 **[API Documentation](docs/api.md)** - Programmatic usage and API endpoints

## Requirements

-   PHP ^8.2
-   Laravel ^12.0
-   darvis/manta-laravel-flux-cms

## Integration with Manta CMS

This module is specifically designed for integration with the Manta Laravel Flux CMS:

-   **Livewire v3**: All UI components are Livewire components
-   **FluxUI**: Consistent design with the CMS
-   **Manta Traits**: Reuse of CMS functionality
-   **Multi-tenancy**: Support for multiple companies
-   **Audit Trail**: Complete logging of changes
-   **Soft Deletes**: Safe data deletion

## Support

For support and questions:

-   📧 Email: info@arvid.nl
-   🌐 Website: [arvid.nl](https://arvid.nl)
-   📖 Documentation: See the `/docs` directory for comprehensive guides
-   🐛 Issues: Create an issue in the repository

## Contributing

Contributions are welcome! See [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

## Security

If you discover a security issue, please send an email to info@arvid.nl.

## License

The MIT License (MIT). See [License File](LICENSE.md) for more information.

## Credits

-   [Darvis](https://github.com/darvis)
-   [All contributors](../../contributors)
