<?php
session_start();

if (isset($_SESSION['dni'])) {
    $dniUsuario = $_SESSION['dni'];

    // Obtener la última conexión del usuario en el formato correcto
    $ultimaConexion = date('Y-m-d H:i:s', strtotime($_SESSION['ultimaCon'])); 

    // Realizar la conexión a la base de datos
    include('conexion.php');

    // Consulta SQL para obtener nuevas solicitudes desde la última conexión
    $sql = "SELECT * FROM solicitudes 
            WHERE estado = 1 
            AND fecha_emision > '$ultimaConexion'
            ORDER BY prioridad DESC, fecha_emision ASC"; 

    $result = mysqli_query($conexion, $sql);

    if (!$result) {
        echo json_encode(array('error' => 'Error en la consulta SQL'));
        exit;
    }

    // Procesar los resultados y construir el array de solicitudes
    $solicitudes = array();
    while ($fila = mysqli_fetch_assoc($result)) {
        $solicitudes[] = $fila;
    }

    // Determinar si hay nuevas solicitudes para enviar al cliente
    $hayNuevasSolicitudes = !empty($solicitudes);

    // Respuesta JSON a enviar al cliente
    $response = array(
        'solicitudes' => $solicitudes,
        'hayNuevasSolicitudes' => $hayNuevasSolicitudes
    );

    echo json_encode($response);

    // Liberar resultado y cerrar conexión
    mysqli_free_result($result);
    mysqli_close($conexion);
} else {
    echo json_encode(array('error' => 'Usuario no autenticado'));
}
?>
