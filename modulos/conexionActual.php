<?php
session_start();

if (isset($_SESSION['dni'])) {
    date_default_timezone_set('America/Argentina/Buenos_Aires');

    // Formato original de la sesión
    $formatoSesion = 'd-m-Y H:i:s';
    
    // Nueva fecha en formato Y-m-d H:i:s para la base de datos
    $ultimaCon = date('Y-m-d H:i:s');
    
    // Actualizar la variable de sesión con el formato original
    $_SESSION['ultimaCon'] = date($formatoSesion, strtotime($ultimaCon));

    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('error' => 'Usuario no autenticado'));
}
?>
