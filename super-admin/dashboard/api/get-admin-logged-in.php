<?php
require_once("../../access.php");
require_once("../../connector.php");

$db = new DatabaseConnect();
$db->query("SELECT * FROM userloggedinview");
echo json_encode($db->resultset());
