<?php
require_once('../access.php');
require_once(ROOT_DIR.'/connector.php');
$db = new DatabaseConnect();

if(isset($_GET['mode'])){
    if($_GET['mode']=='activate'){
        $db->query("UPDATE tblmemberstatus SET status = 'ACTIVE' WHERE ID = ? LIMIT 1");
        $db->bind(1,$_GET['ID']);
        if($db->execute()){
            echo "ACTIVATED";
        }
    }else{
        $db->query("UPDATE tblmemberstatus SET status = 'NOT ACTIVE' WHERE ID = ? LIMIT 1");
        $db->bind(1,$_GET['ID']);
        if($db->execute()){
            echo "DEACTIVATED";
        }
    }
}