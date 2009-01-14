<?php
// Instantiate router and handle request
$route = new BaseJump\Router($request);
require CONFIG_ROOT . '/routes.php';
$route->go();
unset($route);
?>