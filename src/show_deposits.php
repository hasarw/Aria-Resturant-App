<?php


require_once "core/header.php";
require_once "core/db.php";

if(!isset($_GET['emp_id'])){
    header ("location: employee.php");
}

$emp_id = $_GET['emp_id'];

?>
<div class="container">
    <div class="row text-right-2">


<table class='table table-bordered'>
                <tbody>
                <tr>
                   <th>شماره</th>
                   <th>مبلغ </th>
                   <th>تاریخ</th>
                </tr>
                <?php

                    $sql = "SELECT employee.emp_name, employee_debit.`debit_amount`, employee_debit.`debit_date` FROM `employee_debit`, employee WHERE `debit_emp_id` = $emp_id AND `debit_emp_id` = employee.emp_id";
                    $result = $conn->query($sql);

                    $number = 1;
                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {

                            echo "<tr><td>$number</td>";
                            echo "<td>$row[debit_amount]</td>";
                            echo "<td>$row[debit_date]</td>";
                            echo "</tr>";
                            $number++;
                        }
                    }else {
                        echo "0 results";
                    }
                    $conn->close();

                ?>
</tbody>
</table>
    </div>
</div>