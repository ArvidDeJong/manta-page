<?php

use Darvis\MantaPage\Livewire\Page\PageCreate;

describe('PageCreate Livewire Component', function () {
    
    test('class bestaat en heeft juiste parent class', function () {
        expect(class_exists(PageCreate::class))->toBeTrue();
        expect(is_subclass_of(PageCreate::class, \Livewire\Component::class))->toBeTrue();
    });

    test('heeft de juiste layout attribute', function () {
        $reflection = new ReflectionClass(PageCreate::class);
        $attributes = $reflection->getAttributes();
        
        $layoutAttribute = null;
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === 'Livewire\Attributes\Layout') {
                $layoutAttribute = $attribute;
                break;
            }
        }
        
        expect($layoutAttribute)->not->toBeNull();
        expect($layoutAttribute->getArguments()[0])->toBe('manta-cms::layouts.app');
    });

    test('gebruikt de juiste traits', function () {
        $reflection = new ReflectionClass(PageCreate::class);
        $traits = $reflection->getTraitNames();
        
        expect($traits)->toContain('Manta\FluxCMS\Traits\MantaTrait');
        expect($traits)->toContain('Darvis\MantaPage\Traits\PageTrait');
    });

    test('component heeft de juiste namespace', function () {
        $reflection = new ReflectionClass(PageCreate::class);
        
        expect($reflection->getNamespaceName())->toBe('Darvis\MantaPage\Livewire\Page');
        expect($reflection->getShortName())->toBe('PageCreate');
    });

    test('component extends Livewire Component', function () {
        $reflection = new ReflectionClass(PageCreate::class);
        
        expect($reflection->getParentClass()->getName())->toBe('Livewire\Component');
    });

    test('heeft alle verwachte public methods', function () {
        $reflection = new ReflectionClass(PageCreate::class);
        $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        $methodNames = array_map(fn($method) => $method->getName(), $methods);
        
        expect($methodNames)->toContain('mount');
        expect($methodNames)->toContain('render');
        expect($methodNames)->toContain('save');
    });

    test('mount method heeft juiste signature', function () {
        $reflection = new ReflectionClass(PageCreate::class);
        $mountMethod = $reflection->getMethod('mount');
        $parameters = $mountMethod->getParameters();
        
        expect($parameters)->toHaveCount(1);
        expect($parameters[0]->getName())->toBe('request');
        expect($parameters[0]->getType()->getName())->toBe('Illuminate\Http\Request');
    });

    test('render method heeft geen parameters', function () {
        $reflection = new ReflectionClass(PageCreate::class);
        $renderMethod = $reflection->getMethod('render');
        $parameters = $renderMethod->getParameters();
        
        expect($parameters)->toHaveCount(0);
    });

    test('save method heeft geen parameters', function () {
        $reflection = new ReflectionClass(PageCreate::class);
        $saveMethod = $reflection->getMethod('save');
        $parameters = $saveMethod->getParameters();
        
        expect($parameters)->toHaveCount(0);
    });

    test('class gebruikt de juiste imports', function () {
        $reflection = new ReflectionClass(PageCreate::class);
        $fileName = $reflection->getFileName();
        $fileContent = file_get_contents($fileName);
        
        expect($fileContent)->toContain('use Darvis\MantaPage\Models\Page;');
        expect($fileContent)->toContain('use Manta\FluxCMS\Traits\MantaTrait;');
        expect($fileContent)->toContain('use Illuminate\Http\Request;');
        expect($fileContent)->toContain('use Livewire\Component;');
        expect($fileContent)->toContain('use Faker\Factory as Faker;');
        expect($fileContent)->toContain('use Illuminate\Support\Str;');
        expect($fileContent)->toContain('use Darvis\MantaPage\Traits\PageTrait;');
        expect($fileContent)->toContain('use Livewire\Attributes\Layout;');
    });

    test('save method gebruikt de juiste model fields', function () {
        $reflection = new ReflectionClass(PageCreate::class);
        $saveMethod = $reflection->getMethod('save');
        $fileName = $reflection->getFileName();
        $fileContent = file_get_contents($fileName);
        
        // Controleer dat save method de juiste velden gebruikt
        expect($fileContent)->toContain('$this->only(');
        expect($fileContent)->toContain("'title'");
        expect($fileContent)->toContain("'slug'");
        expect($fileContent)->toContain("'content'");
        expect($fileContent)->toContain("'seo_title'");
        expect($fileContent)->toContain("'seo_description'");
        expect($fileContent)->toContain("'homepage'");
        expect($fileContent)->toContain("'locked'");
        expect($fileContent)->toContain("'fullpage'");
    });

    test('mount method gebruikt faker wanneer enabled', function () {
        $reflection = new ReflectionClass(PageCreate::class);
        $fileName = $reflection->getFileName();
        $fileContent = file_get_contents($fileName);
        
        // Controleer dat faker logica aanwezig is
        expect($fileContent)->toContain("env('USE_FAKER')");
        expect($fileContent)->toContain('Faker::create');
        expect($fileContent)->toContain('$faker->sentence');
        expect($fileContent)->toContain('$faker->text');
        expect($fileContent)->toContain('$faker->paragraphs');
        expect($fileContent)->toContain('Str::slug');
    });

    test('save method genereert slug automatisch', function () {
        $reflection = new ReflectionClass(PageCreate::class);
        $fileName = $reflection->getFileName();
        $fileContent = file_get_contents($fileName);
        
        // Controleer dat slug automatisch wordt gegenereerd
        expect($fileContent)->toContain('Str::of($this->title)->slug');
    });

    test('save method zet audit trail velden', function () {
        $reflection = new ReflectionClass(PageCreate::class);
        $fileName = $reflection->getFileName();
        $fileContent = file_get_contents($fileName);
        
        // Controleer dat audit trail velden worden ingesteld
        expect($fileContent)->toContain("'created_by'");
        expect($fileContent)->toContain("auth('staff')->user()->name");
        expect($fileContent)->toContain("'host'");
        expect($fileContent)->toContain('request()->host()');
    });

    test('save method redirect naar read route', function () {
        $reflection = new ReflectionClass(PageCreate::class);
        $fileName = $reflection->getFileName();
        $fileContent = file_get_contents($fileName);
        
        // Controleer dat redirect naar read route gebeurt
        expect($fileContent)->toContain('$this->redirect');
        expect($fileContent)->toContain("route('page.read'");
    });
});
