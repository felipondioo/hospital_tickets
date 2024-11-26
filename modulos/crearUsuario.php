<?php
include('conexion.php');
include("class.phpmailer.php");
include("class.smtp.php");

// Establecer la zona horaria a Buenos Aires, Argentina
date_default_timezone_set('America/Argentina/Buenos_Aires');

if(isset($_POST['dni'], $_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['area'], $_POST['cargo'])){
    // Recibir datos del formulario
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $area = $_POST['area'];
    $cargo = $_POST['cargo'];
    $fechaCreacion = date('Y-m-d H:i:s');
    
    $estado = 0; // Estado inicial desactivado
    
    // Verificar si el usuario ya existe por DNI o email
    $queryVerificar = "SELECT dni FROM usuarios WHERE dni = ? OR gmail = ?";
    $stmtVerificar = mysqli_prepare($conexion, $queryVerificar);
    mysqli_stmt_bind_param($stmtVerificar, "is", $dni, $email);
    mysqli_stmt_execute($stmtVerificar);
    mysqli_stmt_store_result($stmtVerificar);
    
    if(mysqli_stmt_num_rows($stmtVerificar) > 0){
        echo 'duplicate_dni_or_email';
        exit;
    }

    // Insertar el nuevo usuario utilizando una consulta preparada
    $query = "INSERT INTO usuarios (dni, nombre, apellido, gmail, area, cargo, estado) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "isssssb", $dni, $nombre, $apellido, $email, $area, $cargo, $estado);

    if(mysqli_stmt_execute($stmt)){
        // Generar el token de verificación
        $token = uniqid();

        // Guardar el token de verificación en la base de datos
        $queryToken = "INSERT INTO tokens (token, dni, fecha_creacion) VALUES (?, ?, ?)";
        $stmtToken = mysqli_prepare($conexion, $queryToken);
        mysqli_stmt_bind_param($stmtToken, "sss", $token, $dni, $fechaCreacion);
        mysqli_stmt_execute($stmtToken);

        // Configurar y enviar el correo electrónico de verificación
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug  = 0;
        $mail->Host       = 'smtp.gmail.com';
        $mail->Port       = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'expositos060@gmail.com';
        $mail->Password   = 'hkgquaffpschxrky';
        
        $mail->IsHTML(true);
        $mail->setFrom('expositos060@gmail.com', 'Santi');
        $mail->FromName = '=?UTF-8?B?' . base64_encode("Activación de Cuenta") . '?=';
        $mail->Subject = '=?UTF-8?B?' . base64_encode("Verifica tu cuenta") . '?=';
        
        $enlace_confirmacion = "https://www.tecnica1lacosta.edu.ar/hospital/modulos/verificarCuenta.php?token=" . $token;
        $mensaje = "<p>¡Gracias por registrarte en nuestro sitio!</p>";
        $mensaje .= "<p>Para activar tu cuenta, por favor haz clic en el siguiente enlace:</p>";
        $mensaje .= "<p>Para asignar tu contraseña, por favor haz clic en el siguiente enlace:</p>";
        $mensaje .= "<p><a href='$enlace_confirmacion' style='
        display: inline-block;
        padding: 10px 20px;
        background-color: #5bc0de;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        font-family: Arial, sans-serif;
        font-size: 16px;
        font-weight: bold;
        '>Activar cuenta</a></p>";        
        $mensaje .= "<p>Si no has solicitado este registro, puedes ignorar este mensaje.</p>";
        $mail->Body = $mensaje;
        
        $mail->addAddress($email);

        if($mail->Send()) {
            echo 'success';
        } else {
            echo "Error: " . $mail->ErrorInfo;
        }
    } else {
        echo 'error';
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
}
?>