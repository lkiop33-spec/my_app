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
        Schema::table('work_lists', function (Blueprint $table) {
            $table->text('partList_enc')->nullable()->after('partList');
        });

        Schema::table('pcb_tables', function (Blueprint $table) {
            $table->text('Name_Type_enc')->nullable()->after('Name_Type');
            $table->text('Image_File_enc')->nullable()->after('Image_File');
        });

        Schema::table('part_tables', function (Blueprint $table) {
            $table->text('Name_enc')->nullable()->after('Name');
            $table->text('Process_Detail_enc')->nullable()->after('Process_Detail');
            $table->text('Image_File_enc')->nullable()->after('Image_File');
        });

        Schema::table('pcb_image_tables', function (Blueprint $table) {
            $table->text('Image_enc')->nullable()->after('Image');
            $table->text('BoundBox_enc')->nullable()->after('BoundBox');
            $table->text('Other_enc')->nullable()->after('Other');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_lists', function (Blueprint $table) {
            $table->dropColumn('partList_enc');
        });

        Schema::table('pcb_tables', function (Blueprint $table) {
            $table->dropColumn(['Name_Type_enc', 'Image_File_enc']);
        });

        Schema::table('part_tables', function (Blueprint $table) {
            $table->dropColumn(['Name_enc', 'Process_Detail_enc', 'Image_File_enc']);
        });

        Schema::table('pcb_image_tables', function (Blueprint $table) {
            $table->dropColumn(['Image_enc', 'BoundBox_enc', 'Other_enc']);
        });
    }
};
