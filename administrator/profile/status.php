<?php
require_once('../access.php');
require_once(ROOT_DIR.'/connector.php');
$db = new DatabaseConnect();

$request = json_decode(file_get_contents('php://input'), true);

foreach ($request as $data) {
    $db->query("INSERT INTO `tblcomposition` (`ID`, `name`, `relationship`, `c_age`, `c_civil_status`, `c_occupation`, `c_income`) VALUES (?,?,?,?,?,?,?)");
    $db->bind(1,$data['ID']);
    $db->bind(2,$data['name']);
    $db->bind(3,$data['relationship']);
    $db->bind(4,$data['age']);
    $db->bind(5,$data['civil_status']);
    $db->bind(6,$data['occupation']);
    $db->bind(7,$data['income']);
    $db->execute();
}

echo "success";