<?php

$mysqli = new mysqli("localhost", "root", "", "homecine");

if ($mysqli->connect_errno) {
    echo "Error al conectar a la base de datos (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
echo $mysqli->host_info . "\n";
