<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaranggaysTable extends Migration
{
    public function up(): void
    {
        /*id, name, short_description, description, population, address, avatar*/
        Schema::create('baranggays', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('slug');
            $table->text('short_description');
            $table->longText('description');
            $table->string('population');
            $table->text('address');
            $table->text('avatar')->nullable();
            $table->text('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baranggays');
    }
}
