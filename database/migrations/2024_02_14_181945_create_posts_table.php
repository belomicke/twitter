<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->string('text', 280);

            $table
                ->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->foreignId('retweeted_post_id')
                ->nullable()
                ->constrained('posts')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->foreignId('in_reply_to_post_id')
                ->nullable()
                ->constrained('posts')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->foreignId('in_reply_to_user_id')
                ->nullable()
                ->constrained('posts')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->integer('media_count')
                ->default(0);

            $table
                ->integer('like_count')
                ->default(0);

            $table
                ->integer('retweet_count')
                ->default(0);

            $table
                ->integer('reply_count')
                ->default(0);

            $table
                ->boolean('is_pinned')
                ->default(false);

            $table
                ->boolean('is_quote')
                ->default(false);

            $table
                ->boolean('is_deleted')
                ->default(false);

            $table->timestamps();
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
