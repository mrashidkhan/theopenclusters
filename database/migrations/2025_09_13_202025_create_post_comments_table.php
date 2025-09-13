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
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('post_comments')->onDelete('cascade'); // For nested comments

            // Commenter info
            $table->string('name');
            $table->string('email');
            $table->string('website')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();

            // Comment content
            $table->text('content');
            $table->enum('status', ['pending', 'approved', 'spam', 'rejected'])->default('pending');

            // Moderation
            $table->boolean('is_featured')->default(false);
            $table->integer('likes_count')->default(0);
            $table->integer('dislikes_count')->default(0);

            $table->timestamps();

            // Indexes
            $table->index(['post_id', 'status']);
            $table->index('parent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_comments');
    }
};
