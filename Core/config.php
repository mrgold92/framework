<?php

session_start();

define("URL", "http://blog.test/");
//define("URL_SOCKET", "http://photoshare.test:5555");
define("TITLE", "Blog");
define("DEFAULT_CONTROLLER", "Home");
define("ERROR_CONTROLLER", "Error");
define("DEFAULT_ACTION", "index");
define("DEFAULT_VIEW", "Home");

//BASE DE DATOS
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "root");
define("DB_NAME", "framework");

//utils
if (isset($_SESSION['user_token'])) {
    define('TOKEN', $_SESSION['user_token']);
}else{
    define('TOKEN', null);
}

date_default_timezone_set("Europe/Madrid");