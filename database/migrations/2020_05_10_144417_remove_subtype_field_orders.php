<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSubtypeFieldOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function ($table) {
            $table->dropColumn('subtype');
        });
//        Schema::table('files', function ($table) {
//            $table->string('original_name');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function ($table) {
            $table->integer('subtype')->nullable;
        });
//        Schema::table('files', function ($table) {
//            $table->dropColumn('original_name');
//        });
    }
}
