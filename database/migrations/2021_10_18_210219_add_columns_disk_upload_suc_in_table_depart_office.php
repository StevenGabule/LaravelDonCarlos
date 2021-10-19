<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsDiskUploadSucInTableDepartOffice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('department_offices', function (Blueprint $table) {
            $table->string('disk');
            $table->boolean('upload_successful');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('department_offices', function (Blueprint $table) {
            $table->dropColumn(['disk', 'upload_successful']);
        });
    }
}
