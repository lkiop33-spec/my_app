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
        Schema::create('work_lists', function (Blueprint $table) {
            $table->id('idx');
            $table->timestamp('wdate')->useCurrent();
            $table->string('partList', 200);
            $table->unsignedBigInteger('pcbIDX')->nullable();
            $table->unsignedBigInteger('memberIDX')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_lists');
    }
};
