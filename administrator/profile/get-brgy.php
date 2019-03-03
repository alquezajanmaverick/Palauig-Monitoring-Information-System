<?php
require_once('../access.php');
require_once(ROOT_DIR.'/connector.php');
$db = new DatabaseConnect();

$db->query("SELECT * FROM tblbrgy");
echo json_encode($db->resultset());
