<?php
// Verificar si la solicitud es mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Iniciar sesión para acceder a las variables de sesión
    session_start();
    
    // Obtener los datos del formulario
    $id = $_POST['data_id'];
    $descripcion1 = $_POST['data_descripcion'];
    $area = $_POST['data_select'];
    $estado = $_POST['data_estado'];

    // Obtener datos de sesión y convertir la primera letra del área a mayúscula
    $areaSesion = ucfirst($_SESSION['Area']);
    $usuario = $_SESSION['Usuario'];
    $apellido = $_SESSION['Apellido'];

    // Establecer la zona horaria a Buenos Aires
    date_default_timezone_set('America/Argentina/Buenos_Aires');

    // Formatear la fecha y la hora
    $fechaHora = date('Y-m-d H:i:s'); // Formato para la base de datos
    $fechaHoraDescripcion = date('d/m/y H:i:s'); // Formato para la descripción

    // Concatenar la fecha y la hora formateada con la descripción
    $descripcion2 = $areaSesion . ': ' . $descripcion1 . ' ____ fecha y hora: ' . $fechaHoraDescripcion . ' ____ empleado: ' . $usuario . ' ' . $apellido;

    // Incluir el archivo de conexión a la base de datos
    include('conexion.php');

    // Actualizar los datos en la tabla de mantenimientos
    $sql = "UPDATE mantenimientos SET 
                area = ?, 
                estado = ?, 
                fechaHora = ? 
            WHERE id = ?";

    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);

    // Vincular parámetros y ejecutar la consulta
    mysqli_stmt_bind_param($stmt, "sisi", 
        $area, 
        $estado, 
        $fechaHora, 
        $id
    );

    // Ejecutar la consulta de actualización
    if (mysqli_stmt_execute($stmt)) {
        // Insertar la descripción en la tabla descripciones
        $sql_insertar = "INSERT INTO descripciones (fkMantenimiento, descripcion, fechaHora) VALUES (?, ?, ?)";
        $stmt_insertar = mysqli_prepare($conexion, $sql_insertar);
        
        // Vincular parámetros y ejecutar la consulta
        mysqli_stmt_bind_param($stmt_insertar, "iss", 
            $id, 
            $descripcion2, 
            $fechaHora
        );
        
        // Ejecutar la consulta de inserción
        if (mysqli_stmt_execute($stmt_insertar)) {
            echo "¡Mantenimiento finalizado y descripción añadida correctamente!";
        } else {
            echo "Error al añadir la descripción: " . mysqli_error($conexion);
        }

        // Cerrar la declaración de inserción
        mysqli_stmt_close($stmt_insertar);
    } else {
        // Si ocurrió un error, devolver un mensaje de error
        echo "Error al finalizar el mantenimiento: " . mysqli_error($conexion);
    }
    
    // Cerrar la declaración y la conexión
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
} else {
    // Si la solicitud no es mediante POST, devolver un mensaje de error
    echo "Error: La solicitud debe ser mediante el método POST.";
}
?>
