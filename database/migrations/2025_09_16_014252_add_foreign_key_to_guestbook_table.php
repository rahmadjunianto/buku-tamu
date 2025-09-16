<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToGuestbookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guestbook', function (Blueprint $table) {
            $table->foreign('bidang')->references('id')->on('bidang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guestbook', function (Blueprint $table) {
            $table->dropForeign(['bidang']);
        });
    }
}
