<?php
// ================= FRONT CONTROLLER / ROUTER =================
// Every request comes here first, e.g. index.php?route=admin/medicines
// It figures out which Controller + method (action) to call.

session_start();
require_once 'models/Database.php';

$route = $_GET['route'] ?? 'home/index';
$parts = explode('/', $route);

$controllerName = ucfirst($parts[0] ?? 'home') . 'Controller';
$action = $parts[1] ?? 'index';

$controllerFile = 'controllers/' . $controllerName . '.php';

if (!file_exists($controllerFile)) {
    http_response_code(404);
    die('Page not found.');
}

require $controllerFile;

if (!class_exists($controllerName)) {
    http_response_code(404);
    die('Controller not found.');
}

$controller = new $controllerName();

if (!method_exists($controller, $action)) {
    http_response_code(404);
    die('Action not found.');
}

$controller->$action();
