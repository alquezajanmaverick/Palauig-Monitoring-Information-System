<?php 
require_once("../../access.php");
require_once("../../connector.php");
$db = new DatabaseConnect();

$db->query("DELETE FROM tbluser WHERE ID = ? LIMIT 1");
$db->bind(1,$_POST['id']);
$db->execute();