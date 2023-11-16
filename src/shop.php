<?php

require_once "core/header.php";
require_once "core/db.php";

?>

    <div class="container">
        <div class="row text-right-2">

            <form class="form-inline" action="shop.php" method="post">
                <div class="control-group">
                    <div class="controls">
                        <div class="input-append">
                            <label class="control-label">از تاریخ:</label>
                            <input id="datepicker1" class="input-small form-control" type="text" name="dateFrom">

                            &nbsp;&nbsp;

                            <label class="control-label">تا تاریخ:</label>
                            <input id="datepicker2" class="input-small form-control" type="text" name="dateTo">

                            <button class="btn btn-primary" name="submit">
                                جستجو
                            </button>
                        </div>

                    </div>

                </div>

            </form>

        </div>
    </div>

    <hr/>

    <div class="container">

        <div class="row text-right-2" style="margin-right: 20px; margin-left: 20px">


            <table class="table table-bordered">

                <tbody>
                <tr>
                    <th>شماره</th>
                    <th>مشخصات</th>
                    <th>مقدار</th>
                    <th>تاریخ</th>
                    <th>قیمت</th>
                </tr>

                <tr>

                    <?php


                    if(isset($_POST['submit'])) {


                        $number = 1;
                        $dateFrom = $_POST['dateFrom'];
                        $dateTo = $_POST['dateTo'];

                        $sql = "SELECT `shop_id`, `shop_desc`, `shop_qt`, `shop_cost`, `shop_date`, `shop_status` FROM shop WHERE (shop_date BETWEEN '$dateFrom' AND '$dateTo')";
                        $result = $conn->query($sql);


                        if ($result->num_rows > 0) {

                            while ($row = $result->fetch_assoc()) {

                                echo "<td>$number</td>";
                                echo "<td>$row[shop_desc]</td>";
                                echo "<td>$row[shop_qt]</td>";
                                echo "<td>$row[shop_date]</td>";
                                echo "<td>$row[shop_cost]</td>";
                                echo "</tr>";

                                $number++;
                                $cost += $row['shop_cost'];
                            }

                        }else {
                            echo "0 results";
                        }
                        $conn->close();
                    }

                    echo "<tr>
            <td colspan='4'>مجموع:</td>


            <td>$cost;</td>
            </tr>";
                    ?>

                </tbody>
            </table>
        </div>
        <br /><br/>

        <div class="row text-right-2">

            <div class="col-md-6" id="add_food_row_2">


                <div class="row" style="padding: 50px">
                    <button class="btn btn-info" id="add_food" style="float: right">فورم جدید</button>
                </div>

                <div id="form-elements" class="hidden">
                    <div id="form-elements form-inline">
                        <form method="post" action="insert_shop.php" class="form_right" enctype="multipart/form-data">
                            <fieldset>
                                <div class="form-group">
                                    <label>مشخصات</label>
                                    <input type="text" class="form-control" placeholder="" name="shop_desc">
                                </div>

                                <div class="form-group">
                                    <label>مقدار</label>
                                    <input type="text" class="form-control" placeholder="" name="shop_qt">
                                </div>

                                <div class="form-group">
                                    <label>تاریخ</label>
                                    <input id="datepicker3" class="input-small form-control" type="text" name="shop_Date">
                                </div>

                                <div class="form-group">
                                    <label>هزینه</label>
                                    <input type="text" class="form-control" placeholder="" name="shop_cost">
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