<?php
include("../../modulos/class.phpmailer.php");
include("../../modulos/class.smtp.php");
include('../../modulos/conexion.php');

$dni = $_POST['dniVerificar'];
echo $dni;
// Verificar si el correo existe en la base de datos
$query = "SELECT * FROM usuarios WHERE gmail = ? AND estado ='1'";
$stmt = $conexion->prepare($query);
$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();
    $mail = new PHPMailer();

    try {
        // Configurar la conexión SMTP
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = 'expositos060@gmail.com';
        $mail->Password = 'hkgquaffpschxrky';

        // Configurar el contenido del correo electrónico
        $mail->IsHTML(true);
        $mail->setFrom('expositos060@gmail.com', 'Santi');
        $mail->FromName = "=?UTF-8?B?" . base64_encode("Link para recuperación de contraseña") . "?=";
        $mail->Subject = "=?UTF-8?B?" . base64_encode("Recuperación de Contraseña") . "?=";
        
        // Añadir la cabecera para especificar la codificación de caracteres UTF-8
        $mail->CharSet = 'UTF-8';
        
        // Generar el token único
        $token = uniqid();
        
        // Almacenar el token en la base de datos
        $insertTokenQuery = "INSERT INTO tokens (token, dni) VALUES (?, ?)";
        $insertStmt = $conexion->prepare($insertTokenQuery);
        $insertStmt->bind_param("ss", $token, $row['dni']);
        $insertStmt->execute();

        // Generar el enlace de confirmación con el token
        $enlace_confirmacion = "http://localhost/hospital_tickets/modulos/cambiarContra.php?token=" . $token;
        
        // Construir el cuerpo del mensaje
        $mensaje = "<p>Saludos,</p>";
        $mensaje .= "<p>Para completar el cambio de contraseña, por favor haz clic en el siguiente enlace:</p>";
        $mensaje .= "<p><a href='$enlace_confirmacion'>$enlace_confirmacion</a></p>";
        $mensaje .= "<p>Si no has solicitado este cambio, puedes ignorar este mensaje.</p>";
        $mail->Body = $mensaje;
        
        // Agregar el destinatario
        $mail->addAddress($correo);

        // Enviar el correo electrónico
        if($mail->send()) {
            echo json_encode(['status' => 'ok']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo enviar el correo']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Ocurrió un error al enviar el correo']);
    }
} else {
    echo json_encode(['status' => 'not_found', 'message' => 'Correo no encontrado']);
}

$stmt->close();
$conexion->close();
?>
