<?php
    function get_value_Inbox_item($col_name) {
        try {
            $sql = select_Inbox_sql(get_id_Inbox_item(), $col_name, get_item());
            $stmt = connect_db()->query($sql);
                        
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Process each row of data
                return $row[$col_name];
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    function get_user_modal($user_id, $col_name) {
        try {
            $sql = select_user_sql($user_id, $col_name);
            $stmt = connect_db()->query($sql);
                        
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Process each row of data
                return $row[$col_name];
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function get_approval_process($id, $col_name) {
        try {
            $sql = select_approval_process_sql($id, $col_name);
            $stmt = connect_db()->query($sql);
                        
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Process each row of data
                return $row[$col_name];
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function get_create_user($id, $col_name) {
        try {
            $sql = select_create_user_sql($id, $col_name);
            $stmt = connect_db()->query($sql);
                        
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Process each row of data
                return $row[$col_name];
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function get_approval_step($id, $col_name) {
        try {
            $sql = select_approval_step_sql($id, $col_name);
            $stmt = connect_db()->query($sql);
                        
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Process each row of data
                return $row[$col_name];
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function get_column_PR_name($type) {
        try {
            $sql = select_detail_item($type);
            $stmt = connect_db()->query($sql);
            // Lấy tên của tất cả các cột từ kết quả truy vấn
            $columnNames = [];
            for ($i = 0; $i < $stmt->columnCount(); $i++) {
                $columnNames[] = $stmt->getColumnMeta($i)['name'];
            }
            
            return $columnNames;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function get_PR_row_value($col, $type) {
        try {
            $sql = select_detail_item($type);
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
    