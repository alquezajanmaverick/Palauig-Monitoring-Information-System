<?php 
require_once("../../access.php");
require_once("../../connector.php");
$db = new DatabaseConnect();

$db->query("UPDATE tbluser SET username = ?, password = ?, fullname = ? WHERE ID = ? LIMIT 1");
$db->bind(1,$_POST['username']);
$db->bind(2,$_POST['password']);
$db->bind(3,$_POST['fullname']);
$db->bind(4,$_POST['id']);
$db->execute();