<?php
    include('conexion.php');

    // Verificar si se recibieron datos por POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener el nombre del área y el estado del formulario
        $nombre_area = $_POST['data_nombre'];
        $estado = 1;

        // Convertir el nombre del área a minúsculas
        $nombre_area = strtolower($nombre_area);

        // Consulta para verificar si el área ya existe en la base de datos
        $sql_verificar = "SELECT * FROM areas WHERE LOWER(nombre) = LOWER('$nombre_area')";

        // Ejecutar la consulta de verificación
        $resultado_verificacion = $conexion->query($sql_verificar);

        // Si la consulta se ejecuta correctamente
        if ($resultado_verificacion) {
            // Si se encontró algún registro con el mismo nombre de área
            if ($resultado_verificacion->num_rows > 0) {
                // Obtener el estado del área existente
                $fila = $resultado_verificacion->fetch_assoc();
                $estado_existente = $fila['estado'];

                // Si el estado ingresado es diferente al estado existente
                if ($estado_existente != $estado) {
                    // Actualizar el estado del área existente
                    $sql_actualizar = "UPDATE areas SET estado = $estado WHERE LOWER(nombre) = LOWER('$nombre_area')";

                    // Ejecutar la consulta de actualización
                    $resultado_actualizacion = $conexion->query($sql_actualizar);

                    // Verificar si la actualización fue exitosa
                    if ($resultado_actualizacion) {
                        echo "0"; // Indicar que el estado del área se actualizó exitosamente
                    } else {
                        echo "-1"; // Indicar que ocurrió un error al actualizar el estado del área
                    }
                } else {
                    echo "1"; // Indicar que el área ya existe con el mismo estado
                }
            } else {
                // Si el área no existe, proceder a insertarla en la base de datos
                $sql_insertar = "INSERT INTO areas (nombre, estado) VALUES ('$nombre_area', $estado)";

                // Ejecutar la consulta de inserción
                $resultado_insercion = $conexion->query($sql_insertar);

                // Verificar si la inserción fue exitosa
                if ($resultado_insercion) {
                    echo "0"; // Indicar que el área se creó exitosamente
                } else {
                    echo "-1"; // Indicar que ocurrió un error al insertar el área
                }
            }
        } else {
            echo "-1"; // Indicar que ocurrió un error al verificar el área
        }
    } else {
        echo "-1"; // Indicar que no se recibieron datos por POST
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
?>
