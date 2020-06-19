<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    public function up(): void
    {
        Schema::create('places', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->text('slug');
            $table->text('short_description');
            $table->longText('description');
            $table->string('categories');
            $table->tinyInteger('status')->default(0)->comment('1-pub|2-unp');
            $table->string('address');
            $table->text('avatar')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('places');
    }
}
