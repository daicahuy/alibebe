<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Highcharts\Chart;

class Analysis extends Chart
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getColumnChart()
    {
        return $this->labels(['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'])
            ->options([
                'chart' => ['type' => 'column'], // Biểu đồ đường cong
                'colors' => ['#ff4d4d', '#007bff'], // Màu sắc cho các đường
                'xAxis' => ['categories' => ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6']],
                'yAxis' => [ [
                    'title' => ['text' => 'Doanh thu (VNĐ)'], 
                    'labels' => ['format' => '{value} VNĐ'], 
                    'opposite' => false // Trục Y bên trái
                ],
                [
                    'title' => ['text' => 'Số đơn hàng'], 
                    'labels' => ['format' => '{value} đơn'], 
                    'opposite' => true // Trục Y bên phải
                ]],
                'legend' => ['enabled' => true], // Hiện chú thích
                'series' => [
                  
                    [
                        'name' => 'Doanh thu',
                        'data' => [50000000, 70000000, 60000000, 80000000, 90000000, 75000000],
                        'color' => '#007bff',
                        'yAxis' => 0, // Gán vào trục Y đầu tiên (Doanh thu)
                        'type' => 'column'
                    ],
                    [
                        'name' => 'Số đơn hàng',
                        'data' => [120, 140, 130, 150, 170, 160],
                        'color' => '#ff4d4d',
                        'yAxis' => 1, // Gán vào trục Y thứ hai (Số đơn hàng)
                        'type' => 'spline' // Dùng đường line để dễ nhìn
                    ]
                ]
            ]);
    }

    // Biểu đồ cột doanh thu & đơn hàng
    public function getSplineChart()
    {
        return $this->labels(['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'])
            ->options([
                'chart' => ['type' => 'spline'], // Biểu đồ cột
                'colors' => ['#3fe17b', '#e1523f', '#e1c93f', '#3f70e1'], // Đỏ cho doanh thu, xanh cho đơn hàng
                'xAxis' => ['categories' => ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6']],
                'yAxis' => ['title' => ['text' => 'Số lượng']],
                'legend' => ['enabled' => true], // Hiện chú thích
                'series' => [
                    ['name' => 'Hoàn thành', 'data' => [40, 60, 70, 82, 50, 55]],
                    ['name' => 'Không thành công', 'data' => [37, 40, 50, 45, 30, 50]],
                    ['name' => 'Hủy hàng', 'data' => [20, 40, 100, 45, 20, 99]],
                    ['name' => 'Hoàn hàng', 'data' => [100, 40, 50, 65, 10, 70]],
                ]
            ]);
    }
}
