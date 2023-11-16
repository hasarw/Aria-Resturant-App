<?php
//create connection credentioal

$db_host = "localhost";
$db_name = "aria_resturant";
$db_user = "root";
$db_pass= "";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
mysqli_set_charset($conn,"utf8");
// Check connection
error_reporting(0);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
