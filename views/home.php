

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="assets/css/base.css">
    <link rel="stylesheet" type="text/css" href="assets/css/grid.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
    
    <title>CÔNG TY CỔ PHẦN STARTPRINT VIỆT NAM</title>
</head>
<body>
    <header class="d-flex justify-content-between">
        <div class="title">CÔNG TY CỔ PHẦN STARTPRINT VIỆT NAM</div>
        <div class="control">
            Welcome <b><?php echo  $_SESSION["username"] ?>!</b> | <a href="<?php echo $db_bk["base_url"]?>/logout" class="logout_btn">Logout</a>
        </div>
    </header>
    <div class="wrapper">
            <div class="sidebar">
                <ul class="sidebar_list">
                    <li class="sidebar_item">
                        Trung tâm thông báo
                    </li>
                </ul>
            </div>
            <div class="main">
                <div class="menu">
                    <ul class="menu_list d-flex">
                        <li class="menu_item menu_item--space">&nbsp;</li>
                        <li class="menu_item" id="Inbox">
                            <a href="<?php echo $db_bk["base_url"]?>/document?item=Inbox" class="menu_link">Inbox</a>
                        </li>
                        <li class="menu_item menu_item--space">&nbsp;</li>
                        <li class="menu_item"  id="Outbox">
                            <a href="<?php echo $db_bk["base_url"]?>/document?item=Outbox" class="menu_link">Outbox</a>
                        </li>
                    </ul>
                </div>
                <div class="content">
                    <div class="content_header">
                        <a href="<?php echo $db_bk["base_url"]?>/document" class="btn refresh_btn" onclick="get_total()">Refresh</a>
                    </div>
                    <div class="content_body">
                        <table class="content_table">
                            <tbody>
                                <tr>
                                    <td class="table_column table_column--header table_column--id">#</td>
                                    <?php 
                                        $columns = get_column_name();
                                        foreach($columns as $key => $column) { ?>
                                            <td class="table_column table_column--header sort" id="<?php echo 'sort_'.$key ?>">
                                                <?php echo $column?>
                                            </td>
                                    <?php    
                                        }
                                    ?>
                                </tr>
                                <tr>
                                    <td class="table_column table_column--filter table_column--id"></td>
                                    <?php 
                                        $columns = get_column_name();
                                        foreach($columns as $key => $column) { ?>
                                            <td class="table_column table_column--filter">
                                                <form class="<?php echo '_'.$key?>" action="" method="GET">
                                                    <input name="<?php echo "_".$key ?>" class="finding-input" type="text" />
                                                    <input name="item" class="finding-input item_query hidden" type="text" />

                                                    <button type="hidden" class="d-none">submit</button>
                                                </form>
                                                <!-- <span class="filter_btn"><img class="finding-img" src="./assets/img/finding.png" alt="finding"></span> -->
                                            </td>
                                        <?php    
                                        }
                                    ?>
                                </tr>
                                <?php 
                                    $item = get_item();
                                    $rows = get_row_value("AD{$item}ItemID");
                                    for($i = 0; $i < count($rows); $i++ ) { 
                                ?>
                                    <tr class="row-item" id="<?php echo $rows[$i]?>">
                                        <td class="table_column table_column--id"></td>
                                        <?php 
                                        $columns = get_column_name();
                                        foreach($columns as $column) { ?>
                                            <td class="table_column table_column--value">
                                                <?php echo get_row_value($column)[$i]?>
                                            </td>
                                        <?php    
                                        }
                                        ?>
                                    </tr>
                            <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                        <div class="table_footer d-flex align-items-center">
                            <p class="page_count">Page <?php echo get_page() === 0 ? 1 : $_GET["page"]?> of <?php echo get_total_page() - 1?> (<?php echo get_total_item()?> items)</p>
                            <div class="page_change d-flex align-items-center">
                                <button class="btn btn-changepage" id="prev_page-btn">&lt;</button>
                                <div class="num_page-list">
                                    <?php 
                                        $page_nums = get_total_page();
                                        for($i = 1; $i < $page_nums; $i++) { 
                                    ?>                                
                                        <a href="#" class="page_num"><?php echo $i ?></a>
                                    <?php 
                                        }
                                    ?>
                                </div>
                                <button class="btn btn-changepage" id="next_page-btn">&gt;</button>
                                <select class="select_page">
                                    <?php 
                                        $page_nums = get_total_page();
                                        for($i = 1; $i < $page_nums; $i++) { 
                                    ?>                                
                                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                    <?php 
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="d-flex align-items-center justify-content-between position-fixed bottom-0">
        <div class="copy-right">2023 © Copyright by [company name]</div>
        <div class="footer-menu">
            <ul class="footer-menu_list d-flex align-items-center">
                <li class="footer-menu_item" id="date_value">27/10/2023</li>
                <li class="footer-menu_item">Period: 10</li>
                <li class="footer-menu_item" id="year"> Year: 2023</li>
                <li class="footer-menu_item">Server: <?php echo $db_bk["hostname"] ? $db_bk["hostname"] : '' ?></li>
                <li class="footer-menu_item">Database: <?php echo $db_bk["database"] ? $db_bk["database"] : '' ?></li>
            </ul>
        </div>
    </footer>
    <div class="modal">
        <div class="modal-wrapper">
            <form class="form_modal" action="<?php echo $db_bk["base_url"]?>/approval?inbox=<?php echo get_id_Inbox_item()?>" method="POST">
                <div class="modal-header">
                    <p class="modal-title">
                        <span>
                            <?php
                                echo get_value_Inbox_item("AD{$item}ItemAction") ? '' : 'Waiting for Approval: '
                            ?>
                        </span>
                        <span><?php echo get_value_Inbox_item("AD{$item}ItemDocNo")?></span>
                        <span>
                            <?php 
                                echo get_value_Inbox_item("AD{$item}ItemAction") ? '('.get_value_Inbox_item("AD{$item}ItemAction").')' : ''
                            ?>
                        </span>
                        <input type="hidden" name="inbox_id" value="<?php echo get_id_Inbox_item()?>" />
                    </p> 
                    <p class="modal-close">x</p>
                </div>
                <div class="modal-info d-flex align-item-center justify-content-between">
                    Information
                    <span class="show-info-btn">
                        <i class="icon_show-info glyphicon"></i>
                    </span>
                </div>
                <div class="modal-form grid">
                    <div class="row">
                        <div class="modal-form_first col l-6">
                            <div class="modal-form-group">
                                <label for="">From User</label>
                                <input
                                    name="FromUser"
                                    class="input-value"
                                    type="text" 
                                    value="
                                        <?php echo get_user_modal(get_value_Inbox_item('FK_ADFromUserID'), "ADUserName")?>" 
                                    disabled 
                                />
                            </div>
                            <div class="modal-form-group">
                                <label for="">Document No</label>
                                <input
                                    name="DocumentNo"
                                    class="input-value" 
                                    type="text" 
                                    value="<?php echo get_value_Inbox_item("AD{$item}ItemDocNo")?>"  
                                />
                            </div>
                            <div class="modal-form-group hidden">
                                <label for="">Document Type</label>
                                <input 
                                    name="DocumentType"
                                    class="input-value" 
                                    type="text" 
                                    value="<?php echo get_value_Inbox_item("AD{$item}ItemDocType")?>" 
                                />
                            </div>
                            <div class="modal-form-group">
                                <label for="">Priority</label>
                                <input
                                    name="Priority"
                                    class="input-value"
                                    type="text" 
                                    value="<?php echo get_value_Inbox_item("AD{$item}ItemPriorityCombo")?>" 
                                    disabled 
                                />
                            </div>
                            <div class="modal-form-group hidden">
                                <label for="">Approval Process</label>
                                <input
                                    name="ApprovalProcess"
                                    class="input-value"
                                    type="text" 
                                    value="
                                        <?php echo get_approval_process(get_value_Inbox_item('FK_ADApprovalProcID'), "ADApprovalProcNo")?>"
                                    disabled 
                                    />
                            </div>
                        </div>
                        <div class="modal-form_second col l-6">
                            <div class="modal-form-group">
                                <label for="">Create User</label>
                                <input
                                    class="input-value"
                                    type="text" 
                                    value="
                                        <?php echo get_create_user(get_value_Inbox_item('FK_HRFromEmployeeID'), "HREmployeeName")?>" 
                                    disabled
                                />
                            </div>
                            <div class="modal-form-group">
                                <label for="">Date</label>
                                <input
                                    name="Date" 
                                    class="input-value input-value_date" 
                                    ype="text" value="<?php echo get_value_Inbox_item("AD{$item}ItemDate")?>"   
                                />
                            </div>
                            <div class="modal-form-group hidden">
                                <label for="">Status</label>
                                <input class="input-value" type="text" value="<?php echo get_value_Inbox_item("AD{$item}ItemTaskStatusCombo")?>" disabled />
                            </div>
                            <div class="modal-form-group">
                                <label for="">Deadline</label>
                                <input class="input-value input-value_date" type="text" value="<?php echo get_value_Inbox_item("AD{$item}ItemDeadline")?>" disabled />
                            </div>
                            <div class="modal-form-group hidden">
                                <label for="">Approval step</label>
                                <input 
                                    class="input-value" 
                                    type="text" 
                                    value="
                                        <?php echo get_approval_step(get_value_Inbox_item('FK_ADApprovalProcStepID'), "ADApprovalProcStepLevel")?>" 
                                    disabled />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-form-mess grid">
                    <div class="row">
                        <div class="modal-form_first col l-6">
                            <div class="modal-form-group d-block">
                                <div class="form-group_header">Remark</div>
                                <div class="text-area_wrapper">
                                    <textarea class="textarea-value" name="Remark" id="" cols="20" rows="6">
                                        <?php echo get_value_Inbox_item("AD{$item}ItemRemark")?>
                                    </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-form_second col l-6">
                            <div class="modal-form-group d-block">
                                <div class="form-group_header">Message</div>
                                <div class="text-area_wrapper">
                                    <textarea class="textarea-value" name="" id="" cols="20" rows="6">
                                        <?php echo get_value_Inbox_item("AD{$item}ItemMessage")?>
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    $row_detail = get_PR_row_value("Mã hàng", select_Inbox_sql(get_id_Inbox_item(), "AD{$item}ItemDocNo", get_item()));
                    if($row_detail !== []) {
                ?>
                    <div class="modal-info">
                        Chi tiết chứng từ
                    </div>
                    <div class="modal-table">
                        <table class="content_table">
                            <?php 
                                if(isset($_GET["inbox"])) {
                            ?>
                                <tbody>
                                    <tr>
                                        <?php 
                                            $columns = get_column_PR_name(select_Inbox_sql(get_id_Inbox_item(), "AD{$item}ItemDocNo", get_item()));
                                            foreach($columns as $key => $column) { ?>
                                                <td class="table_column table_column--header table_column_detail--header<?php echo '_'.$key ?>">
                                                    <?php echo $column?>
                                                </td>
                                            <?php    
                                            }
                                        ?>
                                    </tr>
                                    <?php 
                                        $rows = get_PR_row_value("Mã hàng", select_Inbox_sql(get_id_Inbox_item(), "AD{$item}ItemDocNo", get_item()));
                                        for($i = 0; $i < count($rows); $i++ ) { 
                                    ?>
                                            <tr class="detail-item" id="<?php echo $rows[$i]?>">
                                                <?php 
                                                $columns = get_column_PR_name(select_Inbox_sql(get_id_Inbox_item(), "AD{$item}ItemDocNo", get_item()));
                                                foreach($columns as $column) { ?>
                                                    <td class="table_column table_column--value">
                                                        <?php echo get_PR_row_value($column, select_Inbox_sql(get_id_Inbox_item(), "AD{$item}ItemDocNo", get_item()))[$i]?>  
                                                    </td>
                                                <?php    
                                                }
                                                ?>
                                            </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            <?php } ?>
                        </table>
                    </div>
                <?php } ?>
                
                    <div class="modal-btn">
                        <?php if(get_value_Inbox_item("AD{$item}ItemAction") === "") {?>
                            <input type="submit" name="approval_btn" value="Approval" class="btn approval-btn bg-info" />
                            <input type="submit" name="reject_btn" value="Reject" class="btn reject-btn bg-danger" />
                        <?php } ?>
                    </div>
            </form>
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script text="javascript" src="assets/js/main.min.js"></script>
<script text="javascript" src="assets/js/date_time.js"></script>
<script text="javascript" src="assets/js/change_active.js"></script>

</html>

<script>
    function my_click() {
        <?php 
        ?>
    }
</script>