<?php
session_start();

if (isset($_SESSION['dni'])) {
    $dniUsuario = $_SESSION['dni'];

    // Obtener la última conexión del usuario en el formato correcto
    $ultimaConexion = date('Y-m-d H:i:s', strtotime($_SESSION['ultimaCon'])); 

    // Consulta SQL para obtener nuevos mantenimientos asignados al usuario desde la última conexión
    $sql = "SELECT * FROM mantenimientos 
            WHERE estado = 1 
            AND usuarioDesignado = '$dniUsuario' 
            AND (fechaCreacion > '$ultimaConexion' OR fechaHora > '$ultimaConexion')"; 

    // Realizar la conexión a la base de datos y ejecutar la consulta
    include('conexion.php');
    $result = mysqli_query($conexion, $sql);

    if (!$result) {
        echo json_encode(array('error' => 'Error en la consulta SQL'));
        exit;
    }

    // Procesar los resultados y construir el array de mantenimientos
    $mantenimientos = array();
    while ($fila = mysqli_fetch_assoc($result)) {
        $mantenimientos[] = $fila;
    }

    // Determinar si hay nuevos mantenimientos para enviar al cliente
    $hayNuevosMantenimientos = !empty($mantenimientos);

    // Respuesta JSON a enviar al cliente
    $response = array(
        'mantenimientos' => $mantenimientos,
        'hayNuevosMantenimientos' => $hayNuevosMantenimientos
    );

    echo json_encode($response);

    // Liberar resultado y cerrar conexión
    mysqli_free_result($result);
    mysqli_close($conexion);
} else {
    echo json_encode(array('error' => 'Usuario no autenticado'));
}
?>
