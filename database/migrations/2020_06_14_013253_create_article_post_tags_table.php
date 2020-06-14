<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlePostTagsTable extends Migration
{
    public function up(): void
    {
        Schema::create('article_post_tags', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('post_id');
            $table->integer('tag_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_post_tags');
    }
}
