<?php
require_once('../access.php');
require_once(ROOT_DIR.'/connector.php');
$db = new DatabaseConnect();
$db->query("SELECT CONCAT(fname,' ',mname,' ',lname) as name,ID FROM memberview");

echo json_encode($db->resultset());
