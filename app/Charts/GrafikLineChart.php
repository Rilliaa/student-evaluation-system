<?php
namespace App\Charts;

use ConsoleTVs\Charts\Classes\BaseChart;

class GrafikLineChart extends BaseChart
{
    public function __construct()
    {
        parent::__construct();

        // $this->options([
        //     'chart' => [
        //         'type' => 'line',
        //         'height' => 350
        //     ],
        //     'xaxis' => [
        //         'categories' => ['No Data'], 
        //     ],
        //     'yaxis' => [
        //         'title' => [
        //             'text' => 'Persentase Kehadiran (%)'
        //         ]
        //     ],
        //     'series' => [[
        //         'name' => 'Persentase Kehadiran',
        //         'data' => [0] 
        //     ]],
        // ]);
    }
}
