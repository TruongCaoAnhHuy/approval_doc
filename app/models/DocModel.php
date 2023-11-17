<?php
    function get_total_page() {
        try {
            $sql = select_total_row_sql();
            $stmt = connect_db()->query($sql);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $page_num = ceil($row["total"] / 10);
                return $page_num;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function get_total_item() {
        try {
            $sql = select_total_row_sql();
            $stmt = connect_db()->query($sql);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $page_num = ceil($row["total"]);
                return $page_num;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function get_column_name() {
        try {
            $sql = select_inbox_item_sql(get_page(), get_item(), read_or_to_mail());
            $stmt = connect_db()->query($sql);
            // Lấy tên của tất cả các cột từ kết quả truy vấn
            $columnNames = [];
            for ($i = 0; $i < $stmt->columnCount(); $i++) {
                $columnNames[] = $stmt->getColumnMeta($i)['name'];
            }

            unset($columnNames[0]);

            return $columnNames;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function get_row_value($col) {
        try {
            $sql = select_inbox_item_sql(get_page(), get_item(), read_or_to_mail());
            $stmt = connect_db()->query($sql);

            $row_data = [];

            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Process each row of data
                $row_data[] = $row[$col];
            }
            
            return $row_data;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }