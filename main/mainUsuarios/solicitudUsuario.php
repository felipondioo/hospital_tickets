<?php
    session_start();
    if (isset($_SESSION['dni'])) {
        $dniUsuario = $_SESSION['dni'];
    } else {
        header('Location: ../../login.php');
        exit;
    }

    $cooldownTime = 60; // 12 horas en segundos
    $canCreate = true;
    $remainingTime = 0;

    include '../../modulos/conexion.php';

    // Verifica la última fecha de emisión de la solicitud del usuario
    $sql = "SELECT UNIX_TIMESTAMP(fecha_emision) AS fecha_emision FROM solicitudes WHERE DNI_solicitante = '$dniUsuario' ORDER BY fecha_emision DESC LIMIT 1";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastRequestTime = $row['fecha_emision'];
        $elapsedTime = time() - $lastRequestTime;
        if ($elapsedTime < $cooldownTime) {
            $canCreate = false;
            $remainingTime = $cooldownTime - $elapsedTime;
        }
    }
    $conexion->close();
    include '../../modulos/ultimaConexion.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="../../css/solicitudUsuario.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="icon" href="../../imagenes/cropped-ICONO-1-32x32.png">
        <title>Mis solicitudes</title>
    </head>
    <body>
        <div class="loader"></div>
        <div id="logo-container" class="text-center">
            <a href="../indexEmpleado.php">
                <img src="../../imagenes/logoMuniAzul.png" alt="logo" style="height: 100px; width: 145px;">
            </a>
        </div>
        <div class="container-wrapper">
            <div class="container-body">
                <a class="btn btn-danger" href="../indexEmpleado.php" role="button" style="text-decoration: none; color:white; font-size:17px; width: 100px;">
                    <img src="../../imagenes/arrow_return_icon_175872.png" style="width: 20px; height: auto;"> Volver
                </a>
                <div class="mt-3">
                    <label class="form-label">Nombre de la solicitud</label>
                    <input type="text" class="form-control" id="mantenimiento" placeholder="Escribe el nombre...">
                </div>
                <div class="mt-3">
                    <label class="form-label">Descripción de la solicitud</label>
                    <textarea class="form-control" id="descripcion" rows="5" placeholder="Descibre que mantenimiento necesita..."></textarea>
                </div>
                <div class="mt-3">
                    <label class="form-label">Seleccione el nivel de prioridad de la solicitud</label>
                    <select id="selectP" class="form-select" aria-label="Default select example">
                        <option selected disabled value="">Seleccione la prioridad</option>
                        <?php include ('../../modulos/traerPrioridades.php'); ?>
                    </select>
                </div>
                <br>
                <div class="d-flex justify-content-center">
                    <button id="crear" class="btn btn-success" <?= !$canCreate ? 'disabled' : '' ?>>Enviar</button>
                </div>
            </div>
                <div class="container-card">
                    <div class="header-container">
                        <h3 style="font-weight: 400;">Mis solicitudes</h3>
                        <a class="btn" id="hist" href="historialSolic.php" role="button" style="padding: 5px; text-decoration: none; color:white; font-size:15px; background-color:rgb(64, 165, 221);">
                            Historial (Solicitudes)
                        </a>
                    </div>
                <?php include('../../modulos/obtenerSolicitudUsuario.php')?>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script>
            window.addEventListener("load", () => {
                const loader = document.querySelector(".loader");

                loader.classList.add("loader--hidden");

                loader.addEventListener("transitionend", (event) => {
                    if (event.propertyName === 'opacity') {
                        event.target.remove();
                    }
                });
            });
            $(document).ready(function() {
                let remainingTime = <?= $remainingTime ?>;
                if (remainingTime > 0) {
                    setTimeout(function() {
                        $('#crear').prop('disabled', false);
                        $('#crear').text('Enviar'); // Restaurar texto original
                    }, remainingTime * 1000);

                    // Mostrar cuenta regresiva en el botón
                    let countdownInterval = setInterval(function() {
                        let hours = Math.floor(remainingTime / 3600);
                        let minutes = Math.floor((remainingTime % 3600) / 60);
                        let seconds = remainingTime % 60;
                        $('#crear').text(`Tiempo restante para solicitar otro mantenimiento: ${formatTime(hours)}:${formatTime(minutes)}:${formatTime(seconds)}`);
                        remainingTime--;

                        if (remainingTime < 0) {
                            clearInterval(countdownInterval);
                            location.reload();
                            return false;
                        }
                    }, 1000);
                }

                function formatTime(time) {
                    return (time < 10 ? '0' : '') + time;
                }
            });
        </script>
        <script src="../../funcionesU/solicitudes.js"></script>
        <script src="../../funcionesU/solicitudesRespuestaQuery.js"></script>
    </body>
    <footer class="text-white text-center p-3" style="height: auto; background-color: rgb(64, 165, 221);" id="footer">
        <div class="container">
            <p>&copy; <?php echo date("Y / "); ?>Municipalidad de La Costa – Av.Costanera 8001 – Mar del Tuyú Buenos Aires, CP(B7108GPE) – Tel: +54 (02246) 433-000</p>
            <a style="background-color: rgb(111, 166, 221); color: white; width: 200px" class="btn" href="../nosotros.php">Desarrolladores</a>
        </div>
    </footer>
</html>
