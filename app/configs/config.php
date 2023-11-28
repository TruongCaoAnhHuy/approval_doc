<?php
    define('INDEX_ACCESS', true);
    
    $environment = 'dev';

    if ($environment === 'dev') {
        require('app/configs/config_dev.php');
    } else if($environment === 'prod') {
        require('app/configs/config_prod.php');
    } else {
        include('error_500.php');
        die();
    }

    function get_item() {
        if(isset($_GET["item"])) {
            $item = $_GET["item"];
        } else {
            $item = "Inbox";
        }

        return $item;
    }

    function read_or_to_mail() {
        if(isset($_GET["item"]) && $_GET["item"] === "Outbox") {
            $var = "To";
        } else {
            $var = "Read";
        }

        return $var;
    }

    function get_page() {
        if(isset($_GET["page"])) {
            $page_num = (int)$_GET["page"];
            $page_num = ($page_num - 1) * 10;
        } else {
            $page_num = 0;
        }

        return $page_num;
    }

    function get_id_Inbox_item() {
        if (isset($_GET['inbox'])) {
            $id = $_GET["inbox"];
            return $id; 
        } else {
            $id = "";
            return $id;
        }
    }

    function get_finding_item($var, $col) {
        if(isset($_GET[$var])) {
            $find = $_GET[$var];
            if($find !== "") {
                $sql_finding = "and $col LIKE N'{$find}%'";
            } else {
                $sql_finding = "";
            }
        } else {
            $sql_finding = "";
        }
        return $sql_finding;
    }

    function get_finding_date($var, $col) {
        if(isset($_GET[$var])) {
            $find = $_GET[$var];
            if($find !== "") {
                $sql_finding = "and CONVERT(date, {$col}, 103) LIKE '{$find}%'";
            } else {
                $sql_finding = "";
            }
        } else {
            $sql_finding = "";
        }
        return $sql_finding;
    }

    function get_space_item($var, $col) {
        if(isset($_GET[$var])) {
            $find = $_GET[$var];
            if($find !== "") {
                if($find === " ") {
                    $sql_finding = "and $col = ''";
                } else {
                    $sql_finding = "and $col LIKE '{$find}%'";
                }
            } else {
                $sql_finding = "";
            }
        } else {
            $sql_finding = "";
        }
        return $sql_finding;
    }
    
    function get_user_name() {
        if(isset($_SESSION["username"])) {
            $username = $_SESSION["username"];
        } else {
            $username = "no";
        }
        return $username;        
    }

    function get_sort_query_param() {
        if(isset($_GET["sort"])) {
            return $_GET["sort"]; 
        } else {
            return "";
        }
    }

    function get_sort_column() {
        $sort_column = substr(get_sort_query_param(), 0, 6);
        $item = get_item();
        switch ($sort_column) {
            case 'sort_1':
                return "AD{$item}ItemSubject";
                break;
            case 'sort_2':
                return "AD{$item}ItemMessage";
                break;
            case 'sort_3':
                return "AD{$item}ItemDocType";
                break;
            case 'sort_4':
                return "AD{$item}ItemDocNo";
                break;
            case 'sort_5':
                return 'FK_HRFromEmployeeID';
                break;
            case 'sort_6':
                return "AD{$item}ItemDate";
                break;
            case 'sort_7':
                return "AD{$item}ItemAction";
                break;
            case 'sort_8':
                return "AD{$item}ItemPriorityCombo";
                break;
            
            default:
                return "AD{$item}ItemID";
                break;
        }
    }

    function get_sort_action() {
        $sort_action = substr(get_sort_query_param(), 6);
        if(isset($_GET["sort"])) {
            return $sort_action;
        } else {
            return 'desc';
        }
    }
    