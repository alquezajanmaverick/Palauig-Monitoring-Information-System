<?php
require_once("../../access.php");
require_once("../../connector.php");
if(isset($_GET['ID'])){
    $db = new DatabaseConnect();
    $db->query("SELECT * FROM tbluser WHERE ID = ?");
    $db->bind(1,$_GET['ID']);
    echo json_encode($db->resultset());
}else if(isset($_GET['username'])){
    $db = new DatabaseConnect();
    $db->query("SELECT * FROM tbluser WHERE username LIKE ?");
    $db->bind(1,$_GET['username']);
    echo json_encode($db->resultset());
}
else{
    $db = new DatabaseConnect();
    $db->query("SELECT * FROM tbluser");
    echo json_encode($db->resultset());
}
