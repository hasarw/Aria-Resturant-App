<?php

require_once "core/header.php";
require_once "core/db.php";

?>

    <div class="container">

        <div class="row text-right-2" style="margin-right: 20px; margin-left: 20px">
            <table class="table table-bordered">

                <tbody>
                <tr>
                    <th>شماره</th>
                    <th>نام کامل</th>
                    <th>نام کاربری</th>
                    <th>نوع کاربر</th>
                    <th>فعال/غیر فعال</th>
                    <th>تنظیمات</th>

                </tr>

                <tr>

                    <?php

                    $sql = "SELECT a.user_id as id, a.user_name, a.user_username, a.user_status, b.type_name FROM users as a,user_type as b WHERE a.user_type = b.user_type_id";
                    $result = $conn->query($sql);

                    $number = 1;

                    if ($result->num_rows > 0) {
                        $rowcount=mysqli_num_rows($result);
                        while ($row = $result->fetch_assoc()) {

                            echo "<td>$number</td>";
                            echo "<td>$row[user_name]</td>";
                            echo "<td>$row[user_username]</td>";
                            echo "<td>$row[type_name]</td>";
                            if($row[user_status] == 1){
                                $status = "فعال";
                                $status_id = 1;
                            }else{
                                $status = "غیر فعال";
                                $status_id = 2;
                            }
                            echo "<td>$status</td>";
                            echo "<td><a href='users.php?user_id=$row[id]&status_id=$status_id' class='btn btn-info'>فعال / غیر فعال </a></td>";
                            echo "</tr>";
                            $number++;
                        }

                    }else {
                        echo "0 results";
                    }


                    echo "<tr>
            <td colspan='5'>مجموع:</td>


            <td>$rowcount</td>
            </tr>";
                    ?>

                </tbody>
            </table>
        </div>
        <br /><br/>

        <div class="row text-right-2">

            <div class="col-md-6" id="add_food_row_2">


                <div class="row" style="padding: 50px">
                    <button class="btn btn-info" id="add_food" style="float: right">اشتراک جدید</button>
                </div>

                <div id="form-elements" class="hidden">
                    <div id="form-elements form-inline">
                        <form method="post" action="insert_sub.php" class="form_right" enctype="multipart/form-data">
                            <fieldset>
                                <div class="form-group">
                                    <label>نام کامل</label>
                                    <input type="text" class="form-control" placeholder="" name="sub_name">
                                </div>

                                <div class="form-group">
                                    <label>آدرس</label>
                                    <input type="text" class="form-control" placeholder="" name="sub_add">
                                </div>


                                <div class="form-group">
                                    <label>تلفن</label>
                                    <input type="text" class="form-control" placeholder="" name="sub_phone">
                                </div>

                                <div class="form-group">
                                    <input type="submit" name="submit" class="btn btn-success" value="ذخیره">
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <script src="../assets/js/jquery.js"></script>
    <script>
        $(document).ready(function() {
            $( "#add_food" ).click(function() {
                $("#form-elements").toggleClass("hidden");
            });
        });
    </script>
<?php require_once "footer.php"; ?>

<?php

if(isset($_GET['user_id'])){

    $user_id = $_GET['user_id'];

    if($_GET['status_id'] == 1){
        $status = 0;
    }else{
        $status = 1;
    }

    if($user_id > 0) {

        $query = "UPDATE `users` SET `user_status`= $status WHERE `user_id` = $user_id";
        if ($conn->query($query) === TRUE) {
            echo "<script>window.location = 'users.php';</script>";
        } else {
            echo "Error deleting record: " . $conn->error;
        }

        $conn->close();
    }
}


?>
