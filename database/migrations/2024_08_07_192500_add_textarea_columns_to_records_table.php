<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('records', function (Blueprint $table) {
            $table->text('textarea1')->nullable();
            $table->text('textarea2')->nullable();
            $table->text('textarea3')->nullable();
            $table->text('textarea4')->nullable();
            $table->text('textarea5')->nullable();
            $table->text('textarea6')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('records', function (Blueprint $table) {
            $table->dropColumn('textarea1');
            $table->dropColumn('textarea2');
            $table->dropColumn('textarea3');
            $table->dropColumn('textarea4');
            $table->dropColumn('textarea5');
            $table->dropColumn('textarea6');
        });
    }
};
