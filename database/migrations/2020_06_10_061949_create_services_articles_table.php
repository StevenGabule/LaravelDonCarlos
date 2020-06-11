<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesArticlesTable extends Migration
{
    public function up(): void
    {
        Schema::create('services_articles', static function (Blueprint $table) {
            $table->bigInteger('service_id');
            $table->text('description');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services_articles');
    }
}
