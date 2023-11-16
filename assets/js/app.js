/**
 * Created by Hekmat on 11/10/2016.
 */

app = angular.module('app',[]);
app.controller('MyCtrl', function($scope){
    $scope.myData = [];
    $scope.addData = function(){
        $scope.myData.push($scope.inData);
        $scope.inData="";
    }
    $scope.removeData = function(selData){
        $scope.myData.splic($scope.myData.indexOf(data),1);
    }
});