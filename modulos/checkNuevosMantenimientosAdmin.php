<?php
session_start();

if (isset($_SESSION['dni'])) {
    $dniUsuario = $_SESSION['dni'];

    // Obtener la última conexión del usuario en el formato correcto
    $ultimaConexion = date('Y-m-d H:i:s', strtotime($_SESSION['ultimaCon'])); 

    // Realizar la conexión a la base de datos
    include('conexion.php');

    // Consulta previa para obtener el nombre del área con idArea = 1
    $sql_area = "SELECT nombre FROM areas WHERE idArea = 1 AND estado = 1";
    $result_area = mysqli_query($conexion, $sql_area);

    if ($result_area && mysqli_num_rows($result_area) > 0) {
        $fila_area = mysqli_fetch_assoc($result_area);
        $nombreArea = $fila_area['nombre'];
    } else {
        echo json_encode(array('error' => 'Área no encontrada o inactiva'));
        exit;
    }

    // Consulta SQL para obtener nuevos mantenimientos del área de administración desde la última conexión
    $sql = "SELECT * FROM mantenimientos 
            WHERE estado = 1 
            AND area = '$nombreArea' 
            AND (fechaCreacion > '$ultimaConexion' OR fechaHora > '$ultimaConexion') 
            ORDER BY prioridad DESC, fechaHora ASC"; 

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
