<?php
include('conexion.php');

$sql = "SELECT * FROM areas";
$resultadoAreas = $conexion->query($sql);

$areas = array();
if ($resultadoAreas) {
    while ($fila = $resultadoAreas->fetch_assoc()) {
        $nombreArea = ucfirst(mb_strtolower($fila['nombre'], 'UTF-8'));
        $datos = array(
            'id' => $fila['idArea'],
            'nombre' => $nombreArea,
            'estado' => $fila['estado']
        );
        $areas[] = $datos;
    }
    echo json_encode($areas);
} else {
    echo json_encode(array('error' => 'Error en la consulta: ' . $conexion->error));
}

mysqli_free_result($resultadoAreas);
$conexion->close();
?>
