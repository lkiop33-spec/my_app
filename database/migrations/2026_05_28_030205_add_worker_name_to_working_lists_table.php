<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('working_lists', function (Blueprint $table) {
            $table->string('worker_name', 100)->nullable()->after('no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('working_lists', function (Blueprint $table) {
            $table->dropColumn('worker_name');
        });
    }
};
