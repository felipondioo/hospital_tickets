<?php
// Verificar si se recibió el ID del usuario por método POST
if (isset($_POST['id'])) {
    // Obtener el ID del usuario desde el formulario
    $idUsuario = $_POST['id'];

    // Incluir el archivo de conexión a la base de datos
    include ('conexion.php'); // Asegúrate de cambiar 'conexion.php' por el nombre real de tu archivo

    // Preparar la consulta SQL para eliminar el usuario
    $sql = "UPDATE usuarios SET estado = '0' WHERE dni = '$idUsuario'";

    // Ejecutar la consulta y verificar si se realizó con éxito
    if ($conexion->query($sql) === TRUE) {
        echo 'success'; // Devolver 'success' si se eliminó correctamente
    } else {
        echo 'error'; // Devolver 'error' si hubo algún problema al eliminar el usuario
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
} else {
    // Si no se recibió el ID del usuario, mostrar un mensaje de error
    echo 'No se recibió el ID del usuario.';
}
?>
