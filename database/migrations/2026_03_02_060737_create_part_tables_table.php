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
        Schema::create('part_tables', function (Blueprint $table) {
            $table->id('idx');
            $table->timestamp('wdate')->useCurrent();
            $table->string('Part_Number', 20)->unique();
            $table->string('Name', 10);
            $table->integer('PCB_Number');
            $table->string('Process_Class', 100)->nullable();
            $table->string('Process_Name', 100)->nullable();
            $table->string('Process_Detail', 100)->unique()->nullable();
            $table->string('Side', 100)->nullable();
            $table->string('Image_File', 100)->nullable();
            $table->string('Quantity', 100)->nullable();
            $table->string('Location_1', 100)->nullable();
            $table->string('Location_2', 100)->nullable();
            $table->string('Location_3', 100)->nullable();
            $table->string('Location_4', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('part_tables');
    }
};
