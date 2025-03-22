<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Highcharts\Chart;

class Analysis extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->labels(['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4']) // Nhãn trục X
             ->dataset('Doanh thu', 'area', [100, 200, 300, 400]) // Dữ liệu mẫu
             ->options([
                 'colors' => ['#3490dc'],
                 'legend' => true
             ]);
    }
}
