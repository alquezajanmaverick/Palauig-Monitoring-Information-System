<?php
require_once("../connector.php");
if(isset($_POST['compoID'])){
    $db = new DatabaseConnect();
    $db->query("UPDATE tblcomposition SET name = ?, relationship = ?, c_age = ?, c_civil_status = ?, c_occupation = ?, c_income = ? WHERE compoID = ? LIMIT 1");
    $db->bind(1,$_POST['name']);
    $db->bind(2,$_POST['relationship']);
    $db->bind(3,$_POST['c_age']);
    $db->bind(4,$_POST['c_civil_status']);
    $db->bind(5,$_POST['c_occupation']);
    $db->bind(6,$_POST['c_income']);
    $db->bind(7,$_POST['compoID']);
    $db->execute();
}