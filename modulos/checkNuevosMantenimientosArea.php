<?php
session_start();

if (isset($_SESSION['dni'])) {
    $dniUsuario = $_SESSION['dni'];
    $areaUsuario = $_SESSION['Area'];

    // Obtener la última conexión del usuario
    $ultimaConexion = date('Y-m-d H:i:s', strtotime($_SESSION['ultimaCon'])); // Asegúrate de tener esta variable definida correctamente

    // Consulta SQL para obtener nuevos mantenimientos de área desde la última conexión
    $sql = "SELECT * FROM mantenimientos 
            WHERE estado = 1 
            AND (area = '$areaUsuario' OR primerArea = '$areaUsuario') 
            AND usuarioDesignado != '$dniUsuario' 
            AND fechaCreacion > '$ultimaConexion'"; // Comparación con la última conexión
    // fechaHora > '$ultimaConexion') agregar a la consulta para que avise cada modificacion 

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
    $hayNuevosMantenimientosArea = !empty($mantenimientos);

    // Respuesta JSON a enviar al cliente
    $response = array(
        'mantenimientos' => $mantenimientos,
        'hayNuevosMantenimientosArea' => $hayNuevosMantenimientosArea
    );

    echo json_encode($response);

    // Liberar resultado y cerrar conexión
    mysqli_free_result($result);
    mysqli_close($conexion);
} else {
    echo json_encode(array('error' => 'Usuario no autenticado'));
}
?>
