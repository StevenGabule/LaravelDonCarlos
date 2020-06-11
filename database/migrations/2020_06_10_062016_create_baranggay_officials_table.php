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
                ->comment('1 - kagawad, 2 - Punong, 3 - SK chairman, 4 - Secretary, 5 - treasurer');
            $table->string('date_register');
            $table->timestamps();
            $table->foreign('baranggay_id')->references('id')->on('baranggays')->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baranggay_officials');
    }
}
