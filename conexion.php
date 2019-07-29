<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'facturacion';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    echo 'Error en la conexion';
}


