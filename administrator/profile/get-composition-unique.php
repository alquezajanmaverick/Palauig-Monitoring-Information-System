<?php
require_once('../access.php');
require_once(ROOT_DIR.'/connector.php');
$db = new DatabaseConnect();
if(isset($_GET['ID'])){
    $db->query("SELECT * FROM tblcomposition WHERE compoID = ?");
    $db->bind(1,$_GET['ID']);
    echo json_encode($db->resultset());
}
