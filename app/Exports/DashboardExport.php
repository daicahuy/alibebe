<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Repositories\DashboardRepository;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DashboardExport implements WithStyles,FromCollection, WithMapping, WithHeadings
{
    public function styles(Worksheet $sheet)
    {
        return [
            // Căn trái tất cả dữ liệu
            'A:Z' => ['alignment' => ['horizontal' => 'left']], 
        ];
    }
    protected $dashboardRepository;
    protected $start_date;
    protected $IdEmployee;
    
    protected $userName;


    public function __construct(DashboardRepository $dashboardRepository, $start_date, $IdEmployee)
    {
        $this->dashboardRepository = $dashboardRepository;
        $this->start_date = $start_date;
        $this->IdEmployee = $IdEmployee;
        
        $user = User::find($this->IdEmployee);
        $this->userName = $user ? $user->fullname : 'TỔNG';
    }

    // Phương thức collection sẽ lấy dữ liệu bạn cần xuất
    public function collection(): \Illuminate\Support\Collection
    {
        // Lấy dữ liệu cho biểu đồ doanh thu và đơn hàng
        $revenueData = $this->dashboardRepository->getRevenueAndOrdersByHour($this->start_date,  $this->IdEmployee);

        // Lấy dữ liệu cho biểu đồ trạng thái đơn hàng
        $orderStatusData = $this->dashboardRepository->getOrderStatusByHour($this->start_date,  $this->IdEmployee);
        $sumRevenueData = $this->dashboardRepository->revenue($this->start_date, $this->IdEmployee);
        // dd($sumRevenueData);
        $collection = collect();
     
        $collection->push([
            'sum_revenue' =>  number_format($sumRevenueData, 0, ',', '.'),
            '',
            'time_label' => 'Thời gian',
            'revenue_status' => 'Tổng tiền (VND)',
            'orders' => 'Số lượng đơn hàng',

        ]);
        // Biểu đồ 1: Doanh thu và đơn hàng (Thời gian, Doanh thu, Số đơn hàng)
        foreach ($revenueData['labels'] as $index => $label) {
            $collection->push([
                'sum_revenue' => '',   
                '',
                'time_label' => $label,
                'revenue_status' => number_format($revenueData['revenues'][$index], 0, ',', '.'),
                'orders' => $revenueData['orders'][$index],

            ]);
        }
        $collection->push([
            'sum_revenue' => '', 
            '',
            'time_label' => '',  // Dòng trống
            'revenue_status' => '',
            'orders' => '',

        ]);
        $collection->push([
            'sum_revenue' => '', 
            '',
            'time_label' => '',  
            'revenue_status' => 'THỐNG KÊ TRẠNG THÁI ĐƠN HÀNG',
            'orders' => '',

        ]);
        $collection->push([
            'sum_revenue' => '', 
            '',
            'time_label' => 'Thời gian',  // Dòng trống
            'revenue_status' => 'Trạng thái đơn hàng',
            'orders' => 'Số lượng theo trạng thái',

        ]);

        // Biểu đồ 2: Trạng thái đơn hàng (Thời gian, Trạng thái, Số đơn hàng)
        if ($this->start_date == 0 || $this->start_date == null) {
            foreach ($orderStatusData['labels'] as $label) {
                // Chuyển đổi "0:00", "2:00", ... thành số nguyên 0, 2, 4, ...
                $hour = intval(explode(':', $label)[0]); // Lấy số giờ từ chuỗi "0:00" => 0
        
                foreach ($orderStatusData['orders'] as $status => $orders) {
                    // Truy xuất dữ liệu bằng key số nguyên
                    $statusCount = $orders[$hour] ?? 0;
                    
                    $collection->push([
                        'sum_revenue' => '', 
                        '',
                        'time_label' => $label,  // Giữ nguyên định dạng "0:00", "2:00", ...
                        'revenue_status' => $status,
                        'orders' =>  $statusCount,
                     
                    ]);
                }
                $collection->push([
                    'sum_revenue' => '', 
                    '',
                    'time_label' => '',  // Dòng trống
                    'revenue_status' => '',
                    'orders' => '',
                   
                ]);
            }
        }
        
         else {
             // Lặp qua các ngày và lấy dữ liệu cho trạng thái
             foreach ($orderStatusData['labels'] as $label) {
            // Nếu không phải lọc theo giờ (ví dụ lọc theo ngày, tháng, năm)
            foreach ($orderStatusData['orders'] as $status => $orders) {
                    // Lấy số lượng cho ngày cụ thể từ trạng thái
                    $statusCount = $orders[$label] ?? 0;  // Điền giá trị 0 nếu không có dữ liệu cho ngày

                    // Đẩy vào collection
                    $collection->push([
                        'sum_revenue' => '', 
                        '',
                        'time_label' => $label,
                        'revenue_status' => $status,      // Trạng thái đơn hàng
                        'orders' => $statusCount,       // Số lượng trạng thái đơn hàng
                  
                    ]);
                }
                $collection->push([
                    'sum_revenue' => '',
                    '', 
                    'time_label' => '',  // Dòng trống
                    'revenue_status' => '',
                    'orders' => '',
                   
                ]);
            }
            
        }


        // dd($collection);
        return $collection;
    }

  
    public function map($row): array
    {
        if (isset($row['sum_revenue']) && $row['sum_revenue'] !== '') {
            $orders = ($row['orders'] == 0) ? 'Không' : $row['orders'];

            return [
                $row['sum_revenue'],   // Tổng doanh thu
                '',
                $row['time_label'],  // Thời gian
                $row['revenue_status'],     // Doanh thu
                $orders,             // Tổng đơn hàng (Hiển thị '0' nếu = 0 cho Biểu đồ 1)                   
             
            ];
        }
        // Nếu là dữ liệu Biểu đồ 1 (Doanh thu và Đơn hàng)
        if (isset($row['revenue_status']) && $row['revenue_status'] !== '') {
            // Kiểm tra nếu Số lượng đơn hàng = 0 thì sẽ hiển thị '0' cho biểu đồ 1
            $orders = ($row['orders'] == 0) ? 'Không' : $row['orders'];

            return [
                '',
                '',
                $row['time_label'],  // Thời gian
                $row['revenue_status'],     // Doanh thu
                $orders,             // Tổng đơn hàng (Hiển thị '0' nếu = 0 cho Biểu đồ 1)
            
            ];
        }

       

        // Trường hợp không khớp với các điều kiện trên, trả về mảng trống hoặc giá trị mặc định
        return [
            '',
            '',
            '',
            '',
            ''
        ];
    }






    // Phương thức headings để tạo tiêu đề cột cho Excel
    public function headings(): array
    {
        // dd($this->start_date);
        return [
            ['BÁO CÁO CỦA: ' . $this->userName],
            ['DOANH THU (VND)', '', '', 'THỐNG KÊ DOANH THU & SỐ LƯỢNG ĐƠN HÀNG', ''],
        ];
    }
}