<?php

namespace Controladores;

use ConfigControlador;
use Modelos\Users;

require_once './Modelos/Users-example.php';

class HomeController extends ConfigControlador
{

    public function index(array $params = [])
    {

        $users = (new Users('usuarios'))->getAll();

        self::View('Home', $users);
    }
}