<?php
require_once("../connector.php");
if(isset($_POST['compoID'])){
    $db = new DatabaseConnect();
    $db->query("DELETE FROM tblcomposition WHERE compoID = ? LIMIT 1");
    $db->bind(1,$_POST['compoID']);
    if($db->execute()){
        echo "success";
    }
}