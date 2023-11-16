<?php

require_once 'src/core/db.php';
require_once 'src/core/variables.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" href="assets/css/styles.css">

    <title><?php echo PageTitle; ?></title>

</head>

<body>
    <div class="login">
    <div class="container">
        <div class="row">

                <div class="text-center" >

                    <h2><?php echo AppName; ?></h2>

                        <img class="img-responsive" src="assets/img/logo.jpg" style="width: 350px; height: 190px">

                    <h1><?php echo ResturantTitle; ?></h1>

                </div>

            </div>

                <div class="row">
                    <div class="col-md-offset-4 col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo LoginText; ?></h3>
                    </div>
                    <div class="panel-body">
                        <form class="form" action="login.php" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="نام کاربری" name="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="رمز عبور" name="password" type="password" value="">
                                </div>

                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" name="submit" value="ورود" class="btn btn-lg btn-success btn-block" />
                                <br>
                            </fieldset>
                        </form>
                        <?php

                        if(isset($_GET['wrong'])){
                        echo '<div class="panel-body">';
                            echo '<div class="alert alert-warning">رمز عبور یا نام کاربری شما اشتباه است.</div>';
                        echo '</div>';
                        }

                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

<p class="text-center">
    Developed by Kiana
</p>

</html>


<?php
if(isset($_POST['submit'])){

    //Need to validate the username and password here!

    $username = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $query ="SELECT * FROM `users` WHERE `user_username` = '$username' AND `user_password` = '$password'";

//Get results
    $result = $conn->query($query);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();
        $username_db = $row['user_username'];
        $password_db = $row['user_password'];
        $status = $row['user_status'];

    }

        if ($status == 1) {

            session_start();
            $_SESSION['login_name'] = $row['user_username'];
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_type'] = $row['user_type'];

            if($_SESSION['user_type'] == 1){
                header('Location: src/admin.php');
            }
            if($_SESSION['user_type'] == 2){
                header('Location: src/admin.php');
            }
            if($_SESSION['user_type'] == 3){
                header('Location: src/talar.php');
            }
            if($_SESSION['user_type'] == 4){
                header('Location: src/stock.php');
            }
        }

    else{
        header('Location: login.php?wrong=wrong');
    }
}
?>