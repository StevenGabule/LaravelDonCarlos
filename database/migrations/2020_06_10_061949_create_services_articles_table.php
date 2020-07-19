<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesArticlesTable extends Migration
{
    public function up(): void
    {
        Schema::create('services_articles', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('services_id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('slug');
            $table->text('short_description');
            $table->longText('description');
            $table->string('avatar')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('views')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services_articles');
    }
}
