<?php
    include('conexion.php');

    $idSolicitud = $_POST['idSolicitud'];
    $respuestaEstado = $_POST['respuesta'];
    
    if (isset($_POST['idSolicitud'])){
        if($respuestaEstado == "Cancelar"){
            $sql = "DELETE FROM solicitudes WHERE estado = 1 AND id_solicitud = $idSolicitud";
    
            if ($conexion->query($sql) === TRUE) {
                echo "Solicitud cancelada correctamente";
            }
        }
        elseif($respuestaEstado == "Eliminar"){
            $sql = "UPDATE `solicitudes` SET `estado`= 4 WHERE id_solicitud = $idSolicitud";
    
            if ($conexion->query($sql) === TRUE) {
                echo "Solicitud eliminada correctamente";
            }
        }
        else if($respuestaEstado == "Archivar"){
            $sql = "UPDATE solicitudes SET estado = 3 WHERE id_solicitud = $idSolicitud";
    
            if ($conexion->query($sql) === TRUE) {
                echo "Solicitud archivada correctamente";
            }
        }
        else {
            echo "Error al actualizar el estado de la solicitud: " . $conexion->error;
        }
    }

    $conexion->close();
?>
