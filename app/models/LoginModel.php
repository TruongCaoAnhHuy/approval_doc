<?php
     function get_user_name_log_on($col_name) {
        try {
            $sql = select_log_on_sql(get_id_Inbox_item(), $col_name);
            $stmt = connect_db()->query($sql);
                        
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Process each row of data
                return $row[$col_name];
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }