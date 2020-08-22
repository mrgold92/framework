<?php

declare(strict_types=1);

use Core\View;

require_once './Core/View.php';
require_once './Core/Model.php';
require_once './Core/Utils.php';

abstract class ConfigControlador
{
    private static $controller;
    private static $action;
    private static $parametros = [];
    private static $URL;
    public static $view;


    public static function getController(): string
    {
        if (!isset($_GET['v'])) {
            self::$controller = DEFAULT_CONTROLLER;
        } else {
            self::$URL        = $_GET['v'];
            $c                = explode('/', self::$URL);
            self::$controller = $c[0];
        }

        return self::$controller;
    }

    public static function getAction(): string
    {
        if (self::$URL != null) {
            $c = explode("/", self::$URL);

            if (count($c) > 1) {
                self::$action = $c[1];
            } else {
                self::$action = DEFAULT_ACTION;
            }
        } else {
            self::$action = DEFAULT_ACTION;
        }

        return self::$action;
    }

    /**
     * Obtenemos el parámetros que le pasemos a la acción
     *
     * @return array
     */
    public static function getParametros(): array
    {
        if (self::$URL != null) {
            $c = explode("/", self::$URL);

            if (count($c) > 2) {
                for ($i = 2; $i < count($c); $i++) {
                    self::$parametros[] = $c[$i];
                }
            }
        } else {
            self::$parametros = [];
        }


        return self::$parametros;
    }

    /**
     * Como todos nuestros controladores heredarán de esta clase, solo
     * tendremos que llamar a este método para crear una vista.
     *
     * @param string $view
     * @param array $params
     */
    public static function View(string $view, array $params = [])
    {

        self::$view = new view($view, $params);
    }

    public static function redirect($where)
    {
        header("location:" . $where);
    }

    abstract public function index(array $params = []);

}