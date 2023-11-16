<?php
/**
 * Created by PhpStorm.
 * User: Hekmat
 * Date: 11/18/2016
 * Time: 9:49 PM
 */
session_start();
require_once "core/db.php";
require_once dirname(__FILE__) . '/jdatetime.class.php';

date_default_timezone_set('Asia/Tehran');

$date = jDateTime::date('Y-m-d', false, false);

echo "alert(date);";

$data=json_decode(file_get_contents("php://input"));
print_r($data);
$food_cost=$conn->real_escape_string($data->food_cost);
$sub_id=$conn->real_escape_string($data->sub_id);
$table_num=$conn->real_escape_string($data->table_num);


$last_order_id = $_SESSION['last_order_id'];
$last_order_id +=1;




$query="insert into internal_order (int_order_id,int_order_name,int_order_table_num,int_order_food_cost,int_order_date) values (null,'$sub_id','$table_num',$food_cost,'$date')";

$conn->query($query);

?>