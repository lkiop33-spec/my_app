<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InfacDummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        $tables = [
            'locations', 'parts', 'levels', 'types', 'languages', 'forbiddens', 
            'devices', 'process_tables', 'pcb_tables', 'part_tables', 
            'pcb_image_tables', 'doc_lists', 'work_lists'
        ];
        
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Locations (name: 10, address: 100, phone: 100)
        DB::table('locations')->insert([
            ['name' => '1공장 SMT', 'address' => '충북 충주시 1공장 1층', 'phone' => '043-850-0001', 'wdate' => $now],
            ['name' => '2공장 조립', 'address' => '충북 충주시 2공장 2층', 'phone' => '043-850-0003', 'wdate' => $now],
            ['name' => '품질검사실', 'address' => '충북 충주시 1공장 2층', 'phone' => '043-850-0004', 'wdate' => $now],
            ['name' => '메인자재창고', 'address' => '충북 충주시 1공장 지하', 'phone' => '043-850-0005', 'wdate' => $now],
        ]);

        // 2. Parts (name: 10, level: int)
        DB::table('parts')->insert([
            ['name' => 'SMT 파트', 'level' => 1, 'wdate' => $now],
            ['name' => '조립 파트', 'level' => 1, 'wdate' => $now],
            ['name' => 'QA 파트', 'level' => 2, 'wdate' => $now],
            ['name' => '생기 파트', 'level' => 3, 'wdate' => $now],
        ]);

        // 3. Levels (name: 10, level: int)
        DB::table('levels')->insert([
            ['name' => '수습사원', 'level' => 1, 'wdate' => $now],
            ['name' => '숙련공', 'level' => 2, 'wdate' => $now],
            ['name' => '라인반장', 'level' => 3, 'wdate' => $now],
            ['name' => '공정관리자', 'level' => 4, 'wdate' => $now],
        ]);

        // 4. Types (mtype: 10)
        DB::table('types')->insert([
            ['mtype' => '작업표준서', 'wdate' => $now],
            ['mtype' => '도면(CAD)', 'wdate' => $now],
            ['mtype' => '검사기준서', 'wdate' => $now],
            ['mtype' => '안전수칙', 'wdate' => $now],
        ]);

        // 5. Languages (mlanguage: 10)
        DB::table('languages')->insert([
            ['mlanguage' => 'Korean', 'wdate' => $now],
            ['mlanguage' => 'English', 'wdate' => $now],
            ['mlanguage' => 'Vietnamese', 'wdate' => $now],
            ['mlanguage' => 'Nepali', 'wdate' => $now],
            ['mlanguage' => 'Indonesian', 'wdate' => $now],
        ]);

        // 6. Forbiddens (text: 10)
        DB::table('forbiddens')->insert([
            ['text' => '불량은폐', 'wdate' => $now],
            ['text' => '안전불감증', 'wdate' => $now],
            ['text' => '임의조작', 'wdate' => $now],
        ]);

        // 7. Devices (name: 20, password: 20, version: 20, location: int)
        DB::table('devices')->insert([
            ['name' => 'SMT_Term_01', 'password' => 'pass01', 'location' => 1, 'version' => '1.0.5', 'wdate' => $now],
            ['name' => 'SMT_Term_02', 'password' => 'pass02', 'location' => 1, 'version' => '1.0.5', 'wdate' => $now],
            ['name' => 'DIP_Term_01', 'password' => 'pass03', 'location' => 2, 'version' => '1.0.4', 'wdate' => $now],
            ['name' => 'AOI_Term_01', 'password' => 'pass04', 'location' => 3, 'version' => '1.2.0', 'wdate' => $now],
        ]);

        // 8. ProcessTables (Code: 100, Name: 10, Class: 100)
        DB::table('process_tables')->insert([
            ['Code' => 'P_Solder', 'Name' => '솔더인쇄', 'Class' => 'SMT', 'Sequence' => 1, 'wdate' => $now],
            ['Code' => 'P_Mount', 'Name' => '칩마운터', 'Class' => 'SMT', 'Sequence' => 2, 'wdate' => $now],
            ['Code' => 'P_Reflow', 'Name' => '리플로우', 'Class' => 'SMT', 'Sequence' => 3, 'wdate' => $now],
            ['Code' => 'P_Insert', 'Name' => '수삽공정', 'Class' => 'DIP', 'Sequence' => 4, 'wdate' => $now],
            ['Code' => 'P_Wave', 'Name' => '웨이브솔더', 'Class' => 'DIP', 'Sequence' => 5, 'wdate' => $now],
            ['Code' => 'P_AOI', 'Name' => '광학검사', 'Class' => 'INSP', 'Sequence' => 6, 'wdate' => $now],
        ]);

        // 9. PcbTables (PCB_Number: 20, Name_Type: 100)
        DB::table('pcb_tables')->insert([
            ['PCB_Number' => 'INF-ECU-01', 'Name_Type' => '엔진컨트롤유닛 메인보드', 'Image_File' => 'ecu_main.jpg', 'Image_Side' => 'TOP', 'wdate' => $now],
            ['PCB_Number' => 'INF-SW-01', 'Name_Type' => '스티어링휠 스위치 보드', 'Image_File' => 'wheel_sw.jpg', 'Image_Side' => 'TOP', 'wdate' => $now],
            ['PCB_Number' => 'INF-BCM-01', 'Name_Type' => '차체제어모듈(BCM)', 'Image_File' => 'bcm_top.jpg', 'Image_Side' => 'TOP', 'wdate' => $now],
        ]);

        // 10. PartTables (Part_Number: 20, Name: 10, PCB_Number: int)
        DB::table('part_tables')->insert([
            ['Part_Number' => 'R-10K-0603', 'Name' => '10K 칩저항', 'PCB_Number' => 1, 'Process_Class' => 'SMT', 'Process_Name' => '마운터', 'Process_Detail' => 'Reel 01 장착', 'Side' => 'TOP', 'Image_File' => 'res_0603.jpg', 'Quantity' => '12', 'Location_1' => 'R1', 'Location_2' => 'R2', 'Location_3' => 'R5', 'Location_4' => '', 'wdate' => $now],
            ['Part_Number' => 'IC-MCU-32', 'Name' => '메인 MCU', 'PCB_Number' => 1, 'Process_Class' => 'SMT', 'Process_Name' => '마운터', 'Process_Detail' => 'Tray 1 장착', 'Side' => 'TOP', 'Image_File' => 'stm32.jpg', 'Quantity' => '1', 'Location_1' => 'U1', 'Location_2' => '', 'Location_3' => '', 'Location_4' => '', 'wdate' => $now],
            ['Part_Number' => 'CON-12P-DIP', 'Name' => '12P 커넥터', 'PCB_Number' => 1, 'Process_Class' => 'DIP', 'Process_Name' => '수삽', 'Process_Detail' => '방향 주의하여 삽입', 'Side' => 'TOP', 'Image_File' => 'con_12p.jpg', 'Quantity' => '1', 'Location_1' => 'CN1', 'Location_2' => '', 'Location_3' => '', 'Location_4' => '', 'wdate' => $now],
            ['Part_Number' => 'LED-R-0805', 'Name' => '레드 LED', 'PCB_Number' => 2, 'Process_Class' => 'SMT', 'Process_Name' => '마운터', 'Process_Detail' => '극성 주의', 'Side' => 'TOP', 'Image_File' => 'led_red.jpg', 'Quantity' => '4', 'Location_1' => 'LED1', 'Location_2' => 'LED2', 'Location_3' => 'LED3', 'Location_4' => 'LED4', 'wdate' => $now],
        ]);

        // 11. PcbImageTables (Image: 100, BoundBox: 100, PCB_Number: int)
        DB::table('pcb_image_tables')->insert([
            ['PCB_Number' => 1, 'Image' => 'ecu_main_a.jpg', 'BoundBox' => '[{"part":"U1", "x":100, "y":200, "w":50, "h":50}]', 'Other' => 'AI 모델 기준용', 'wdate' => $now],
            ['PCB_Number' => 2, 'Image' => 'wheel_sw_a.jpg', 'BoundBox' => '[{"part":"LED1", "x":120, "y":120, "w":15, "h":15}]', 'Other' => 'AI 모델 기준용', 'wdate' => $now],
        ]);

        // 12. DocLists (name: 10, filename: 20, path: 20, reference: 20, type: int, language: int)
        DB::table('doc_lists')->insert([
            ['type' => 1, 'name' => 'ECU(KO)', 'filename' => 'ecu_man_ko.pdf', 'path' => '/doc/ecu_man_ko.pdf', 'language' => 1, 'reference' => 'INF-ECU-01', 'wdate' => $now],
            ['type' => 1, 'name' => 'ECU(VN)', 'filename' => 'ecu_man_vn.pdf', 'path' => '/doc/ecu_man_vn.pdf', 'language' => 3, 'reference' => 'INF-ECU-01', 'wdate' => $now],
            ['type' => 2, 'name' => 'BCM 회로도', 'filename' => 'bcm_sch.pdf', 'path' => '/doc/bcm_sch.pdf', 'language' => 2, 'reference' => 'INF-BCM-01', 'wdate' => $now],
        ]);

        // 13. WorkLists (partList: 200, pcbIDX: int, memberIDX: int)
        DB::table('work_lists')->insert([
            ['partList' => 'R-10K-0603, IC-MCU-32', 'pcbIDX' => 1, 'memberIDX' => 1, 'wdate' => $now],
            ['partList' => 'CON-12P-DIP', 'pcbIDX' => 1, 'memberIDX' => 2, 'wdate' => $now],
            ['partList' => 'LED-R-0805', 'pcbIDX' => 2, 'memberIDX' => 1, 'wdate' => $now],
        ]);
    }
}
