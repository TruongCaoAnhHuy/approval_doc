<?php
    if(isset($_POST["approval_btn"])) {
        try {
            $pdo = connect_db();
            $item = get_item();

            // sql update Inbox
            $action_value = "Approved";
            $remark_value = $_POST["Remark"];
            $id_item =      $_POST["inbox_id"];

            $sql_update = "UPDATE ADInboxItems SET ADInboxItemAction = :new_value, ADInboxItemRemark = :new_remark WHERE ADInboxItemID = :id";
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->bindParam(':new_value', $action_value, PDO::PARAM_STR);
            $stmt_update->bindParam(':new_remark', $remark_value, PDO::PARAM_STR);
            $stmt_update->bindParam(':id', $id_item, PDO::PARAM_STR);
            $stmt_update->execute();

            // insert outbox
            $aa_status =            get_value_Inbox_item("AAStatus");
            $outbox_subject =       get_value_Inbox_item("ADInboxItemSubject");
            $outbox_docno =         get_value_Inbox_item("ADInboxItemDocNo");
            $outbox_doctype =       get_value_Inbox_item("ADInboxItemDocType");
            // date format
            $outbox_date =          get_value_Inbox_item("ADInboxItemDate");
            $date_format = new DateTime($outbox_date);
            $formated = $date_format->format('Y-m-d');
            // =>=>=>=>=>=>=>=>
            $outbox_mess =          get_value_Inbox_item("ADInboxItemMessage");
            $outbox_protocol =      get_value_Inbox_item("ADInboxItemProtocol");
            $outbox_priority =      get_value_Inbox_item("ADInboxItemPriorityCombo");
            $outbox_fk_user =       get_value_Inbox_item("FK_ADFromUserID");
            $outbox_fk_hr =         get_value_Inbox_item("FK_HRFromEmployeeID");
            $outbox_mailto =        get_value_Inbox_item("ADMailToUsers");
            $outbox_mailcc =        get_value_Inbox_item("ADMailCCUsers");
            $outbox_task =          get_value_Inbox_item("ADInboxItemTaskStatusCombo");
            $outbox_unread =        1;
            $outbox_action =        'Approved';
            $outbox_fk_proc =       get_value_Inbox_item("FK_ADApprovalProcID");
            $outbox_remark =        get_value_Inbox_item("ADInboxItemRemark");
            $outbox_fk_step =       get_value_Inbox_item("FK_ADApprovalProcStepID");
            $outbox_fk_user_id =    0;
            $outbox_doc_status =    get_value_Inbox_item("ADInboxItemDocApprovalStatusCombo");
            $outbox_table_name =    get_value_Inbox_item("ADInboxItemTableName");
            $outbox_ojb_id =        get_value_Inbox_item("ADInboxItemObjectID");
            $outbox_type_combo =    get_value_Inbox_item("ADApprovalTypeCombo");

            $sql_insert_outbox = "INSERT INTO ADOutboxItems VALUES(
                :aa_status, 
                :subject, 
                :outbox_doc_no, 
                :outbox_doc_type, 
                :outbox_date, 
                :outbox_mess, 
                :outbox_protocol, 
                :oubox_priority, 
                :fk_user, 
                :fk_hr, 
                :mail_to, 
                :mail_cc, 
                :task, 
                :un_read, 
                :outbox_action,
                :fk_proc, 
                :outbox_remark, 
                :fk_step, 
                :fk_user_id,
                :outbox_status, 
                :table_name, 
                :object_id, 
                :type_combo
            )";       
            $stmt_insert_outbox = $pdo->prepare($sql_insert_outbox);
            $stmt_insert_outbox->bindParam(':aa_status',        $aa_status);
            $stmt_insert_outbox->bindParam(':subject',          $outbox_subject);
            $stmt_insert_outbox->bindParam(':outbox_doc_no',    $outbox_docno);
            $stmt_insert_outbox->bindParam(':outbox_doc_type',  $outbox_doctype);
            $stmt_insert_outbox->bindParam(':outbox_date',      $formated);
            $stmt_insert_outbox->bindParam(':outbox_mess',      $outbox_mess);
            $stmt_insert_outbox->bindParam(':outbox_protocol',  $outbox_protocol);
            $stmt_insert_outbox->bindParam(':oubox_priority',   $outbox_priority);
            $stmt_insert_outbox->bindParam(':fk_user',          $outbox_fk_user);
            $stmt_insert_outbox->bindParam(':fk_hr',            $outbox_fk_hr);
            $stmt_insert_outbox->bindParam(':mail_to',          $outbox_mailto);
            $stmt_insert_outbox->bindParam(':mail_cc',          $outbox_mailcc);
            $stmt_insert_outbox->bindParam(':task',             $outbox_task);
            $stmt_insert_outbox->bindParam(':un_read',          $outbox_unread);
            $stmt_insert_outbox->bindParam(':outbox_action',    $outbox_action);
            $stmt_insert_outbox->bindParam(':fk_proc',          $outbox_fk_proc);
            $stmt_insert_outbox->bindParam(':outbox_remark',    $outbox_remark);
            $stmt_insert_outbox->bindParam(':fk_step',          $outbox_fk_step);
            $stmt_insert_outbox->bindParam(':fk_user_id',       $outbox_fk_user_id);
            $stmt_insert_outbox->bindParam(':outbox_status',    $outbox_doc_status);
            $stmt_insert_outbox->bindParam(':table_name',       $outbox_table_name);
            $stmt_insert_outbox->bindParam(':object_id',        $outbox_ojb_id);
            $stmt_insert_outbox->bindParam(':type_combo',       $outbox_type_combo);
            $stmt_insert_outbox->execute();

            // sql insert
            $status =       "Alive";
            $doc_no =       get_value_Inbox_item("AD{$item}ItemDocNo");
            $doc_type =     get_value_Inbox_item("AD{$item}ItemDocType");
            $date =         get_value_Inbox_item("AD{$item}ItemDate");
            $user_name =    $_SESSION["username"];
            $action =       $action_value;
            $proc_id =      get_value_Inbox_item("FK_ADApprovalProcID");
            $proc_step =    get_value_Inbox_item("FK_ADApprovalProcStepID");
            $remark =       $_POST["Remark"];
            $tbl_name =     get_value_Inbox_item("AD{$item}ItemTableName");
            $ojb_id =       get_value_Inbox_item("AD{$item}ItemObjectID");

            $sql_insert = "INSERT INTO ADDocHistorys VALUES (:status, :doc_no, :doc_type, :date, :user_name, :action, :proc_id, :proc_step, :remark, :tbl_name, :ojb_id, '', '')";       
            $stmt_insert = $pdo->prepare($sql_insert);
            $stmt_insert->bindParam(':status',      $status);
            $stmt_insert->bindParam(':doc_no',      $doc_no);
            $stmt_insert->bindParam(':doc_type',    $doc_type);
            $stmt_insert->bindParam(':date',        $date);
            $stmt_insert->bindParam(':user_name',   $user_name);
            $stmt_insert->bindParam(':action',      $action);
            $stmt_insert->bindParam(':proc_id',     $proc_id, PDO::PARAM_INT);
            $stmt_insert->bindParam(':proc_step',   $proc_step, PDO::PARAM_INT);
            $stmt_insert->bindParam(':remark',      $remark);
            $stmt_insert->bindParam(':tbl_name',    $tbl_name);
            $stmt_insert->bindParam(':ojb_id',      $ojb_id, PDO::PARAM_INT);
            $stmt_insert->execute();

            header("Location: document");            
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } 
    if(isset($_POST["reject_btn"])) {
        try {            
            $pdo = connect_db();
            $item = get_item();

            // sql update
            $action_value = "Rejected";
            $remark_value = $_POST["Remark"];
            $id_item =      $_POST["inbox_id"];

            $sql_update = "UPDATE AD{$item}Items SET AD{$item}ItemAction = :new_value, AD{$item}ItemRemark = :new_remark WHERE AD{$item}ItemID = :id";
            $stmt = $pdo->prepare($sql_update);
            $stmt->bindParam(':new_value', $action_value, PDO::PARAM_STR);
            $stmt->bindParam(':new_remark', $remark_value, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id_item, PDO::PARAM_STR);
            $stmt->execute();

            // insert outbox
            $aa_status =            get_value_Inbox_item("AAStatus");
            $outbox_subject =       get_value_Inbox_item("ADInboxItemSubject");
            $outbox_docno =         get_value_Inbox_item("ADInboxItemDocNo");
            $outbox_doctype =       get_value_Inbox_item("ADInboxItemDocType");
            // date format
            $outbox_date =          get_value_Inbox_item("ADInboxItemDate");
            $date_format = new DateTime($outbox_date);
            $formated = $date_format->format('Y-m-d');
            // =>=>=>=>=>=>=>=>
            $outbox_mess =          get_value_Inbox_item("ADInboxItemMessage");
            $outbox_protocol =      get_value_Inbox_item("ADInboxItemProtocol");
            $outbox_priority =      get_value_Inbox_item("ADInboxItemPriorityCombo");
            $outbox_fk_user =       get_value_Inbox_item("FK_ADFromUserID");
            $outbox_fk_hr =         get_value_Inbox_item("FK_HRFromEmployeeID");
            $outbox_mailto =        get_value_Inbox_item("ADMailToUsers");
            $outbox_mailcc =        get_value_Inbox_item("ADMailCCUsers");
            $outbox_task =          get_value_Inbox_item("ADInboxItemTaskStatusCombo");
            $outbox_unread =        1;
            $outbox_action =        'Rejected';
            $outbox_fk_proc =       get_value_Inbox_item("FK_ADApprovalProcID");
            $outbox_remark =        get_value_Inbox_item("ADInboxItemRemark");
            $outbox_fk_step =       get_value_Inbox_item("FK_ADApprovalProcStepID");
            $outbox_fk_user_id =    0;
            $outbox_doc_status =    get_value_Inbox_item("ADInboxItemDocApprovalStatusCombo");
            $outbox_table_name =    get_value_Inbox_item("ADInboxItemTableName");
            $outbox_ojb_id =        get_value_Inbox_item("ADInboxItemObjectID");
            $outbox_type_combo =    get_value_Inbox_item("ADApprovalTypeCombo");

            $sql_insert_outbox = "INSERT INTO ADOutboxItems VALUES(
                :aa_status, 
                :subject, 
                :outbox_doc_no, 
                :outbox_doc_type, 
                :outbox_date, 
                :outbox_mess, 
                :outbox_protocol, 
                :oubox_priority, 
                :fk_user, 
                :fk_hr, 
                :mail_to, 
                :mail_cc, 
                :task, 
                :un_read, 
                :outbox_action,
                :fk_proc, 
                :outbox_remark, 
                :fk_step, 
                :fk_user_id,
                :outbox_status, 
                :table_name, 
                :object_id, 
                :type_combo
            )";       
            $stmt_insert_outbox = $pdo->prepare($sql_insert_outbox);
            $stmt_insert_outbox->bindParam(':aa_status',        $aa_status);
            $stmt_insert_outbox->bindParam(':subject',          $outbox_subject);
            $stmt_insert_outbox->bindParam(':outbox_doc_no',    $outbox_docno);
            $stmt_insert_outbox->bindParam(':outbox_doc_type',  $outbox_doctype);
            $stmt_insert_outbox->bindParam(':outbox_date',      $formated);
            $stmt_insert_outbox->bindParam(':outbox_mess',      $outbox_mess);
            $stmt_insert_outbox->bindParam(':outbox_protocol',  $outbox_protocol);
            $stmt_insert_outbox->bindParam(':oubox_priority',   $outbox_priority);
            $stmt_insert_outbox->bindParam(':fk_user',          $outbox_fk_user);
            $stmt_insert_outbox->bindParam(':fk_hr',            $outbox_fk_hr);
            $stmt_insert_outbox->bindParam(':mail_to',          $outbox_mailto);
            $stmt_insert_outbox->bindParam(':mail_cc',          $outbox_mailcc);
            $stmt_insert_outbox->bindParam(':task',             $outbox_task);
            $stmt_insert_outbox->bindParam(':un_read',          $outbox_unread);
            $stmt_insert_outbox->bindParam(':outbox_action',    $outbox_action);
            $stmt_insert_outbox->bindParam(':fk_proc',          $outbox_fk_proc);
            $stmt_insert_outbox->bindParam(':outbox_remark',    $outbox_remark);
            $stmt_insert_outbox->bindParam(':fk_step',          $outbox_fk_step);
            $stmt_insert_outbox->bindParam(':fk_user_id',       $outbox_fk_user_id);
            $stmt_insert_outbox->bindParam(':outbox_status',    $outbox_doc_status);
            $stmt_insert_outbox->bindParam(':table_name',       $outbox_table_name);
            $stmt_insert_outbox->bindParam(':object_id',        $outbox_ojb_id);
            $stmt_insert_outbox->bindParam(':type_combo',       $outbox_type_combo);
            $stmt_insert_outbox->execute();

            // sql update Outbox
            $action_value_outbox =  "Rejected";
            $remark_value_outbox =  $_POST["Remark"];
            $id_item_outbox =       $_POST["inbox_id"];

            $sql_update_outbox = "UPDATE ADOutboxItems SET ADOutboxItemAction = :new_value, ADOutboxItemRemark = :new_remark WHERE ADOutboxItemID = :id";
            $stmt_update_outbox = $pdo->prepare($sql_update_outbox);
            $stmt_update_outbox->bindParam(':new_value', $action_value_outbox, PDO::PARAM_STR);
            $stmt_update_outbox->bindParam(':new_remark', $remark_value_outbox, PDO::PARAM_STR);
            $stmt_update_outbox->bindParam(':id', $id_item_outbox, PDO::PARAM_STR);
            $stmt_update_outbox->execute();

            // sql insert
            $status = "Alive";
            $doc_no =       get_value_Inbox_item("AD{$item}ItemDocNo");
            $doc_type =     get_value_Inbox_item("AD{$item}ItemDocType");
            $date =         get_value_Inbox_item("AD{$item}ItemDate");
            $user_name =    $_SESSION["username"];
            $action =       $action_value;
            $proc_id =      get_value_Inbox_item("FK_ADApprovalProcID");
            $proc_step =    get_value_Inbox_item("FK_ADApprovalProcStepID");
            $remark =       $_POST["Remark"];
            $tbl_name =     get_value_Inbox_item("AD{$item}ItemTableName");
            $ojb_id =       get_value_Inbox_item("AD{$item}ItemObjectID");

            $sql_insert = "INSERT INTO ADDocHistorys VALUES (:status, :doc_no, :doc_type, :date, :user_name, :action, :proc_id, :proc_step, :remark, :tbl_name, :ojb_id, '', '')";
            $stmt = $pdo->prepare($sql_insert);
            $stmt->bindParam(':status',     $status);
            $stmt->bindParam(':doc_no',     $doc_no);
            $stmt->bindParam(':doc_type',   $doc_type);
            $stmt->bindParam(':date',       $date);
            $stmt->bindParam(':user_name',  $user_name);
            $stmt->bindParam(':action',     $action);
            $stmt->bindParam(':proc_id',    $proc_id, PDO::PARAM_INT);
            $stmt->bindParam(':proc_step',  $proc_step, PDO::PARAM_INT);
            $stmt->bindParam(':remark',     $remark);
            $stmt->bindParam(':tbl_name',   $tbl_name);
            $stmt->bindParam(':ojb_id',     $ojb_id, PDO::PARAM_INT);
            $stmt->execute();

            header("Location: document");            
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }