<?php
session_start();
include('conexion.php');

// Verificar si los datos fueron enviados
if (isset($_POST['data_nombre']) && isset($_POST['data_color'])) {
    $nombre = $_POST['data_nombre'];
    $color = $_POST['data_color'];

    // Convertir el nombre a minúsculas para la comparación
    $nombreMinusculas = mb_strtolower($nombre, 'UTF-8');

    // Verificar si ya existe una prioridad con el mismo nombre (ignorando mayúsculas/minúsculas)
    $sqlVerificar = "SELECT * FROM prioridades WHERE LOWER(nombrePrioridad) = ?";
    $stmtVerificar = $conexion->prepare($sqlVerificar);
    $stmtVerificar->bind_param('s', $nombreMinusculas);
    $stmtVerificar->execute();
    $resultadoVerificar = $stmtVerificar->get_result();

    if ($resultadoVerificar->num_rows > 0) {
        echo "1"; // Prioridad existente
    } else {
        // Insertar la nueva prioridad
        $estado = 1; // Estado predeterminado
        $sqlInsertar = "INSERT INTO prioridades (nombrePrioridad, colorHEX, estado) VALUES (?, ?, ?)";
        $stmtInsertar = $conexion->prepare($sqlInsertar);
        $stmtInsertar->bind_param('ssi', $nombre, $color, $estado);

        if ($stmtInsertar->execute()) {
            echo "0"; // Éxito
        } else {
            echo "2"; // Error en la inserción
        }
    }

    // Liberar recursos
    $stmtVerificar->close();
    $stmtInsertar->close();
} else {
    echo "3"; // Datos no enviados correctamente
}

// Cerrar la conexión
$conexion->close();
?>
