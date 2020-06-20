<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaranggayOfficialsTable extends Migration
{
    public function up(): void
    {
        Schema::create('baranggay_officials', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('baranggay_id');
            $table->string('name');
            $table->enum('position', [1, 2, 3, 4, 5])
                ->default(1)
                ->comment('1-kagawad|2-Captain|3-SK|4-Secretary|5-treasurer');
            $table->unsignedBigInteger('from');
            $table->unsignedBigInteger('to');
            $table->enum('status', [1,0])->default(0);
            $table->text('avatar')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('baranggay_id')->references('id')->on('baranggays')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baranggay_officials');
    }
}
