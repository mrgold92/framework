<?php


class Logger
{
    public function debug($name, $var, $method = false)
    {
        $bt     = debug_backtrace();
        $caller = array_shift($bt);
        $m      = '';

        if ($method) $m = "function: " . $method . "()";

        $array = explode('\\', $caller['file']);
        print('</br><b>Logger::Debug</b> at File: <b>' .
            end($array) . '</b> at line <b>' .
            $caller['line'] . '</b> ' . $m . '</br></br> <span style="margin-left:15px;">$' . $name . ':</span>');
        print_r($var);
        print('</br></br><b>End of debug</b></br></br>');
    }

    public function msg($msg, $method = false)
    {
        $bt     = debug_backtrace();
        $caller = array_shift($bt);
        $m      = '';

        if ($method) $m = "function: " . $method . "()";

        $array = explode('\\', $caller['file']);
        print('</br><b>Logger::msg</b> at File: <b>' .
            end($array) . '</b> at line <b>' .
            $caller['line'] . '</b> ' . $m . ': "' . $msg . '"</br></br>');
    }

    public function alert($msg, $var, $method = false)
    {
        $bt     = debug_backtrace();
        $caller = array_shift($bt);
        $m      = '';

        if ($method) $m = "function: " . $method . "()";

        $array = explode('\\', $caller['file']);
        print('</br><b>Logger::Alert</b> at File: <b>' .
            end($array) . '</b> at line <b>' .
            $caller['line'] . '</b> ' . $m . '</br></br> <span style="margin-left:15px; color:rgb(217,30,24);">' . $msg . ': </span>');
        print_r($var);
        print('</br></br><b>End of debug</b></br></br>');
    }
}