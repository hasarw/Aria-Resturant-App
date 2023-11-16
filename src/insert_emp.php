<?php

session_start();
require_once "core/db.php";
require_once dirname(__FILE__) . '/jdatetime.class.php';

date_default_timezone_set('Asia/Tehran');

$date = jDateTime::date('Y-m-d', false, false);

if(isset($_POST['submit'])){

    $emp_name = htmlspecialchars($_POST['emp_name']);
    $emp_salary = htmlspecialchars($_POST['emp_salary']);
    $emp_phone = htmlspecialchars($_POST['emp_phone']);
    $emp_date = htmlspecialchars($_POST['emp_date']);


    $query = "insert into employee (`emp_id`, `emp_name`, `emp_salary`, `emp_phone`, `emp_date`, `emp_status`) values (null,'$emp_name','$emp_salary','$emp_phone','$emp_date',1)";

    $conn->query($query);

    header("location: employee.php");
}




if(isset($_POST['cut_money'])){

    $money = htmlspecialchars($_POST['cut_amount']);
    $id = htmlspecialchars($_POST['emp_id']);

    $query = "insert into employee_debit (`debit_id`, `debit_emp_id`, `debit_amount`, `debit_date`) values (null,'$id','$money','$date')";

    $conn->query($query);

    header("location: employee.php");
}
?>
