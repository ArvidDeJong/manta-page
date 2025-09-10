# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.1.1] - 2025-09-10

### Changed

- Upgraded to stable release version 1.0.0
- Production-ready release with all core features tested and validated

## [0.1.0] - 2024-08-19

### Added

- Complete page management system for Manta CMS
- Full CRUD functionality for pages via Livewire v3 components
- Multi-language support via HasTranslationsTrait
- SEO optimization fields (seo_title, seo_description, slug)
- Template system support with flexible template assignment
- Homepage management functionality with sorting capabilities
- File upload integration via HasUploadsTrait
- FluxUI components for modern, consistent design
- Database migration for manta_pages table
- Configuration system via manta-page.php config file
- Install command for automated setup (manta-page:install)
- PageTrait for reusable Livewire functionality
- Dutch language support for validation messages
- Search and filter capabilities in page listings

### Features

- **Page Model**: Complete page management with multilingual support
- **Content Management**: Rich text content with excerpt support
- **SEO Optimization**: Dedicated fields for search engine optimization
- **Template System**: Flexible template assignment and management
- **Homepage Control**: Designate and sort homepage content
- **Multi-tenancy**: Full company/tenant isolation support
- **Audit Trail**: Complete tracking (created_by, updated_by, deleted_by)
- **Soft Deletes**: Data safety with recoverable deletions
- **File Management**: Integrated upload and media management
- **Boolean Options**: Four configurable option fields (option_1 to option_4)
- **Fullpage Mode**: Support for fullpage layout templates
- **Lock System**: Page locking functionality for content protection

### Technical

- Laravel 12 compatibility
- PHP 8.2+ requirement
- Livewire v3 integration
- FluxUI component library
- Tailwind CSS v4 styling
- PSR-4 autoloading
- Comprehensive test suite
- Service provider auto-discovery
