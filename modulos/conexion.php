<?php
    $nombreServidor = "localhost";
    $usuario = "root";
    $contraseñaBD = "";
    $baseDeDatos = "hospital";
    $conexion =  mysqli_connect($nombreServidor, $usuario, $contraseñaBD, $baseDeDatos);
     // Establecer la zona horaria a Buenos Aires
    date_default_timezone_set('America/Argentina/Buenos_Aires');

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }
    else
    {
        // echo "conectado";
    }
?>