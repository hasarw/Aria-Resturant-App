<?php

session_start();
require_once "core/db.php";
require_once dirname(__FILE__) . '/jdatetime.class.php';

date_default_timezone_set('Asia/Tehran');

$date = jDateTime::date('Y-m-d', false, false);

if(isset($_POST['submit'])){
    $sub_name = htmlspecialchars($_POST['sub_name']);
    $sub_add = htmlspecialchars($_POST['sub_add']);
    $sub_phone = htmlspecialchars($_POST['sub_phone']);

    $query = "insert into subscriber (`sub_id`, `sub_name`, `sub_add`, `sub_date_reg`, `sub_phone`, `sub_status`) values (null,'$sub_name','$sub_add','$date','$sub_phone',1)";

    $conn->query($query);

    header("location: subscribers.php");
}
?>