<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->date('birth');

            $table->string('profile_picture_path')->default('/profile_images/default-profile-picture.png');
            $table->string('profile_banner_path')->default('');

            $table->string('bio', 160)->default('');
            $table->string('location', 30)->default('');
            $table->string('link', 100)->default('');

            $table->integer('posts_count')->default(0);
            $table->integer('follows_count')->default(0);
            $table->integer('followers_count')->default(0);

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
