<?php
require_once('../access.php');
require_once(ROOT_DIR.'/connector.php');
$db = new DatabaseConnect();


$strQuery = "";
$strQuery .= "SELECT COUNT(m.ID) as membercount FROM tblmember m LEFT JOIN tblmemberstatus s ON s.ID = m.ID LEFT JOIN tblcomposition c ON c.ID = m.ID LEFT JOIN tblmemberimg i ON i.ID = m.ID ";
if(isset($_GET['status'])){
    if($_GET['status']!='all' || isset($_GET['name'])){
        $strQuery .= "WHERE ";
    }

    if(isset($_GET['name']) ){
        $strQuery .= "CONCAT(m.fname,' ',m.mname,' ',m.lname) LIKE '%". $_GET['name'] ."%' ";
    }
    if($_GET['status']=='active'){
        if(isset($_GET['name'])){
            $strQuery .= "AND s.status ='ACTIVE' ";
        }else{
            $strQuery .= "s.status ='ACTIVE' ";
        }

    }else if($_GET['status']=='notactive'){
        if(isset($_GET['name'])){
            $strQuery .= "AND (s.status ='NOT ACTIVE' OR s.status IS NULL) ";
        }else{
            $strQuery .= "(s.status ='NOT ACTIVE' OR s.status IS NULL) ";
        }
        
    }
}

// $strQuery .= "LIMIT ?,?";

// echo $strQuery;

$db->query($strQuery);
$db->bind(1,intval($_GET['offset']));
$db->bind(2,intval($_GET['limit']));
$count = $db->single();
echo $count['membercount'];