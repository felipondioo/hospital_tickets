<?php
    include('conexion.php');

    $idSolicitud = $_POST['idSolicitud'];
    $respuestaEstado = $_POST['respuesta'];

    if($respuestaEstado == "Aceptar"){
        $sql = "UPDATE solicitudes SET estado = 2 WHERE id_solicitud = $idSolicitud";

        if ($conexion->query($sql) === TRUE) {
            echo "Estado de la solicitud actualizado correctamente";
        }
    }
    else if($respuestaEstado == "Denegar"){
        $sql = "UPDATE solicitudes SET estado = 0 WHERE id_solicitud = $idSolicitud";

        if ($conexion->query($sql) === TRUE) {
            echo "Estado de la solicitud actualizado correctamente";
        }
    } 
    else {
        echo "Error al actualizar el estado de la solicitud: " . $conexion->error;
    }

    $conexion->close();
?>
