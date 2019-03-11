<?php
require_once("../../access.php");
require_once("../../connector.php");

$db = new DatabaseConnect();
$db->query("SELECT * FROM seniorloggedinview");
echo json_encode($db->resultset());
