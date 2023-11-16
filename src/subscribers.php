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
                    <th>نام</th>
                    <th>آدرس</th>
                    <th>تلفن</th>
                    <th>تاریخ ثبت</th>
                    <th>تنظیمات</th>

                </tr>

                <tr>

                    <?php

                        $sql = "select `sub_id`, `sub_name`, `sub_add`, `sub_date_reg`, `sub_phone`, `sub_status` FROM `subscriber` where 1";
                        $result = $conn->query($sql);

                        $number = 1;

                        if ($result->num_rows > 0) {
                            $rowcount=mysqli_num_rows($result);
                            while ($row = $result->fetch_assoc()) {

                                echo "<td>$number</td>";
                                echo "<td>$row[sub_name]</td>";
                                echo "<td>$row[sub_add]</td>";
                                echo "<td>$row[sub_phone]</td>";
                                echo "<td>$row[sub_date_reg]</td>";
                                echo "<td><a href='subscribers.php?sub_id=$row[sub_id]' onclick='return confirm_delete()' class='btn btn-sm btn-info' >حذف</a></td>";
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

<?php

if(isset($_GET['sub_id'])){

    $sub_id = $_GET['sub_id'];

    $sql = "DELETE FROM `subscriber` WHERE `sub_id` = $sub_id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('حذف شد');</script>";
        echo "<script>window.location = 'subscribers.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>


<?php require_once "footer.php"; ?>

<script type="text/javascript">
    function confirm_delete() {
        return confirm('آیا مطمعن هستید؟');
    }
</script>