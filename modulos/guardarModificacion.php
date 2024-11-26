<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $gmail = $_POST['gmail'];
    $cargo = $_POST['cargo'];
    $area = $_POST['area'];

    include('conexion.php');

    // Actualiza todos los campos excepto el DNI
    $sql = "UPDATE usuarios SET nombre = '$nombre', apellido = '$apellido', gmail = '$gmail', cargo = '$cargo', area = '$area' WHERE dni = '$dni'";

    if ($conexion->query($sql) === TRUE) {
        echo "Usuario modificado existosamente"; // Devuelve un mensaje de éxito
    } else {
        echo "Error al actualizar el usuario: " . $conexion->error;
    }

    $conexion->close();
} else {
    echo "Error: El formulario no se envió correctamente.";
}
?>
