<?php

require_once './Modelos/Users.php';

class HomeController extends ConfigControlador
{

    public function index(array $params = [])
    {

        $users = (new Users('usuarios'))->getAll();

        self::View('Home', $users);
    }
}