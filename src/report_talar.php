<?php

require_once "core/header.php";
require_once "core/db.php";

?>

    <div class="container">
        <div class="row text-right-2 hidden-print">

            <form class="form-inline" action="report_talar.php" method="post">
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

                            <button class="btn btn-primary" onclick="window.print()" name="print">چاپ</button>
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
                <div class="text-center">
                    <legend class="hidden visible-print">تالار و رستوران قصر آریا</legend>
                </div>

                <tbody>
                <tr>
                    <th>شماره</th>
                    <th>نام</th>
                    <th> تعداد قوری</th>
                    <th>قیمت مجموع</th>
                    <th>تاریخ</th>
                </tr>
                <tr>

                    <?php


                    if(isset($_POST['submit'])) {


                        $number = 1;
                        $dateFrom = $_POST['dateFrom'];
                        $dateTo = $_POST['dateTo'];

                        $sql = "SELECT `talar_name`, `talar_phone`, `talar_time`, `talar_discount`, `talar_tax`, `talar_num_dish`, `talar_cost`, `talar_date` FROM talar WHERE (talar_date BETWEEN '$dateFrom' AND '$dateTo')";
                        $result = $conn->query($sql);


                        if ($result->num_rows > 0) {

                            while ($row = $result->fetch_assoc()) {

                                echo "<td>$number</td>";
                                echo "<td>$row[talar_name]</td>";
                                echo "<td>$row[talar_num_dish]</td>";
                                echo "<td>$row[talar_cost]</td>";
                                echo "<td>$row[talar_date]</td>";
                                echo "</tr>";

                                $number++;
                                $cost += $row['talar_cost'];
                            }

                        }else {
                            echo "0 results";
                        }
                        $conn->close();
                    }

                    echo "<tr>
            <td colspan='4'>مجموع:</td>


            <td>$cost</td>
            </tr>";
                    ?>

                </tbody>
            </table>
        </div>
    </div>

<?php require_once "footer.php"; ?>