<?php

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes) {

    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder) {
        $builder->connect('/', ['controller' => 'Timebucks', 'action' => 'index']);
        $builder->connect('/getRecords', ['controller' => 'Timebucks', 'action' => 'getRecords', 'method' => 'post']);
        $builder->fallbacks();
    });

};
