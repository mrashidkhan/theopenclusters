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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt');
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->json('gallery_images')->nullable(); // Additional images

            // Relationships
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
            $table->foreignId('post_category_id')->constrained('post_categories')->onDelete('cascade');

            // SEO Fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('focus_keyword')->nullable();
            $table->string('canonical_url')->nullable();

            // Open Graph SEO
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('og_type')->default('article');

            // Twitter Card SEO
            $table->string('twitter_title')->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_image')->nullable();

            // Schema.org structured data
            $table->json('schema_data')->nullable();

            // Post Settings
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->boolean('allow_comments')->default(true);
            $table->datetime('published_at')->nullable();
            $table->integer('views_count')->default(0);
            $table->integer('reading_time')->nullable(); // in minutes

            $table->timestamps();

            // Indexes for better performance
            $table->index(['status', 'published_at']);
            $table->index('is_featured');
            $table->index('post_category_id');
            $table->index('staff_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
