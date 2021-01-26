<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    public function up(): void
    {

        Schema::create('activities', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('slug');
            $table->text('short_description');
            $table->longText('description');
            $table->date('event_start');
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->string('address');
            $table->tinyInteger('status')->nullable(0)->comment('0-d|1|p');
            $table->text('avatar')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
}
