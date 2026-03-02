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
        Schema::create('pcb_tables', function (Blueprint $table) {
            $table->id('idx');
            $table->timestamp('wdate')->useCurrent();
            $table->string('PCB_Number', 20)->unique();
            $table->string('Name_Type', 100);
            $table->string('Image_File', 100);
            $table->string('Image_Side', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pcb_tables');
    }
};
