var app = angular.module('viten', []);
app.controller('robotsCtrl', function($scope, $http) {

    $http.get('robots.json').success(function(data) {
       $scope.robots = data;
       console.log($scope.robots);
    });

    $scope.partClasses = function(part){
        if(part){
            if(part.collected){
                var collected = 'part-collected';
                var type = part.type;
                var variant = type+part.variant;
                return type + " " + variant + " " + collected;
            }
            else {
                return 'part-not-collected';
            }
        }else{console.log("part undefined in partClasses")}
        return "";
    }

    $scope.partStyles = function(part){
        if(part){
            var filter = "filter: hue-rotate("+part.hue+"deg) brightness("+part.brightness+");";
            return "-webkit-" + filter + " " + filter;
        }else{console.log("part undefined in partStyles")}
        return "";
    }
});