<?php

namespace Core;

class View
{
    public function __construct(string $vista, array $params = [])
    {
        if (is_array($params)) {
            $data = $params;
        }

        $ruta_vista = './Vistas/' . $vista . 'View.php';

        if (file_exists($ruta_vista)){
            include_once "$ruta_vista";
        }else{
            $ruta_vista = './Vistas/404View.php';
            include_once "$ruta_vista";
        }
    }
}