<?php

session_start();
require_once "core/db.php";
require_once dirname(__FILE__) . '/jdatetime.class.php';

date_default_timezone_set('Asia/Tehran');

$date = jDateTime::date('Y-m-d', false, false);

if(isset($_POST['submit'])){
    $shop_desc = $_POST['shop_desc'];
    $shop_qt = $_POST['shop_qt'];
    $shop_date = $_POST['shop_Date'];
    $shop_cost = $_POST['shop_cost'];
    $shop_date = jDateTime::date('Y-m-d', false, false);

    $query = "insert into shop (`shop_id`, `shop_desc`, `shop_qt`, `shop_cost`, `shop_date`, `shop_status`) values (null,'$shop_desc','$shop_qt',$shop_cost,'$shop_date',1)";

    $conn->query($query);

    header("location: shop.php");
}
?>