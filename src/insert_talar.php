<?php

session_start();
require_once "core/db.php";
require_once dirname(__FILE__) . '/jdatetime.class.php';

date_default_timezone_set('Asia/Tehran');

$date = jDateTime::date('Y-m-d', false, false);

$data=json_decode(file_get_contents("php://input"));
print_r($data);

$order_name=$conn->real_escape_string($data->order_name);
$order_phone=$conn->real_escape_string($data->order_phone);
$order_date=$conn->real_escape_string($data->order_date);
$order_time=$conn->real_escape_string($data->order_time);
$food_ghori=$conn->real_escape_string($data->food_ghori);
$food_discount=$conn->real_escape_string($data->food_discount);
$food_tax=$conn->real_escape_string($data->food_tax);
$food_cost=$conn->real_escape_string($data->food_cost);


$last_order_id = $_SESSION['last_order_id'];
$last_order_id +=1;




$query="insert into talar (talar_id,talar_name,talar_phone,talar_time,talar_discount,talar_tax,talar_num_dish,talar_cost,talar_date) values (null,'$order_name','$order_phone','$order_time','$food_discount','$food_tax','$food_ghori','$food_cost','$order_date')";

$conn->query($query);

?>