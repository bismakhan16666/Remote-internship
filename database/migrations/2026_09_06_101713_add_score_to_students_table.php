<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {//Lec 31
        Schema::table('students', function (Blueprint $table) {
            $table->integer('score')->nullable()->after('gender');
            // $table->string('score')->nullable()->after('gender');
            // $table->decimal('score', 5, 2)->nullable()->after('gender');
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('score');
        });
    }
};