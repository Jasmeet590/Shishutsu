<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDeletedToGstBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gst_bills', function (Blueprint $table) {
            $table->tinyInteger('is_deleted')->default(0)->after('declaration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gst_bills', function (Blueprint $table) {
            $table->dropColumn('is_deleted');
        });
    }
}
