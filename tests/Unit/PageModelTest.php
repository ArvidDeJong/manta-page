<?php

use Darvis\MantaPage\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Page Model', function () {
    
    test('kan een page aanmaken met basis attributen', function () {
        $page = Page::create([
            'title' => 'Test Pagina',
            'slug' => 'test-pagina',
            'content' => 'Dit is test content',
            'locale' => 'nl',
            'active' => true,
        ]);

        expect($page)->toBeInstanceOf(Page::class);
        expect($page->title)->toBe('Test Pagina');
        expect($page->slug)->toBe('test-pagina');
        expect($page->content)->toBe('Dit is test content');
        expect($page->locale)->toBe('nl');
        expect($page->active)->toBeTrue();
    });

    test('gebruikt de juiste database tabel', function () {
        $page = new Page();
        expect($page->getTable())->toBe('manta_pages');
    });

    test('heeft de juiste fillable attributen', function () {
        $page = new Page();
        $fillable = $page->getFillable();
        
        expect($fillable)->toContain('title');
        expect($fillable)->toContain('slug');
        expect($fillable)->toContain('content');
        expect($fillable)->toContain('locale');
        expect($fillable)->toContain('seo_title');
        expect($fillable)->toContain('seo_description');
        expect($fillable)->toContain('homepage');
        expect($fillable)->toContain('data');
    });

    test('cast boolean attributen correct', function () {
        $page = Page::create([
            'title' => 'Test',
            'option_1' => true,
            'option_2' => false,
            'option_3' => 1,
            'option_4' => 0,
        ]);

        expect($page->option_1)->toBeTrue();
        expect($page->option_2)->toBeFalse();
        expect($page->option_3)->toBeTrue();
        expect($page->option_4)->toBeFalse();
    });

    test('cast data attribuut naar array', function () {
        $testData = ['key1' => 'value1', 'key2' => 'value2'];
        
        $page = Page::create([
            'title' => 'Test',
            'data' => $testData,
        ]);

        expect($page->data)->toBeArray();
        expect($page->data)->toBe($testData);
    });

    test('getDataAttribute geeft lege array terug voor null waarde', function () {
        $page = new Page();
        $page->setRawAttributes(['data' => null]);
        
        expect($page->getDataAttribute(null))->toBe([]);
    });

    test('getDataAttribute decodeert JSON correct', function () {
        $page = new Page();
        $jsonData = '{"test": "value", "number": 123}';
        
        $result = $page->getDataAttribute($jsonData);
        
        expect($result)->toBeArray();
        expect($result['test'])->toBe('value');
        expect($result['number'])->toBe(123);
    });

    test('gebruikt soft deletes', function () {
        $page = Page::create([
            'title' => 'Test Delete',
            'slug' => 'test-delete',
        ]);

        $pageId = $page->id;
        
        // Soft delete
        $page->delete();
        
        // Pagina is niet meer zichtbaar in normale queries
        expect(Page::find($pageId))->toBeNull();
        
        // Maar wel zichtbaar met withTrashed
        expect(Page::withTrashed()->find($pageId))->not->toBeNull();
        expect(Page::withTrashed()->find($pageId)->trashed())->toBeTrue();
    });

    test('kan homepage status instellen', function () {
        $page = Page::create([
            'title' => 'Homepage',
            'homepage' => true,
            'homepageSort' => 1,
        ]);

        expect($page->homepage)->toBeTrue();
        expect($page->homepageSort)->toBe(1);
    });

    test('heeft standaard waarden voor bepaalde velden', function () {
        $page = new Page();
        
        // Check default casts
        expect($page->getCasts()['option_1'])->toBe('boolean');
        expect($page->getCasts()['option_2'])->toBe('boolean');
        expect($page->getCasts()['option_3'])->toBe('boolean');
        expect($page->getCasts()['option_4'])->toBe('boolean');
        expect($page->getCasts()['data'])->toBe('array');
    });

    test('getMantaAttribute geeft juiste waarde terug voor bestaande pagina', function () {
        $page = Page::create([
            'title' => 'Test Pagina Titel',
            'content' => 'Test content',
            'slug' => 'test-slug',
        ]);

        // Capture output
        ob_start();
        Page::getMantaAttribute($page->id, 'title');
        $output = ob_get_clean();

        expect($output)->toBe('Test Pagina Titel');
    });

    test('getMantaAttribute geeft foutmelding voor niet-bestaande pagina', function () {
        ob_start();
        Page::getMantaAttribute(99999, 'title');
        $output = ob_get_clean();

        expect($output)->toBe('Page not found');
    });

    test('getMantaAttribute geeft foutmelding voor niet-bestaand attribuut', function () {
        $page = Page::create([
            'title' => 'Test',
        ]);

        ob_start();
        Page::getMantaAttribute($page->id, 'non_existent_attribute');
        $output = ob_get_clean();

        expect($output)->toBe('Attribute not found');
    });

    test('kan SEO velden instellen', function () {
        $page = Page::create([
            'title' => 'Test Pagina',
            'seo_title' => 'SEO Titel',
            'seo_description' => 'Dit is een SEO beschrijving',
        ]);

        expect($page->seo_title)->toBe('SEO Titel');
        expect($page->seo_description)->toBe('Dit is een SEO beschrijving');
    });

    test('kan routing velden instellen', function () {
        $page = Page::create([
            'title' => 'Test',
            'route' => 'custom.route',
            'route_title' => 'Custom Route Title',
            'link' => 'https://example.com',
        ]);

        expect($page->route)->toBe('custom.route');
        expect($page->route_title)->toBe('Custom Route Title');
        expect($page->link)->toBe('https://example.com');
    });

    test('kan template en page opties instellen', function () {
        $page = Page::create([
            'title' => 'Test',
            'template' => 'custom-template',
            'locked' => true,
            'fullpage' => true,
        ]);

        expect($page->template)->toBe('custom-template');
        expect($page->locked)->toBeTrue();
        expect($page->fullpage)->toBeTrue();
    });

    test('kan multi-tenancy velden instellen', function () {
        $page = Page::create([
            'title' => 'Test',
            'company_id' => 123,
            'host' => 'example.com',
        ]);

        expect($page->company_id)->toBe(123);
        expect($page->host)->toBe('example.com');
    });

    test('kan audit trail velden instellen', function () {
        $page = Page::create([
            'title' => 'Test',
            'created_by' => 'user123',
            'updated_by' => 'user456',
        ]);

        expect($page->created_by)->toBe('user123');
        expect($page->updated_by)->toBe('user456');
    });
});
