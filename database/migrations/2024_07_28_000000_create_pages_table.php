<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('manta_pages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            // Audit trail fields
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();

            // Multi-tenancy
            $table->integer('company_id')->nullable();

            // System fields
            $table->string('host')->nullable();
            $table->integer('pid')->nullable();
            $table->string('locale')->nullable();
            $table->boolean('active')->default(true);
            $table->integer('sort')->default(1);

            // Content fields
            $table->string('description')->nullable();
            $table->string('title')->nullable();
            $table->string('title_2')->nullable();
            $table->string('title_3')->nullable();
            $table->string('title_4')->nullable();
            $table->string('slug')->nullable();

            // SEO fields
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();

            // Routing fields
            $table->string('route')->nullable();
            $table->string('route_title')->nullable();

            // Content fields
            $table->text('tags')->nullable();
            $table->longText('excerpt')->nullable();
            $table->longText('content')->nullable();

            // Homepage settings
            $table->boolean('homepage')->default(false);
            $table->integer('homepageSort')->default(99);

            // Page settings
            $table->string('link')->nullable();
            $table->boolean('locked')->default(false);
            $table->boolean('fullpage')->default(false);
            $table->string('template')->nullable();

            // Administration fields
            $table->string('administration')->nullable()->comment('Administration column');
            $table->string('identifier')->nullable()->comment('Identifier column');

            // Flexible data storage
            $table->longText('data')->nullable();

            // Option fields
            $table->boolean('option_1')->default(false);
            $table->boolean('option_2')->default(false);
            $table->boolean('option_3')->default(false);
            $table->boolean('option_4')->default(false);

            // Indexes for performance
            $table->index(['active', 'sort']);
            $table->index(['company_id']);
            $table->index(['slug']);
            $table->index(['homepage', 'homepageSort']);
            $table->index(['locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
