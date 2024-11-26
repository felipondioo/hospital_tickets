<?php
    session_start();

    if (!isset($_SESSION['dni'])) {
        header('Location: ../../login.php');
        exit;
    }

    include('conexion.php');

    if (isset($_POST['data_mantenimiento']) && isset($_POST['data_descripcion']) && isset($_POST['data_selectP'])) {

        $mantenimiento = $_POST['data_mantenimiento'];
        $descripcion = $_POST['data_descripcion'];
        $selectP = $_POST['data_selectP'];
        $dni_usuario = $_SESSION['dni'];

        // Consulta para obtener los datos del usuario
        $sql_user = "SELECT nombre, apellido, area FROM usuarios WHERE dni = ? AND estado = 1 AND cargo = 2";
        $stmt_user = mysqli_prepare($conexion, $sql_user);

        if ($stmt_user) {
            mysqli_stmt_bind_param($stmt_user, "i", $dni_usuario);
            mysqli_stmt_execute($stmt_user);
            mysqli_stmt_bind_result($stmt_user, $nombre_solic, $apellido_solic, $area_solic);
            mysqli_stmt_fetch($stmt_user);
            mysqli_stmt_close($stmt_user);
        } else {
            echo "Error en la preparación de la consulta de usuario: " . mysqli_error($conexion);
            exit;
        }

        // Consulta para obtener el nombre del área
        $sql_area = "SELECT nombre FROM areas WHERE idArea = ?";
        $stmt_area = mysqli_prepare($conexion, $sql_area);

        if ($stmt_area) {
            mysqli_stmt_bind_param($stmt_area, "i", $area_solic);
            mysqli_stmt_execute($stmt_area);
            mysqli_stmt_bind_result($stmt_area, $nombre_area);
            mysqli_stmt_fetch($stmt_area);
            mysqli_stmt_close($stmt_area);
        } else {
            echo "Error en la preparación de la consulta de área: " . mysqli_error($conexion);
            exit;
        }

        // $sql_area = "SELECT nombre FROM areas WHERE idArea = ?";
        // $stmt_area = mysqli_prepare($conexion, $sql_area);

        // if ($stmt_area) {
        //     mysqli_stmt_bind_param($stmt_area, "i", $area_solic);
        //     mysqli_stmt_execute($stmt_area);
        //     mysqli_stmt_bind_result($stmt_area, $nombre_area);
        //     mysqli_stmt_fetch($stmt_area);
        //     mysqli_stmt_close($stmt_area);
        // } else {
        //     echo "Error en la preparación de la consulta de área: " . mysqli_error($conexion);
        //     exit;
        // }

        // Obtener la fecha actual en el formato adecuado para MySQL
        $fechaEmision = date('Y-m-d H:i:s');

        // Consulta de inserción en la tabla de solicitudes
        $sql_insertar = "INSERT INTO solicitudes (DNI_solicitante, nombre_solic, apellido_solic, area_solic, nombre, descripcion, prioridad, fecha_emision) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insertar = mysqli_prepare($conexion, $sql_insertar);

        if ($stmt_insertar) {
            mysqli_stmt_bind_param($stmt_insertar, "isssssss", 
                $dni_usuario,
                $nombre_solic, 
                $apellido_solic, 
                $nombre_area,
                $mantenimiento,
                $descripcion,
                $selectP,
                $fechaEmision
            );

            // Ejecutar la consulta de inserción
            mysqli_stmt_execute($stmt_insertar);

            // Verificar si la inserción fue exitosa
            if (mysqli_stmt_affected_rows($stmt_insertar) > 0) {
                echo "Solicitud enviada correctamente.";
            } else {
                echo "Error al enviar la solicitud: " . mysqli_error($conexion);
            }

            // Cerrar la declaración de inserción
            mysqli_stmt_close($stmt_insertar);
        } else {
            echo "Error en la preparación de la consulta de inserción: " . mysqli_error($conexion);
        }

        mysqli_close($conexion);
    } else {
        echo "Error: Datos incompletos o sesión no iniciada.";
    }
?>
