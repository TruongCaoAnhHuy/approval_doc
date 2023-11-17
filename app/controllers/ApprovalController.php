<?php
    if(isset($_POST["approval_btn"])) {
        try {
            $pdo = connect_db();

            // sql update
            $action_value = "Approved";
            $remark_value = $_POST["Remark"];
            $id_item = $_POST["inbox_id"];

            $sql_update = "UPDATE ADInboxItems SET ADInboxItemAction = :new_value, ADInboxItemRemark = :new_remark WHERE ADInboxItemID = :id";
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->bindParam(':new_value', $action_value, PDO::PARAM_STR);
            $stmt_update->bindParam(':new_remark', $remark_value, PDO::PARAM_STR);
            $stmt_update->bindParam(':id', $id_item, PDO::PARAM_STR);
            $stmt_update->execute();

            // sql insert
            $status = "Alive";
            $doc_no = get_value_Inbox_item("ADInboxItemDocNo");
            $doc_type = get_value_Inbox_item("ADInboxItemDocType");
            $date = get_value_Inbox_item("ADInboxItemDate");
            $user_name = $_SESSION["username"];
            $action = $action_value;
            $proc_id = get_value_Inbox_item("FK_ADApprovalProcID");
            $proc_step = get_value_Inbox_item("FK_ADApprovalProcStepID");
            $remark = $_POST["Remark"];
            $tbl_name = get_value_Inbox_item("ADInboxItemTableName");
            $ojb_id = get_value_Inbox_item("ADInboxItemObjectID");

            $sql_insert = "INSERT INTO ADDocHistorys VALUES (:status, :doc_no, :doc_type, :date, :user_name, :action, :proc_id, :proc_step, :remark, :tbl_name, :ojb_id, '', '')";       
            $stmt_insert = $pdo->prepare($sql_insert);
            $stmt_insert->bindParam(':status', $status);
            $stmt_insert->bindParam(':doc_no', $doc_no);
            $stmt_insert->bindParam(':doc_type', $doc_type);
            $stmt_insert->bindParam(':date', $date);
            $stmt_insert->bindParam(':user_name', $user_name);
            $stmt_insert->bindParam(':action', $action);
            $stmt_insert->bindParam(':proc_id', $proc_id, PDO::PARAM_INT);
            $stmt_insert->bindParam(':proc_step', $proc_step, PDO::PARAM_INT);
            $stmt_insert->bindParam(':remark', $remark);
            $stmt_insert->bindParam(':tbl_name', $tbl_name);
            $stmt_insert->bindParam(':ojb_id', $ojb_id, PDO::PARAM_INT);
            $stmt_insert->execute();

            header("Location: document");            
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } 
    if(isset($_POST["reject_btn"])) {
        try {            
            $pdo = connect_db();

            // sql update
            $action_value = "Rejected";
            $remark_value = $_POST["Remark"];
            $id_item = $_POST["inbox_id"];

            $sql_update = "UPDATE ADInboxItems SET ADInboxItemAction = :new_value, ADInboxItemRemark = :new_remark WHERE ADInboxItemID = :id";
            $stmt = $pdo->prepare($sql_update);
            $stmt->bindParam(':new_value', $action_value, PDO::PARAM_STR);
            $stmt->bindParam(':new_remark', $remark_value, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id_item, PDO::PARAM_STR);
            $stmt->execute();

            // sql insert
            $status = "Alive";
            $doc_no = get_value_Inbox_item("ADInboxItemDocNo");
            $doc_type = get_value_Inbox_item("ADInboxItemDocType");
            $date = get_value_Inbox_item("ADInboxItemDate");
            $user_name = $_SESSION["username"];
            $action = $action_value;
            $proc_id = get_value_Inbox_item("FK_ADApprovalProcID");
            $proc_step = get_value_Inbox_item("FK_ADApprovalProcStepID");
            $remark = $_POST["Remark"];
            $tbl_name = get_value_Inbox_item("ADInboxItemTableName");
            $ojb_id = get_value_Inbox_item("ADInboxItemObjectID");

            $sql_insert = "INSERT INTO ADDocHistorys VALUES (:status, :doc_no, :doc_type, :date, :user_name, :action, :proc_id, :proc_step, :remark, :tbl_name, :ojb_id, '', '')";
            $stmt = $pdo->prepare($sql_insert);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':doc_no', $doc_no);
            $stmt->bindParam(':doc_type', $doc_type);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':user_name', $user_name);
            $stmt->bindParam(':action', $action);
            $stmt->bindParam(':proc_id', $proc_id, PDO::PARAM_INT);
            $stmt->bindParam(':proc_step', $proc_step, PDO::PARAM_INT);
            $stmt->bindParam(':remark', $remark);
            $stmt->bindParam(':tbl_name', $tbl_name);
            $stmt->bindParam(':ojb_id', $ojb_id, PDO::PARAM_INT);
            $stmt->execute();

            header("Location: document");            
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }