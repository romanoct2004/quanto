<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePdfFileImageToInvoices extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['pdf_image_url']);
        });
    }
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('pdf_image_url', 2048);
        });
    }
}
