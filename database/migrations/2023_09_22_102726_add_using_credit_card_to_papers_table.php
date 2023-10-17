<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsingCreditCardToPapersTable extends Migration
{
    public function up()
    {
        Schema::table('papers', function (Blueprint $table) {
            $table->boolean('is_using_credit_card')->default(false);
        });
    }
    public function down()
    {
        Schema::table('papers', function (Blueprint $table) {
            $table->dropColumn(['is_using_credit_card']);
        });
    }
}
