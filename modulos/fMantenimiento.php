<?php
    header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1
    header("Pragma: no-cache"); // HTTP 1.0
    header("Expires: 0"); // Proxies

    include('conexion.php');

    // Recibir variables
    $id = $_POST['data_id'];
    $estado = $_POST['data_estado'];
    $fechaHora = date('Y-m-d H:i:s');
    
    // Consulta preparada para actualizar el mantenimiento en la base de datos
    $sql_actualizar = "UPDATE mantenimientos SET fechaHora = ?, estado = ? WHERE id = ?";
    $stmt_actualizar = mysqli_prepare($conexion, $sql_actualizar);

    // Vincular parámetros y ejecutar la consulta
    mysqli_stmt_bind_param($stmt_actualizar, "ssi", 
        $fechaHora,
        $estado,
        $id
    );

    // Ejecutar la consulta de actualización
    mysqli_stmt_execute($stmt_actualizar);

    // Verificar si la actualización fue exitosa
    if (mysqli_stmt_affected_rows($stmt_actualizar) > 0) {
        echo "Mantenimiento finalizado correctamente.";
    } else {
        echo "Error al actualizar el mantenimiento: " . mysqli_error($conexion);
    }

    // Cerrar la declaración y la conexión
    mysqli_stmt_close($stmt_actualizar);
    mysqli_close($conexion);
?>