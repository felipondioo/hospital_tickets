<?php
    session_start(); // Iniciar sesión si no está iniciada

    include('conexion.php');

    // Verificar si la sesión contiene el DNI del usuario
    if(isset($_SESSION['dni']) && isset($_POST['data_mantenimiento']) && isset($_POST['data_descripcion']) && isset($_POST['data_select']) && isset($_POST['data_selectP'])) {
        // Recibir variables
        $mantenimiento = $_POST['data_mantenimiento'];
        $descripcion = $_POST['data_descripcion'];
        $select = $_POST['data_select'];    
        $selectP = $_POST['data_selectP'];
        $selectUser = $_POST['data_encargadoM'];
        $fechaCreacion = date('Y-m-d H:i:s'); // Formato para la base de datos
        $fechaHoraDescripcion = date('d/m/y H:i:s'); // Formato para la descripción
        $estado = 1;
        $dni_usuario = $_SESSION['dni']; // Obtener el DNI del usuario de la sesión

        $admin = ucfirst($_SESSION['Area']);
        $usuario = ucfirst($_SESSION['Usuario']);
        $apellido = ucfirst($_SESSION['Apellido']);
        $nombreCompleto = $usuario . ' ' . $apellido;

        // Consulta preparada para obtener el nombre del área
        $sql_area = "SELECT nombre FROM areas WHERE idArea = ?";
        $stmt_area = mysqli_prepare($conexion, $sql_area);
        mysqli_stmt_bind_param($stmt_area, "i", $select);
        mysqli_stmt_execute($stmt_area);
        mysqli_stmt_bind_result($stmt_area, $nombre_area);
        mysqli_stmt_fetch($stmt_area);
        mysqli_stmt_close($stmt_area);
        $nombreArea = ucfirst($nombre_area);        

        // Consulta preparada para insertar el mantenimiento en la base de datos
        $sql_insertar = "INSERT INTO `mantenimientos` (mantenimiento, area, primerArea, prioridad, usuarioDesignado, fechaCreacion, fechaHora, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insertar = mysqli_prepare($conexion, $sql_insertar);

        // Vincular parámetros y ejecutar la consulta
        mysqli_stmt_bind_param($stmt_insertar, "ssssissi", 
            $mantenimiento,
            $nombre_area,
            $nombre_area, // Utilizar el nombre del área obtenido de la consulta
            $selectP, // Utilizar directamente el ID de la prioridad
            $selectUser,
            $fechaCreacion,
            $fechaCreacion, // Usar la misma fecha para fechaHora y fechaCreacion
            $estado
        );

        // Ejecutar la consulta de inserción
        mysqli_stmt_execute($stmt_insertar);

        // Verificar si la inserción fue exitosa
        if (mysqli_stmt_affected_rows($stmt_insertar) > 0) {
            echo "Mantenimiento creado correctamente.";
        } else {
            echo "Error al crear el mantenimiento: " . mysqli_error($conexion);
        }

        $sql = "SELECT id, fechaCreacion FROM mantenimientos ORDER BY fechaCreacion DESC";

        // Ejecutar la consulta
        $result = $conexion->query($sql);

        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            // Obtener el primer registro (el más reciente)
            $row = $result->fetch_assoc();
            $idMantenimiento = $row['id'];
            echo "El ID del mantenimiento más reciente es: " . $idMantenimiento;
        } else {
            echo "No se encontraron registros en la tabla mantenimientos.";
        }

        $sqlDescripcion = "INSERT INTO `descripciones` (fkMantenimiento, descripcion, area, nombreResponsable, fechaHora) VALUES (?, ?, ?, ?, ?)";
        $stmtDescripcion = mysqli_prepare($conexion, $sqlDescripcion);

        mysqli_stmt_bind_param($stmtDescripcion, "issss", 
            $idMantenimiento,
            $descripcion,
            $admin,
            $nombreCompleto,
            $fechaCreacion
        );

        mysqli_stmt_execute($stmtDescripcion);

        // Verificar si la inserción fue exitosa
        if (mysqli_stmt_affected_rows($stmtDescripcion) > 0) {
            echo "Mantenimiento creado correctamente.";
        } else {
            echo "Error al crear el mantenimiento: " . mysqli_error($conexion);
        }

        
        // Cerrar la declaración y la conexión
        mysqli_stmt_close($stmt_insertar);
        mysqli_stmt_close($stmtDescripcion);
        mysqli_close($conexion);
    } else {
        echo "Error: Datos incompletos o sesión no iniciada.";
    }
?>
