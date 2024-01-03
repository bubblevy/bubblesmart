<?php

namespace App\Charts;

use Carbon\Carbon;
use App\Models\Result;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class AnswerQuizChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $tahun = date('Y');
        $bulan = date('m');
        for ($i = 1; $i <= $bulan; $i++) {
            $totalUsers = Result::with('user')->whereYear('created_at', $tahun)->whereMonth('created_at', $i)->get();
            $dataBulan[] = Carbon::create()->month($i)->locale('id')->isoFormat('MMMM');
            $totalUserLakiLaki[] = $totalUsers->where('user.gender', 'Laki-Laki')->count();
            $totalUserPerempuan[] = $totalUsers->where('user.gender', 'Perempuan')->count();
        }
        return $this->chart->lineChart()
            ->setTitle('Data Akses Quiz')
            ->setSubtitle('Total pengguna yang menjawab Quiz tahun ' . date('Y'))
            ->addData('Laki-Laki', $totalUserLakiLaki)
            ->addData('Perempuan', $totalUserPerempuan)
            // ->addData('Laki-Laki', [4, 1, 3, 9, 7, 5, 3, 6, 3, 5, 9])
            // ->addData('Perempuan', [3, 2, 7, 3, 4, 8, 5, 6, 1, 6, 2])
            ->setXAxis($dataBulan)
            ->setFontFamily('Poppins')
            ->setFontColor('#566a7f')
            ->setColors(['#696cff', '#ff6384']);
    }
}
