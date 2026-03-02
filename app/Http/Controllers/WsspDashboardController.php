<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class WsspDashboardController extends Controller
{
    public function index()
    {
        // 1. Line Chart Data (Last 7 days completion time trend)
        $categoriesLine = [];
        $dataLine = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('m/d');
            $categoriesLine[] = $date;
            // Decreasing trend simulating skill improvement
            $baseTime = 220;
            $dataLine[] = max(100, $baseTime - ((6 - $i) * 15) + rand(-10, 15)); 
        }

        // 2. Radar Chart Data (Current skills vs Goal)
        $categoriesRadar = ['부품 인식', '도구 사용', '공정 순서', '안전 수칙', '작업 속도'];
        $dataRadarCurrent = [rand(80, 95), rand(75, 95), rand(85, 100), rand(90, 100), rand(70, 90)];
        $dataRadarGoal = [90, 90, 90, 90, 90];

        return view('wssp.dashboard', [
            'lineChartData' => json_encode([
                'categories' => $categoriesLine,
                'data' => $dataLine
            ]),
            'radarChartData' => json_encode([
                'categories' => $categoriesRadar,
                'current' => $dataRadarCurrent,
                'goal' => $dataRadarGoal
            ])
        ]);
    }
}
