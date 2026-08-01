<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUniqueFromInvoiceNumberOnGstBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gst_bills', function (Blueprint $table) {
            $table->dropUnique('gst_bills_invoice_number_unique');
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
            $table->unique('invoice_number');
        });
    }
}
