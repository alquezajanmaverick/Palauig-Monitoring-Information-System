<?php
require_once('../access.php');
require_once('../connector.php');
if(isset($_GET['ID'])){
    $db = new DatabaseConnect();
    $db->query("SELECT * FROM memberview WHERE ID = ? LIMIT 1");
    $db->bind(1,$_GET['ID']);
    echo json_encode( $db->resultset() );

}