<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaranggaysTable extends Migration
{
    public function up(): void
    {
        Schema::create('baranggays', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('population');
            $table->string('address');
            $table->text('avatar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baranggays');
    }
}
