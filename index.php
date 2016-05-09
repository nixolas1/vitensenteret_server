<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept'); 



$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

if(isset($request->robot))
    $robot = $request->robot;

if(isset($request->robot_name))
    $robot_name = $request->robot_name;

if(isset($request->player_name))
    $player_name = $request->player_name;

$list = json_decode(file_get_contents('robots.json'), true);


if(isset($robot) && isset($robot_name)){
    $robot = json_decode($robot);
    if (strlen($robot_name) > 15)
       $robot_name = substr($robot_name, 0, 15);

    if(!isset($player_name)){
        $player_name = "Anonymous";
    }

    if (strlen($player_name) > 30)
       $player_name = substr($player_name, 0, 30);

    $new_robot = array("robot_name"=>$robot_name, "player_name"=>$player_name, "parts" => $robot);

    array_unshift($list, $new_robot);
    file_put_contents("robots.json", json_encode($list));
    header("Status: 200 OK");
    exit();

}
else if(isset($robot) || isset($robot_name) || isset($player_name)){
    exit(header("Status: 400 Bad request"));
}


?>

<html>
    <head>
        <title>Vitensenteret</title>
        <script src="js/jquery.js"></script>
        <script src="js/angular.js"></script>
        <script src="js/app.js"></script>
        <link rel="stylesheet" type="text/css" href="css/ionic.app.css" title="Default" />
        <link rel="stylesheet" type="text/css" href="css/apps.css" title="Default" />
        <link rel="stylesheet" type="text/css" href="css/style.css" title="Default" />
    </head>
    <body>
        <div ng-app="viten" ng-controller="robotsCtrl">
            <div class="row flexyWrap">
                <div ng-repeat="robot in robots track by $index" class="col-30 center-margin">
                    <div class="list card">
                        <div class="item item-divider">
                            <h1>{{robot.robot_name}}</h1>
                            by {{robot.player_name}}
                        </div>


                        <div class="item item-body item-robot">
                            <div class="row">
                                <div class="col-100 part-robot"><!-- head -->
                                    <a class="sprite" ng-class="partClasses(robot.parts['head'])"  style="{{partStyles(robot.parts['head'])}}"></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-100 part-robot">
                                    <!-- body -->
                                    <div ng-class="robot.parts['arms'].collected? 'body-container' : ''">
                                        <a class="sprite" ng-class="partClasses(robot.parts['body'])"  style="{{partStyles(robot.parts['body'])}}"></a>
                                    </div>
                                    <!-- arms -->
                                    <a class="sprite" ng-class="partClasses(robot.parts['arms'])"  style="{{partStyles(robot.parts['arms'])}}"></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-100 part-robot"><!-- legs -->
                                    <a class="sprite" ng-class="partClasses(robot.parts['legs'])"  style="{{partStyles(robot.parts['legs'])}}"></a>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
            
        </div>
    </body>
</html>