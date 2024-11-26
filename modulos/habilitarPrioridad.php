<?php
session_start();
include('conexion.php');

// Verificar si los datos fueron enviados
if (isset($_POST['data_id']) && isset($_POST['data_estado'])) {
    $idPrioridad = $_POST['data_id'];
    $estado = $_POST['data_estado'];

    // Preparar y ejecutar la consulta para actualizar el estado
    $sqlActualizar = "UPDATE prioridades SET estado = ? WHERE idPrioridad = ?";
    $stmtActualizar = $conexion->prepare($sqlActualizar);
    $stmtActualizar->bind_param('ii', $estado, $idPrioridad);

    if ($stmtActualizar->execute()) {
        echo "0"; // Éxito
    } else {
        echo "1"; // Error en la actualización
    }

    // Liberar recursos
    $stmtActualizar->close();
} else {
    echo "1"; // Datos no enviados correctamente
}

// Cerrar la conexión
$conexion->close();
?>
