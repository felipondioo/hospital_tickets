<?php
    session_start();
    // Verificar si hay una sesión activa
    if (isset($_SESSION['dni'])) {
        $dniUsuario = $_SESSION['dni'];
    } else {
       // Si no hay una sesión activa, redirigir al usuario a la página de inicio de sesión
        header('Location: ../../login.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=0.7, maximum-scale=1, user-scalable=no">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="../../css/historialSolicitudes.css">
        <link rel="icon" href="../../imagenes/cropped-ICONO-1-32x32.png">
        <title>Historial de Solicitudes</title>
    </head>
    <body>
        <div class="loader"></div>
        <div id="logo-container" class="text-center">
            <a href="../indexEmpleado.php">
                <img src="../../imagenes/logoMuniAzul.png" alt="logo" style="height: 100px; width: 145px;">
            </a>
        </div>
        <br>
        <div class="container container-body">
            <a class="btn btn-danger" href="solicitudUsuario.php" role="button" style="text-decoration: none; color:white; font-size:17px; margin-right:auto;">
                <img src="../../imagenes/arrow_return_icon_175872.png" style="width: 20px; height: auto;"> Volver
            </a>
            <br><br>
            <div class="table-responsive">
                <table id="tabla-mantenimientos" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>N° de lista</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Área</th>
                            <th>Fecha y Hora de emisión</th>
                            <th>Estado Final</th>
                        </tr>
                    </thead>
                    <tbody id="tabla">
                    </tbody>
                </table>
            </div>
        </div>

        <footer class="text-white text-center p-3" style="background-color: rgb(64, 165, 221);">
            <div class="container">
                <p>&copy; <?php echo date("Y / "); ?>Municipalidad de La Costa – Av.Costanera 8001 – Mar del Tuyú Buenos Aires, CP(B7108GPE) – Tel: +54 (02246) 433-000</p>
                <a style="background-color: rgb(111, 166, 221); color: white; width: 200px" class="btn" href="../nosotros.php">Desarrolladores</a>
            </div>
        </footer>

        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
        <script src="../../funcionesU/historialSolicUser.js"></script>
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
        </script>
    </body>
</html>
