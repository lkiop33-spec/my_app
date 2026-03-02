<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('WSSP 관리자 대시보드') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- 4 요약 카드 (Summary Cards) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- 활성 작업자 수 -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col p-6 border border-gray-700">
                    <dt class="text-sm font-medium text-gray-400 truncate">활성 작업자 수 (Active Workers)</dt>
                    <dd class="mt-2 text-3xl font-semibold text-white">42</dd>
                </div>

                <!-- 평균 숙련도 향상률 -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col p-6 border border-gray-700">
                    <dt class="text-sm font-medium text-gray-400 truncate">평균 숙련도 향상률 (Skill Growth %)</dt>
                    <dd class="mt-2 text-3xl font-semibold text-green-400">+15.8%</dd>
                </div>

                <!-- 실시간 가이드 가동률 -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col p-6 border border-gray-700">
                    <dt class="text-sm font-medium text-gray-400 truncate">실시간 가이드 가동률 (Guide Usage)</dt>
                    <dd class="mt-2 text-3xl font-semibold text-blue-400">92.4%</dd>
                </div>

                <!-- 미처리 공정 오류 -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col p-6 border border-gray-700">
                    <dt class="text-sm font-medium text-gray-400 truncate">미처리 공정 오류 (Pending Errors)</dt>
                    <dd class="mt-2 text-3xl font-semibold text-red-500">3</dd>
                </div>
            </div>

            <!-- 2 차트 영역 (Charts Grid) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- 차트 1 -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700 flex flex-col h-[400px]">
                    <h3 class="text-lg font-medium text-white mb-2">작업자 숙련도 추이 (Skill Progression)</h3>
                    <div id="chart-line" class="flex-grow w-full"></div>
                </div>

                <!-- 차트 2 -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-700 flex flex-col h-[400px]">
                    <h3 class="text-lg font-medium text-white mb-2">공정 정밀도 분석 (Process Precision)</h3>
                    <div id="chart-radar" class="flex-grow w-full"></div>
                </div>
            </div>

        </div>
    </div>

    <!-- ApexCharts Library & Script -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // PHP injected data
            const lineChartData = {!! $lineChartData !!};
            const radarChartData = {!! $radarChartData !!};

            // 1. 작업자 숙련도 추이 (Line Chart)
            var optionsLine = {
                series: [{
                    name: "완수 시간 (초)",
                    data: lineChartData.data 
                }],
                chart: {
                    type: 'line',
                    height: '100%',
                    toolbar: { show: false },
                    background: 'transparent'
                },
                theme: { mode: 'dark' },
                colors: ['#00e5ff'], 
                stroke: {
                    curve: 'smooth',
                    width: 4
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        type: 'horizontal',
                        shadeIntensity: 0.5,
                        gradientToColors: ['#b388ff'], 
                        inverseColors: true,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100]
                    }
                },
                xaxis: {
                    categories: lineChartData.categories,
                    title: { text: '추이 일자', style: { color: '#9ca3af' } }
                },
                yaxis: {
                    title: { text: '시간 (초)', style: { color: '#9ca3af' } }
                },
                grid: {
                    borderColor: '#374151', 
                    strokeDashArray: 3,
                }
            };

            var chartLine = new ApexCharts(document.querySelector("#chart-line"), optionsLine);
            chartLine.render();

            // 2. 공정 정밀도 분석 (Radar Chart)
            var optionsRadar = {
                series: [{
                    name: '현재 작업수행능력',
                    data: radarChartData.current,
                }, {
                    name: '권장 목표치',
                    data: radarChartData.goal,
                }],
                chart: {
                    height: '100%',
                    type: 'radar',
                    toolbar: { show: false },
                    background: 'transparent',
                    dropShadow: { enabled: true, blur: 1, left: 1, top: 1 }
                },
                theme: { mode: 'dark' },
                colors: ['#00e5ff', '#ff4081'], 
                stroke: { width: 2 },
                fill: { opacity: 0.2 },
                markers: { size: 4, hover: { size: 6 } },
                xaxis: {
                    categories: radarChartData.categories,
                    labels: {
                        style: {
                            colors: ['#a78bfa', '#a78bfa', '#a78bfa', '#a78bfa', '#a78bfa'],
                            fontSize: '11px',
                            fontFamily: 'inherit'
                        }
                    }
                },
                yaxis: {
                    show: false,
                    min: 0,
                    max: 100
                },
                plotOptions: {
                    radar: {
                        polygons: {
                            strokeColors: '#374151',
                            connectorColors: '#374151'
                        }
                    }
                },
                legend: { position: 'bottom' }
            };

            var chartRadar = new ApexCharts(document.querySelector("#chart-radar"), optionsRadar);
            chartRadar.render();
        });
    </script>
</x-app-layout>
