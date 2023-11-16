<?php
require_once "core/header.php";
require_once "core/db.php";

session_start();

if(!isset($_SESSION['user_type'])){
    header("Location: ../login.php");
}

if($_SESSION['user_type'] != 1){

if($_SESSION['user_type'] != 2){
    header("Location: ../login.php");
}
}


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

                }

                ?>



                <?php
                $sql = "SELECT * FROM food where food_type = 1";
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
                $sql = "SELECT * FROM subscriber";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    //while($row = $result->fetch_assoc()) {
                    $rows = array();
                    while ($r = mysqli_fetch_assoc($result)) {
                        $rows[] = $r;
                    }
//                        print json_encode( $rows, JSON_UNESCAPED_UNICODE );
                    $fp = fopen('person.json', 'w');
                    fwrite($fp, json_encode($rows, JSON_UNESCAPED_UNICODE));
                    fclose($fp);
                }
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

            <div id="print-area">
                <div class="text-right">
                <label class="hidden-print">اشتراک</label>


                <select class="form-control bigger hidden-print" ng-model="subscribers" ng-options="person as person.sub_name for person in members">

                </select><br/>

                <label class="hidden-print">شماره میز</label><br/>
                <input type="number" class="form-control hidden-print" name="" ng-model="form.table_number">

                </div>
                <br/>
            <div class="row text-right visible-print-block subtable">
                <table class="text-right-table">
                    <tr>
                        <td class="td-space">
                            اشتراک:
                        </td>
                        <td class="td-space">{{subscribers.sub_name}}</td>
                        <td class="td-space">
                            شماره میز:
                        </td>
                        <td class="td-space">{{form.table_number}}</td>
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
                    <td>مجموع</td>
                    <td> <!--<button class="btn btn-info hidden-print" ng-click="printDiv('print-area')";>چاپ</button> -->
                    <button class="btn btn-info hidden-print" ng-click="insertdate(subscribers.sub_id,form.table_number)">ثبت و چاپ</button>
                    </td>
                    <td>{{ getTotal() }}</td>
                    <td class="hidden-print">{{ deleteRow() }}</td>
                </tr>


            </table>

                <p>{{msg}}</p>
            </div>
        </div>


        </div>

</div>

    <?php require_once "footer.php"; ?>

<script src="../assets/js/angular.min.js"></script>
<script src="../assets/js/jquery.js"></script>
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


        $scope.getTotal = function(){
            var total = 0;

            for(var i = 0; i < $scope.rows.length; i++){
                var rows = $scope.rows[i];
                total += (rows.food_cost * rows.food_count);
            }
            return total;
        }


        $scope.removeRow = function (idx) {
            $scope.rows.splice(idx, 1);
        };


        $scope.insertdate = function(sub_id,table_num){


            var total = 0;

            for(var i = 0; i < $scope.rows.length; i++){
                var rows = $scope.rows[i];
                total += (rows.food_cost * rows.food_count);
            }



            var table_number = table_num;
            var subscriber_id = sub_id;

            //for(var i = 0; i < $scope.rows.length; i++){

//                var rows = $scope.rows[i];
//
//                food_id = rows.food_id;
//                food_name = rows.food_name;
//                food_cost = rows.food_cost;
//                food_count = rows.food_count;


                //total += (rows.food_cost * rows.food_count);

            $http.post("insert.php",{'food_cost': total, 'sub_id': subscriber_id, 'table_num': table_number })
                .success(function(){
                    $scope.msg="data inserted";
                });
            //}

                var printContents = document.getElementById('print-area').innerHTML;
                var popupWin = window.open('', '_blank', 'width=300,height=300');
                // this is for opening a new window with all order info~
                //popupWin.document.open();
                popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="../assets/css/styles.css" /></head><body onload="window.print()">' + printContents + '</body></html>');
                popupWin.document.close();

            location.reload();

        };

    }]);
</script>




</head>
</html>
