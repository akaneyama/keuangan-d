<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->string('receipt')->nullable()->after('description');
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->string('receipt')->nullable()->after('description');
        });
    }

    public function down()
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn('receipt');
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('receipt');
        });
    }
};
