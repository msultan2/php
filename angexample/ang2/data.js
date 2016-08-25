function GetUsers($scope, $http) {
    // this is where the JSON from api.php is consumed
    $http.get('http://egoct-wipsd01/angexample/ang2/api.php').
        success(function(data) {
            // here the data from the api is assigned to a variable named users
            $scope.users = data;
        });
}