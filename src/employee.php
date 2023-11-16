<?php

require_once "core/header.php";
require_once "core/db.php";

?>

<div ng-app="app" ng-controller="MyCtrl">
    <div class="container">
        <div class="row text-right-2" style="margin-right: 20px; margin-left: 20px">
            <table class="table table-bordered">
                <tbody>
                <tr>
                   <th>شماره</th>
                   <th>نام کامل</th>
                   <th>حقوق ماهیانه</th>
                   <th>شماره تماس</th>
                   <th>تاریخ</th>
                   <th>حالت</th>
                   <th>تنظیمات</th>
                </tr>

                <tr>
                    <?php
                    $sql = "SELECT emp_id, emp_name, emp_salary, emp_phone, emp_date FROM employee WHERE emp_status = 1";
                    $result = $conn->query($sql);

                    $number = 1;
                    if ($result->num_rows > 0) {
                        $rowcount=mysqli_num_rows($result);
                        while ($row = $result->fetch_assoc()) {
                            echo "<td>$number</td>";
                            echo "<td>$row[emp_name]</td>";
                            echo "<td>$row[emp_salary]</td>";
                            echo "<td>$row[emp_phone]</td>";
                            echo "<td>$row[emp_date]</td>";
                            if($row[user_status] == 1){
                                $status = "فعال";
                            }else{
                                $status = "غیر فعال";
                            }
                            echo "<td>$status</td>";
                            echo "<td><button type='button' onclick='showDiv($row[emp_id])' class='btn btn-info'>برداشت پول</button>
                                  <a class='btn btn-sm btn-info' href='show_deposits.php?emp_id=$row[emp_id]'>مشاهده برداشت ها</a>
                                  <a class='btn btn-sm btn-info' href='employee.php?emp_id=$row[emp_id]'>غیر فعال</a>
                            </td>";
                            echo "</tr>";
                            $number++;
                        }
                    }else {
                        echo "0 results";
                    }


                    echo "<tr>
            <td colspan='6'>مجموع:</td>
            <td>$rowcount</td>
            </tr>";
                    ?>
                </tbody>
            </table>
        </div>
        <br /><br/>

        <div class="collapse money">
            <form method="post" action="insert_emp.php" class="form_right">

                    <div class="form-group">
                        <label>مبلغ</label>
                        <input type="text" class="form-control" placeholder="" name="cut_amount">
                    </div>

                    <div class="form-group hidden">
                        <input type="text" id="number" class="form-control" name="emp_id">
                    </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-info btn-sm" value="تایید" name="cut_money">
                </div>

            </form>
        </div>



        <div class="row text-right-2">

            <div class="col-md-6" id="add_food_row_2">


                <div class="row" style="padding: 50px">
                    <button class="btn btn-info" id="add_food" onclick="showAdd()" style="float: right">کارمند جدید</button>
                </div>

                <div class="collapse insertForm">
                    <div id="form-inline">
                        <form method="post" action="insert_emp.php" class="form_right" enctype="multipart/form-data">
                            <fieldset>
                                <div class="form-group">
                                    <label>نام کامل</label>
                                    <input type="text" class="form-control" placeholder="" name="emp_name">
                                </div>

                                <div class="form-group">
                                    <label>حقوق</label>
                                    <input type="text" class="form-control" placeholder="" name="emp_salary">
                                </div>


                                <div class="form-group">
                                    <label>تلفن</label>
                                    <input type="text" class="form-control" placeholder="" name="emp_phone">
                                </div>

                                <div class="form-group">
                                    <label>تاریخ</label>
                                    <input type="text" id="datepicker6" class="form-control" placeholder="" name="emp_date">
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
            function showAdd() {
                $(".insertForm").toggle(100);
            }
    </script>

    <?php

    if(isset($_GET['emp_id'])){

        $emp_id = $_GET['emp_id'];

        $query = "UPDATE `employee` SET `emp_status`= 0 WHERE `emp_id` = $emp_id";

        if ($conn->query($query) === TRUE) {
            echo "<script>window.location = 'employee.php';</script>";
        } else {
            echo "Error deleting record: " . $conn->error;
        }

        $conn->close();

    }


    ?>



    <?php require_once "footer.php"; ?>

<script>
    app = angular.module('app',[]);
    app.controller('MyCtrl', ['$scope','$http', function($scope, $http){
        $scope.form = {id: 'asdasdas'};

        $scope.show = function (a){
            alert(a);
        }

        $scope.insertdate = function(sub_id,table_num){

            var table_number = table_num;
            var subscriber_id = sub_id;

            $http.post("insert.php",{'food_cost': total })
                .success(function(){
                    $scope.msg="data inserted";
                });
        };
    }]);
</script>


<script type="text/javascript">
    function confirm_delete() {
        return confirm('آیا مطمعن هستید؟');
    }
</script>


<script type="text/javascript">
    function showDiv(id,emp_name) {
            $(".money").toggle(100);
            var number = id;
            var name = emp_name;
        $('#number').val(number);
        $('#emp_name').val(name);
    }
</script>
