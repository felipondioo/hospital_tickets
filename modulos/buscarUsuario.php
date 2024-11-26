<?php
include("class.phpmailer.php");
include("class.smtp.php");

// Supongamos que ya tienes los valores de $dni y $gmail
if(isset($_POST['dniVerificar']) && isset($_POST['mailVerificar']) && isset($_POST['estado'])) {
    include('conexion.php');
    $dni = $_POST['dniVerificar'];
    $gmail = $_POST['mailVerificar'];
    $estado = $_POST['estado'];

    // Consulta para buscar el registro con el DNI y Gmail proporcionados
    $consulta = "SELECT * FROM usuarios WHERE dni = ? AND gmail = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, 'ss', $dni, $gmail);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);

        // Verificar el estado
        if ($row['estado'] != 0) {
            mysqli_free_result($resultado);
            mysqli_close($conexion);
            exit;
        } else {
            // Generar token de verificación
            $token = uniqid();

            // Guardar el token de verificación en la base de datos
            $fechaCreacion = date('Y-m-d H:i:s');
            $queryToken = "INSERT INTO tokens (token, dni, fecha_creacion) VALUES (?, ?, ?)";
            $stmtToken = mysqli_prepare($conexion, $queryToken);
            mysqli_stmt_bind_param($stmtToken, "sss", $token, $dni, $fechaCreacion);
            mysqli_stmt_execute($stmtToken);

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
            $mail->FromName = '=?UTF-8?B?' . base64_encode("Verificación de Cuenta") . '?=';
            $mail->Subject = '=?UTF-8?B?' . base64_encode("Verifica tu cuenta") . '?=';
            
            $enlace_confirmacion = "https://www.tecnica1lacosta.edu.ar/hospital/modulos/reactivarCuenta.php?token=" . $token;
            $mensaje = "<p>¡Gracias por trabajar con nosotros!</p>";
            $mensaje .= "<p>Para reactivar tu cuenta, por favor haz clic en el siguiente enlace:</p>";
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
            '>Reactivar cuenta</a></p>"; 
            $mensaje .= "<p>Si no has solicitado esta reactivación, puedes ignorar este mensaje.</p>";
            $mail->Body = $mensaje;
            
            $mail->addAddress($gmail);

            if($mail->Send()) {
                echo 'success';
            } else {
                echo "Error: " . $mail->ErrorInfo;
            }
        }
    } else {
        echo "No se encontraron registros que coincidan con el DNI y Gmail proporcionados.";
    }

    // Liberar resultados y cerrar la conexión
    mysqli_free_result($resultado);
    mysqli_close($conexion);
} else {
    echo "Por favor, proporcione todos los datos necesarios.";
}
?>
