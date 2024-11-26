<?php
include('conexion.php');

// Establecer la zona horaria a Buenos Aires, Argentina
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Verificar si se proporcionaron los datos requeridos
if (isset($_POST['dni']) && isset($_POST['nuevaContraseña'])) {
    // Obtener los datos del formulario
    $dni = $_POST['dni'];
    $nuevaContraseña = $_POST['nuevaContraseña'];
    
    // Hashear la nueva contraseña para almacenarla de forma segura
    $nuevaContraseñaHash = password_hash($nuevaContraseña, PASSWORD_BCRYPT);

    // Actualizar la contraseña y el estado del usuario en la base de datos
    $query = "UPDATE usuarios SET contraseña = ?, estado = 1 WHERE dni = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "ss", $nuevaContraseñaHash, $dni);

    if (mysqli_stmt_execute($stmt)) {
        // Eliminar el token de la base de datos después de verificar
        $queryEliminarToken = "DELETE FROM tokens WHERE dni = ?";
        $stmtEliminarToken = mysqli_prepare($conexion, $queryEliminarToken);
        mysqli_stmt_bind_param($stmtEliminarToken, "i", $dni);
        mysqli_stmt_execute($stmtEliminarToken);

        // Redirigir a una página de éxito o inicio de sesión
        header('Location: ../login.php');
        exit();
    } else {
        echo "Error al actualizar la contraseña. Por favor, intente nuevamente.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
} else {
    echo "Datos insuficientes proporcionados.";
}
?>
