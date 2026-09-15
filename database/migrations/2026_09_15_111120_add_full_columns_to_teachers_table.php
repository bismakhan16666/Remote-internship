<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {
            if (!Schema::hasColumn('teachers', 'email')) {
                $table->string('email')->nullable()->unique()->after('name');
            }
            if (!Schema::hasColumn('teachers', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('teachers', 'qualification')) {
                $table->string('qualification')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('teachers', 'subject_specialization')) {
                $table->string('subject_specialization')->nullable()->after('qualification');
            }
            if (!Schema::hasColumn('teachers', 'experience')) {
                $table->string('experience')->nullable()->after('subject_specialization');
            }
            if (!Schema::hasColumn('teachers', 'image')) {
                $table->string('image')->nullable()->after('experience');
            }
            if (!Schema::hasColumn('teachers', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('image');
            }
        });
    }

    public function down()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn(['email', 'phone', 'qualification', 'subject_specialization', 'experience', 'image', 'status']);
        });
    }
};