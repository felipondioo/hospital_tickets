<?php 
include('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST['dni'];
    $token = $_POST['token'];
    $nuevaContraseña = $_POST['nuevaContraseña'];

    // Hash de la nueva contraseña
    $hashedPassword = password_hash($nuevaContraseña, PASSWORD_DEFAULT);

    // Preparar y ejecutar la consulta para actualizar la contraseña
    $query = "UPDATE usuarios SET contraseña = ? WHERE dni = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ss", $hashedPassword, $dni);

    if ($stmt->execute()) {
        // Si la contraseña se actualizó correctamente, proceder a eliminar el token
        $deleteTokenQuery = "DELETE FROM tokens WHERE dni = ? AND token = ?";
        $stmtToken = $conexion->prepare($deleteTokenQuery);
        $stmtToken->bind_param("ss", $dni, $token);

        if ($stmtToken->execute()) {
            // Si el token se elimina correctamente, redirigir al usuario
            header("Location: ../login.php?message=success_password");
        } else {
            // Si falla la eliminación del token, redirigir con un mensaje de error
            header("Location: ../login.php?message=error_token");
        }
    } else {
        // Si la actualización de la contraseña falla, redirigir con un mensaje de error
        header("Location: ../login.php?message=error_password");
    }
} else {
    header("Location: ../login.php?message=error_request");
}

$conexion->close();
?>
