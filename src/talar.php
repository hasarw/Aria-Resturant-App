<?php
require_once "core/header.php";
require_once "core/db.php";
?>

<div ng-app="app" ng-controller="MyCtrl">
    <div class="container">
        <div class="col-md-8">

            <?php

            $sql = "SELECT int_order_id_num FROM internal_order ORDER BY int_order_id_num DESC LIMIT 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $last_order_id = $row['int_order_id_num'];
                    session_start();
                    $_SESSION['last_order_id'] = $last_order_id;
                }
            } else {
                //echo "0 results";
            }
            ?>

            <?php
            $sql = "SELECT * FROM food where food_type = 2";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                //while($row = $result->fetch_assoc()) {
                $rows = array();
                while($r = mysqli_fetch_assoc($result)) {
                    $rows[] = $r;
                }
//                        print json_encode( $rows, JSON_UNESCAPED_UNICODE );
                $fp = fopen('results.json', 'w');
                fwrite($fp, json_encode($rows, JSON_UNESCAPED_UNICODE ));
                fclose($fp);
                ?>

            <?php
            }
            else {
                echo "0 results";
            }
            $conn->close();
            ?>

            <ul class="list-inline" >
                <li ng-repeat="food in foods" class="food_list">

                    <img class="img-box" src="images/{{ food.food_photo }}" ng-click = 'addRow(food)'><br/><span>{{food.food_name}}</span>

                </li>
            </ul>
        </div>

        <div class="col-md-4">
                <div class="text-right">

                    <label class="hidden-print">نام</label>
                    <input type="text" class="form-control hidden-print" name="" ng-model="form.order_name">

                    <label class="hidden-print">تلفن</label><br/>
                    <input type="number" class="form-control hidden-print" name="" ng-model="form.order_phone">

                    <label class="hidden-print">تاریخ</label><br/>
                    <input type="text"   class="form-control hidden-print" name="" ng-model="form.order_date" ng-value="form.order_date" id="datepicker7">

                    <label class="hidden-print">زمان</label><br/>
                    <select class="form-control hidden-print" ng-model="form.order_time">
                        <option selected="selected">...</option>
                        <option>چاشت</option>
                        <option>شب</option>
                    </select>

                </div>
                <br/>


            <div id="print-area">
            <div class="row text-right visible-print-block subtable">
            <table class="text-right-table">
                <tr>
                    <td class="td-space">
نام:
                    </td>
                    <td class="td-space">{{form.order_name}}</td>
                    <td class="td-space">
تلفن:
                    </td>
                    <td class="td-space">{{form.order_phone}}</td>
                </tr>
                <tr>
                    <td class="td-space">
تاریخ:
                    </td>
                    <td class="td-space">{{form.order_date}}</td>
                    <td class="td-space">
زمان:
                    </td>
                    <td class="td-space">{{form.order_time}}</td>
                </tr>
            </table>
            </div>

                <table class="table" id="table-right">
                    <tr>
                        <th>نام غذا</th>
                        <th>تعداد</th>
                        <th>قیمت</th>
                        <th class="hidden-print">حذف</th>
                    </tr>

                    <tr ng-repeat="row in rows track by $index">
                        <td>{{row.food_name}}</td>
                        <td><input type="number" class="form-control"  ng-model="row.food_count" ng-value="row.food_count" ng-init="row.food_count" style="width: 100px"> </td>
                        <td>{{row.food_cost}}</td>
                        <td class="hidden-print"><button class="btn btn-info hidden-print"  data-ng-click="removeRow($index)">حذف</button></td>
                    </tr>

                    <tr ng-repeat-end>
                        <td colspan="4">
                            <label class="visible-print-block">قوری</label>
                            <input type="text" ng-model="row.food_ghori" ng-value="row.food_ghori" class="form-control" placeholder="تعداد قوری">
                        </td>
                    </tr>


                    <tr ng-repeat-end>

                        <td >
                            <label class="visible-print-block">تخفیف</label>
                            <input type="text" ng-model="row.food_discount" ng-value="row.food_discount" class="form-control" placeholder="تخفیف">
                        </td>

                        <td colspan="3">
                            <label class="visible-print-block">تکس تالار</label>
                            <input type="text" ng-model="row.food_tax" ng-value="row.food_tax" class="form-control" placeholder="تکس تالار">
                        </td>

                    </tr>


                    <tr ng-repeat-end>
                        <td>مجموع</td>
                        <td> <!--<button class="btn btn-info hidden-print" ng-click="printDiv('print-area')";>چاپ</button> -->
                            <button class="btn btn-info hidden-print" ng-click="insertdate(form.order_name,form.order_phone,form.order_date,form.order_time,row.food_ghori,row.food_discount,row.food_tax)">ثبت و چاپ</button>
                        </td>
                        <td>{{ getTotal(row.food_discount,row.food_tax,row.food_ghori) }}</td>
                        <td class="hidden-print">{{ deleteRow() }}</td>
                    </tr>


                </table>

                <p>{{msg}}</p>
            </div>
        </div>


    </div>

</div>

<?php require_once "footer_2.php"; ?>

<script src="../assets/js/angular.min.js"></script>

<script>
    app = angular.module('app',[]);
    app.controller('MyCtrl', ['$scope','$http', function($scope, $http){

        //get from the json file
        angular.element(document).ready(function(){

            var request2 = $http({
                method: "get",
                url : "person.json"
            });

            request2.then(function(response){
                $scope.members = response.data;
            });

            var request = $http({
                method: "get",
                url : "results.json"
            });

            request.then(function(response){
                $scope.foods = response.data;
            });
        });

        $scope.rows = [];
        $scope.counter = 0;

        $scope.addRow = function(obj) {
            $scope.foodname = obj.id;
            $scope.foodprice = obj.price;
            $scope.rows.push(obj);
            $scope.counter++;
        }



        $scope.getTotal = function(a,b,food_ghori){
            var total = 0;
            var tax = a;
            var discount = b;
            var c = tax - discount;
            var food_dish = food_ghori;

            for(var i = 0; i < $scope.rows.length; i++){
                var rows = $scope.rows[i];
                total += (rows.food_cost * rows.food_count)-c;
            }
            return (total * food_dish);
        }

        $scope.removeRow = function (idx) {
            $scope.rows.splice(idx, 1);
        };

        $scope.insertdate = function(order_name,order_phone,order_date,order_time,food_ghori,food_discount,food_tax){
            var total = 0;
            for(var i = 0; i < $scope.rows.length; i++){
                var rows = $scope.rows[i];
                total += (rows.food_cost * rows.food_count);
            }

            var order_name = order_name;
            var order_phone = order_phone;
            var order_date = order_date;
            var order_time = order_time;
            var food_ghori = food_ghori;
            var food_discount = food_discount;
            var food_tax = food_tax;

            var talar = order_name;
            $http.post("insert_talar.php",{'talar_name':talar,'order_name':order_name,'order_phone':order_phone,'order_date':order_date,'order_time':order_time,'food_ghori':food_ghori,'food_discount':food_discount,'food_tax':food_tax,'food_cost':total})
                .success(function(){
                    $scope.msg="data inserted";
                });
            //}

            var printContents = document.getElementById('print-area').innerHTML;
            var popupWin = window.open('', '_blank', 'width=300,height=300');
            popupWin.document.open();
            popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="../assets/css/styles.css" /></head><body onload="window.print()">' + printContents + '</body></html>');
            popupWin.document.close();

            location.reload();

        };

    }]);
</script>




</head>
</html>
