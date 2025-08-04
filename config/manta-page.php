<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Manta Page Configuration
    |--------------------------------------------------------------------------
    |
    | Hier kan je de configuratie voor de Manta Page package aanpassen.
    |
    */

    // Route prefix voor de page module
    'route_prefix' => 'cms/page',

    // Database instellingen
    'database' => [
        'table_name' => 'manta_pages',
    ],

    // UI instellingen
    'ui' => [
        'items_per_page' => 25,
        'show_breadcrumbs' => true,
    ],


];
