<?php

define("HOST", 'localhost');
define("BD", 'empresa');
define("USER_BD", 'root');
define("PASS_BD", '');

function conecta()
{
    $con = new mysqli(HOST, USER_BD, PASS_BD, BD);
    if ($con->connect_error) {
        die('Conexion fallida' . $con->connect_error);
    }
    $con->set_charset('utf8');
    return $con;
}
