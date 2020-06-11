<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    public function up(): void
    {
        Schema::create('services', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('short_description');
            $table->enum('service_type', ['1', '2'])->comment('1 - category, 2 - article');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
}
