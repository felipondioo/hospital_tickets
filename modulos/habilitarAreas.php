<?php
include('conexion.php');

// Verificar si se recibieron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del área y el estado a establecer del formulario
    $id_area = $_POST['data_id'];
    $estado = $_POST['data_estado'];

    // Consulta para actualizar el estado del área
    $sql_actualizar = "UPDATE areas SET estado = '$estado' WHERE idArea = '$id_area'";

    // Ejecutar la consulta de actualización
    $resultado_actualizacion = $conexion->query($sql_actualizar);

    // Verificar si la actualización fue exitosa
    if ($resultado_actualizacion) {
        echo "0"; // Indicar que el área se habilitó correctamente
    } else {
        echo "1"; // Indicar que ocurrió un error al habilitar el área
    }
} else {
    echo "1"; // Indicar que no se recibieron datos por POST
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
