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
        Schema::create('pcb_image_tables', function (Blueprint $table) {
            $table->id('idx');
            $table->timestamp('wdate')->useCurrent();
            $table->integer('PCB_Number');
            $table->string('Image', 100);
            $table->string('BoundBox', 100)->nullable();
            $table->string('Other', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pcb_image_tables');
    }
};
