<?php

namespace Controladores;

use ConfigControlador;




class ErrorController extends ConfigControlador {

    public function index(array $params = [])
    {

        self::View('404');
    }
}