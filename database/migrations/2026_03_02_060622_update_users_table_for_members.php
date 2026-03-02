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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('location')->nullable();
            $table->unsignedBigInteger('part')->nullable(); // Department/part
            $table->string('account_id', 20)->unique()->nullable();
            $table->timestamp('last_access')->nullable();
            $table->unsignedBigInteger('level')->nullable();
            $table->string('phone', 100)->nullable();
            $table->string('interphone', 100)->nullable();
            $table->string('photo', 100)->nullable();
            $table->timestamp('join_date')->nullable();
            
            // Note: email, password, name are already in the default users table.
            // We use integer values for location, part, and level as they look like foreign keys
            // to locations, parts, and levels tables.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'location',
                'part',
                'account_id',
                'last_access',
                'level',
                'phone',
                'interphone',
                'photo',
                'join_date'
            ]);
        });
    }
};
