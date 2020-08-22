<?php

require_once './Core/View.php';


class ErrorController extends ConfigControlador {

    public function index(array $params = [])
    {

        $this->View('404');
    }
}