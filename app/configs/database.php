<?php
    global $db_bk;
    $db_bk = $config;

    function connect_db() {
        global $db_bk;
        $serverName = $db_bk["hostname"];
        $databaseName = $db_bk["database"];
        $uid = $db_bk["username"];
        $pwd = $db_bk["password"];
        
        try {
            $pdo = new PDO("sqlsrv:Server=$serverName;Database=$databaseName", $uid, $pwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    function select_inbox_item_sql($page_num, $item, $read_to) {
        $action = get_action();

        $sql_subject_finding = get_finding_item('_1', "AD{$item}ItemSubject");
        $sql_mess_finding = get_finding_item('_2', "AD{$item}ItemMessage");
        $sql_type_finding = get_finding_item('_3', "AD{$item}ItemDocType");
        $sql_no_finding = get_finding_item('_4', "AD{$item}ItemDocNo");
        $sql_employ_finding = get_finding_item('_5', "FK_HRFromEmployeeID");
        $sql_date_finding = get_finding_date('_6', "AD{$item}ItemDate");
        $sql_action_finding = get_space_item('_7', "AD{$item}ItemAction");
        $sql_priority_finding = get_space_item('_8', "AD{$item}ItemPriorityCombo");

        $column_sort = get_sort_column();
        $action_sort = get_sort_action();

        $username = get_user_name();

        $sql = "
            select 
                AD{$item}ItemID,
                AD{$item}ItemSubject as 'Subject', 
                AD{$item}ItemMessage as 'Message', 
                AD{$item}ItemDocType as 'Document Type', 
                AD{$item}ItemDocNo as 'Document No',  
                CONVERT(varchar, AD{$item}ItemDate, 103) AS 'Date', 
                AD{$item}ItemAction as 'Action', 
                AD{$item}ItemPriorityCombo as 'Priority'
            from AD{$item}Items
            where
                ADMailToUsers LIKE '%{$username}%' 
                and 
                AAStatus = 'Alive' 
                {$action}				
                {$sql_subject_finding} 
                {$sql_mess_finding} 
                {$sql_type_finding} 
                {$sql_no_finding} 
                {$sql_employ_finding} 
                {$sql_date_finding} 
                {$sql_action_finding} 
                {$sql_priority_finding}
            ORDER BY {$column_sort} {$action_sort}
            OFFSET {$page_num} ROWS
            FETCH NEXT 16 ROWS ONLY
        ";
        return $sql;
    }

    function select_total_row_sql() {
        $action = get_action();

        $username = get_user_name();
        $item = get_item();
        $read_to = read_or_to_mail();

        $sql_subject_finding = get_finding_item('_1', "AD{$item}ItemSubject");
        $sql_mess_finding = get_finding_item('_2', "AD{$item}ItemMessage");
        $sql_type_finding = get_finding_item('_3', "AD{$item}ItemDocType");
        $sql_no_finding = get_finding_item('_4', "AD{$item}ItemDocNo");
        $sql_employ_finding = get_finding_item('_5', "FK_HRFromEmployeeID");
        $sql_date_finding = get_finding_date('_6', "AD{$item}ItemDate");
        $sql_action_finding = get_space_item('_7', "AD{$item}ItemAction");
        $sql_priority_finding = get_space_item('_8', "AD{$item}ItemPriorityCombo");

        $username = get_user_name();

        $sql = "
            SELECT COUNT(*) AS total FROM AD{$item}Items
            where ADMailToUsers LIKE '%{$username}%' 
            and 
            AAStatus = 'Alive'
			{$action}
            {$sql_subject_finding}
            {$sql_mess_finding} 
            {$sql_type_finding} 
            {$sql_no_finding} 
            {$sql_employ_finding} 
            {$sql_date_finding} 
            {$sql_action_finding} 
            {$sql_priority_finding}
        ";
         return $sql;
    }

    function select_Inbox_sql($id, $col, $item) {
        $sql = "
            select {$col} 
            from AD{$item}Items 
            where AD{$item}ItemID = {$id}
        ";
        return $sql;
    }

    function select_user_sql($user_id, $col) {
        $sql = "
            select {$col} 
            from ADUsers
            where ADUserID = {$user_id}
        ";  
        return $sql;
    }

    function select_approval_process_sql($id, $col) {
        $sql = "
            select {$col} 
            from ADApprovalProcs
            where ADApprovalProcID = {$id}
        ";
        return $sql;
    }

    function select_create_user_sql($id, $col) {
        $sql = "
            select {$col}
            from HREmployees
            where HREmployeeID = {$id}
        ";
        return $sql;
    }

    function select_approval_step_sql($id, $col) {
        $sql = "
            select {$col} 
            from ADApprovalProcSteps
            where ADApprovalProcStepID = {$id}
        ";
        return $sql;
    }

    function select_log_on_sql($user_name, $user_pass) {
        $sql = "
            select ADUserName, ADPassword 
            from ADUsers
            where AAStatus = 'Alive' and ADUserName = {$user_name} and ADPassword = {$user_pass}
        ";
        return $sql;
    }

    function select_detail_item($type) {
        $sql = "";
        $item = get_item();
        $id_inbox_item = get_value_Inbox_item("AD{$item}ItemDocType");

        switch ($id_inbox_item) {
            case 'PR':
                $sql = "
                    select
                    ri.APPRItemLine as 'LINE',
                    pd.ICProductNo as 'Mã hàng',
                    pd.ICProductName as 'Tên hàng',
                    ri.APPRItemDesc as 'Ghi chú',
                    dvt.ICUOMNo as 'Đơn vị tính',
                    CAST(ri.APPRItemQty as decimal(18, 2)) as 'Số lượng',
                    CAST(ri.APPRItemFUnitPrice as decimal(18, 2)) as 'Đơn giá (NT)',
                    ri.GLTOF04Combo as 'Cost Center',
                    APPRItemArrivalDate as 'Ngày yêu cầu giao'

                    from APPRItems RI
                    inner join ICProducts pd on pd.ICProductID=ri.FK_ICProductID and pd.AAStatus='Alive'
                    left join ICUOMs dvt on dvt.ICUOMID=ri.FK_ICUOMID and dvt.AAStatus='Alive'
                    left join ICUOms dvtk on dvtk.ICUOMID=ri.FK_ICStkUOMID and dvtk.AAStatus='Alive'
                    where RI.FK_APPRID in
                    (
                    select APPRID from APPRs where APPRNo = ({$type})
                    )
                    and RI.AAStatus='Alive'
                ";
                break;
            case 'PO':
                $sql = "
                    select(select APPRNo from APPRs where APPRID =oi.FK_APPRID)APPRNo,
                    pd.ICProductNo as 'Mã hàng',
                    pd.ICProductName as 'Tên hàng',
                    dvt.ICUOMNo as 'Đơn vị tính',
                    dvtk.ICUOMNo as 'ĐVT (kho)',
                    CAST(oi.APPOItemQty as decimal(18, 2)) as 'Số lượng',
                    CAST(oi.APPOItemFUnitPrice as decimal(18, 2)) as 'Đơn giá (NT)',
                    CAST(oi.APPOItemUnitPrice as decimal(18, 2)) as 'Đơn giá (VNĐ)',
                    CAST(oi.APPOItemFPrice as decimal(18, 2)) as 'Thành tiền (VNĐ)',
                    CAST(oi.APPOItemAmtTot as decimal(18, 2)) as 'Tỏng cộng',
                    oi.GLTOF04Combo as 'Cost Center',
                    oi.GLTOF01Combo as 'Loại hình kinh doanh',
                    oi.GLTOF02Combo as 'Cost Line'
                    
                    from APPOitems oi
                    inner join ICProducts pd on pd.ICProductID=oi.FK_ICProductID and pd.AAStatus='Alive'
                    left join ICUOMs dvt on dvt.ICUOMID=oi.FK_ICUOMID and dvt.AAStatus='Alive'
                    left join ICUOms dvtk on dvtk.ICUOMID=oi.FK_ICStkUOMID and dvtk.AAStatus='Alive'
                    where oi.FK_APPOID in
                    (
                    select APPOID from APPOs where APPONo= ({$type})
                    )
                    and oi.AAStatus='Alive'
                ";
                break;
            
            default:
                # code...
                $sql = "
                    select(select APPRNo from APPRs where APPRID =oi.FK_APPRID)APPRNo,
                    pd.ICProductNo,
                    pd.ICProductName,
                    dvt.ICUOMNo,
                    dvtk.ICUOMNo,
                    oi.APPOItemQty,
                    oi.APPOItemFUnitPrice,
                    oi.APPOItemUnitPrice,
                    oi.APPOItemFPrice,
                    oi.APPOItemAmtTot,
                    oi.GLTOF04Combo,
                    oi.GLTOF01Combo,
                    oi.GLTOF02Combo
                    
                    from APPOitems oi
                    inner join ICProducts pd on pd.ICProductID=oi.FK_ICProductID and pd.AAStatus='Alive'
                    left join ICUOMs dvt on dvt.ICUOMID=oi.FK_ICUOMID and dvt.AAStatus='Alive'
                    left join ICUOms dvtk on dvtk.ICUOMID=oi.FK_ICStkUOMID and dvtk.AAStatus='Alive'
                    where oi.FK_APPOID in
                    (
                    select APPOID from APPOs where APPONo= ({$type})
                    )
                    and oi.AAStatus='Alive'
                ";
                break;
        }

        return $sql;
    }