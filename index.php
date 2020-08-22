<?php

declare(strict_types=1);

require_once 'Core/config.php';
require_once 'Core/ConfigControlador.php';

$controller = ucwords(ConfigControlador::getController());

$ruta_controller = './Controladores/' . $controller . 'Controller.php';

if (file_exists($ruta_controller)) {
    $accion     = ConfigControlador::getAction();
    $parametros = ConfigControlador::getParametros();

    require_once "$ruta_controller";

    $controller = $controller . 'Controller';
    $controller = new $controller;

    if (method_exists($controller, $accion)) {
        if (!empty($parametros)) {
            $controller->$accion($parametros);
        } else {
            $controller->$accion();
        }
    } else {
        $controller = new $controller;
        $accion     = DEFAULT_ACTION;

        if (method_exists($controller, $accion)) {
            $para   = $_GET['v'];
            $params = explode('/', $para);
            $controller->$accion($params[1]);
        }
    }
} else {
    $ruta_controller = './Controladores/' . ERROR_CONTROLLER . 'Controller.php';
    require_once "$ruta_controller";

    $controller = ERROR_CONTROLLER . 'Controller';
    $controller = new $controller;

    $accion = 'index';
    if (method_exists($controller, $accion)) {
        $controller->$accion();
    }
}