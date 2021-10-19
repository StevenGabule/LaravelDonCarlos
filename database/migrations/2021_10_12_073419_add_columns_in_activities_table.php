<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInActivitiesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('activities', function (Blueprint $table) {
      $table->string('disk')->nullable();
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
    Schema::table('activities', function (Blueprint $table) {
      $table->dropColumn(['disk', 'upload_successful']);
    });
  }
}
