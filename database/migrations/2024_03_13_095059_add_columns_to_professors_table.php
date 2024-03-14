<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('professors', function (Blueprint $table) {
            $table->string('department')->after('name'); 
            $table->string('employment_status')->after('department'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() {
        Schema::table('professors', function (Blueprint $table) {
            $table->dropColumn('department');
            $table->dropColumn('employment_status');
        });
    }

};
