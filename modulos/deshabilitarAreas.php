<?php
    include('conexion.php');

    // Verificar si se recibió el ID del área por POST
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['data_id'])) {
        // Obtener el ID del área
        $id_area = $_POST['data_id'];

        // Consulta para actualizar el estado del área a 0 (deshabilitado)
        $sql_actualizar = "UPDATE areas SET estado = 0 WHERE idArea = $id_area";

        // Ejecutar la consulta de actualización
        $resultado_actualizacion = $conexion->query($sql_actualizar);

        // Verificar si la actualización fue exitosa
        if ($resultado_actualizacion) {
            echo "0"; // Indicar que el área se deshabilitó exitosamente
        } else {
            echo "1"; // Indicar que ocurrió un error al deshabilitar el área
        }
    } else {
        echo "1"; // Indicar que no se recibió el ID del área por POST
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
?>
