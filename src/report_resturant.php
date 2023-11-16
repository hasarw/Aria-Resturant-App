<?php

require_once "core/header.php";
require_once "core/db.php";

?>

<div class="container">
    <div class="row text-right-2 hidden-print">

    <form class="form-inline" action="report_resturant.php" method="post">
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

                    <button class="btn btn-primary" onclick="print()" >چاپ</button>
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
        <th>مشترک</th>
        <th>شماره میز</th>
        <th>قیمت مجموع</th>
        <th>تاریخ</th>
        </tr>
        <tr>

<?php


if(isset($_POST['submit'])) {

    $number = 1;
    $dateFrom = $_POST['dateFrom'];
    $dateTo = $_POST['dateTo'];

    if($dateFrom != "" && $dateTo != "") {

        $sql = "SELECT internal_order.int_order_id, internal_order.int_order_name, internal_order.int_order_table_num,internal_order.int_order_food_cost, internal_order.int_order_date,subscriber.sub_name FROM internal_order,subscriber WHERE (int_order_date BETWEEN '$dateFrom' AND '$dateTo') AND subscriber.sub_id = internal_order.int_order_name";
        $result = $conn->query($sql);


        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                echo "<td>$number</td>";
                echo "<td>$row[sub_name]</td>";
                echo "<td>$row[int_order_name]</td>";
                echo "<td>$row[int_order_food_cost]</td>";
                echo "<td>$row[int_order_date]</td>";
                echo "</tr>";

                $number++;
                $cost += $row['int_order_food_cost'];
            }

        } else {
            echo "0 results";
        }
        $conn->close();
    }
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