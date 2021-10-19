<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsDiskUploadSucInTableContentNeeds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('content_needs', function (Blueprint $table) {
            $table->string('disk');
            $table->boolean('upload_successful')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('content_needs', function (Blueprint $table) {
            $table->dropColumn(['disk', 'upload_successful']);
        });
    }
}
