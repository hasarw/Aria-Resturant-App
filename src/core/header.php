<?php

require_once dirname(__FILE__) . '/../jdatetime.class.php';
date_default_timezone_set('Asia/Kabul');

session_start();
error_reporting(0);
$date = jDateTime::date('l j F Y H:i');
$active = "";

if($_SERVER['REQUEST_URI'] == "/AriaResturant/src/admin.php"){
    $activeAdmin = "active";
}
if($_SERVER['REQUEST_URI'] == "/AriaResturant/src/food_menu.php"){
    $activeFood_manu = "active";
}
if($_SERVER['REQUEST_URI'] == "/AriaResturant/src/shop.php"){
    $activeShop = "active";
}
if($_SERVER['REQUEST_URI'] == "/AriaResturant/src/talar.php"){
    $activeTalar = "active";
}
if($_SERVER['REQUEST_URI'] == "/AriaResturant/src/employee.php"){
    $activeEmployee = "active";
}
if($_SERVER['REQUEST_URI'] == "/AriaResturant/src/subscribers.php"){
    $activeSubscribers = "active";
}
if($_SERVER['REQUEST_URI'] == "/AriaResturant/src/users.php"){
    $activeUsers = "active";
}
if($_SERVER['REQUEST_URI'] == "/AriaResturant/src/report_resturant.php"){
    $activeReport_resturant = "active";
}
if($_SERVER['REQUEST_URI'] == "/AriaResturant/src/report_talar.php"){
    $activeReport_talar = "active";
}
if($_SERVER['REQUEST_URI'] == "/AriaResturant/src/stock.php"){
    $activeReport_stock = "active";
}

?>

<html ng-app="app" lang="utf-8">
<meta charset='utf-8'>
<head class="hidden-print">

    <link rel="stylesheet" href="../assets/css/styles.css">


    <div class="row initial_row hidden-print" id="initial_row">
        <div class="login-info">
            <span>کاربر: <?php echo $_SESSION['user_name']; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
            <tab><a href="../src/core/signout.php"><span>خروج از سیستم</span></a>
                &nbsp;&nbsp;&nbsp;&nbsp;<span class="left"><?php echo $date; ?></span>
        </div>
    </div>

    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar3">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
<!--                <a class="navbar-brand" href="http://disputebills.com"><img src="http://res.cloudinary.com/candidbusiness/image/upload/v1455406304/dispute-bills-chicago.png" alt="Dispute Bills">-->
<!--                </a>-->
            </div>
            <div id="navbar3" class="navbar-collapse collapse">

                <ul class="nav navbar-nav navbar-right">

                    <?php

                    if($_SESSION['user_type'] == 2) {
                        echo "<li class= $activeAdmin ><a href='../src/admin.php'>سفارش</a></li>
                        <li class= $activeFood_manu ><a href='../src/food_menu.php'>منوی غذایی</a></li>
                        <li class= $activeSubscribers ><a href='../src/subscribers.php'>مشترکین</a></li>
                        <li class= $activeReport_resturant ><a href='../src/report_resturant.php'/>گزارش رستوران </li></a>";
                    }


                    if($_SESSION['user_type'] == 3) {
                    echo "<li class= $activeTalar><a href='../src/talar.php'>تالار</a></li>
                    <li class= $activeReport_talar><a href='../src/report_talar.php'/>گزارش تالار</li></a>
                    <li class= $activeFood_manu ><a href='../src/food_menu.php'>منوی غذایی</a></li>";
                    }

                    if($_SESSION['user_type'] == 4) {
                    echo "<li class=$activeReport_stock><a href = '../src/stock.php' /> انبار</li ></a>
                    <li class= $activeShop ><a href = '../src/shop.php' > خرید روزانه </a ></li >";
                    }

                    if($_SESSION['user_type'] == 1) {
                        echo "<li class= $activeAdmin ><a href='../src/admin.php'>سفارش</a></li>
                        <li class= $activeFood_manu ><a href='../src/food_menu.php'>منوی غذایی</a></li>
                        <li class= $activeSubscribers ><a href='../src/subscribers.php'>مشترکین</a></li>
                        <li class= $activeReport_resturant ><a href='../src/report_resturant.php'/>گزارش رستوران </li></a>
                        <li class= $activeTalar><a href='../src/talar.php'>تالار</a></li>
                        <li class= $activeReport_talar><a href='../src/report_talar.php'/>گزارش تالار</li></a>
                        <li class= $activeEmployee><a href='../src/employee.php'/>کارمندان</a></li>
                        <li class= $activeUsers><a href='../src/users.php'>کاربران </a></li>
                        <li class=$activeReport_stock><a href = '../src/stock.php' /> انبار</li ></a>
                        <li class= $activeShop ><a href = '../src/shop.php' > خرید روزانه </a ></li >";
                    }
                    ?>

                </ul>

            </div>
            <!--/.nav-collapse -->
        </div>
        <!--/.container-fluid -->
    </nav>

</head>
