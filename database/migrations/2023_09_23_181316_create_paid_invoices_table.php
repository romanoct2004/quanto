<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaidInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('paid_invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('email');
            $table->string('name');
            $table->string('kana');
            $table->string('zip_code');
            $table->string('address1', 512);
            $table->string('address2', 512);
            $table->string('address3')->nullable();
            $table->string('phone_number');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paid_invoices');
    }
}
