<?php
    use PhpOffice\PhpSpreadsheet\IOFactory;
    
    // $user_configs = array(
    //     'VANCHIEN'      => 'XVQ2UIGO75XRUKVC',
    //     'THANHTRUNG'    => 'XVQ2UIGO75XRUKTT',
    //     'HUUTHUAN'      => 'XVQ2UIGO75XRUKHT',
    //     'phamhuy'      => 'XVQ2UIGO75XRUKPH',
    // );

    function pass_qr() {
        return 'spv@admin';
    }

    function get_user_name_excel() {
        // Đường dẫn đến file Excel cần đọc
        $excelFilePath = 'data_user.xlsx';

        try {
            // Sử dụng IOFactory để tạo đối tượng Spreadsheet từ file Excel
            $spreadsheet = IOFactory::load($excelFilePath);

            // Lấy sheet hiện tại (có thể sửa đổi tên sheet nếu cần)
            $sheet = $spreadsheet->getActiveSheet();

            // Lấy tất cả giá trị từ cột "Name" và "Key"
            $userKeys = [];
            $highestRow = $sheet->getHighestRow();

            for ($row = 2; $row <= $highestRow; $row++) {
                $name = $sheet->getCell('A' . $row)->getValue(); // Cột "Name" ở cột A
                $key = $sheet->getCell('B' . $row)->getCalculatedValue(); // Cột "Key" ở cột B

                // Thêm vào mảng tên người dùng và khóa
                $userKeys[$name] = $key;
            }

            return $userKeys;

        } catch (Exception $e) {
            echo 'Error loading file: ', $e->getMessage();
        }
    }