<?php 
require_once("../../access.php");
require_once("../../connector.php");
$db = new DatabaseConnect();

$db->query("INSERT INTO tbluser(username,password,fullname)VALUES(?,?,?)");
$db->bind(1,$_POST['username']);
$db->bind(2,$_POST['password']);
$db->bind(3,$_POST['fullname']);
$db->execute();