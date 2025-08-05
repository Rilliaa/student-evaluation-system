<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class KehadiranMuridChart
{
    public function build(array $data)
    {
        return (new LarapexChart)->pieChart()
            // ->setTitle('Grafik Kehadiran Murid')
            ->addData([
                $data['hadir'], 
                $data['izin'], 
                $data['mangkir']
                ])
            ->setLabels(['Hadir', 'Izin', 'Mangkir']);
    }
}
