<?php
session_start();

// Verificar sesión de usuario
if (isset($_SESSION['dni'])) {
    $dniUsuario = $_SESSION['dni'];
    $cargoUsuario = $_SESSION['Cargo'];
    
    if ($cargoUsuario != "Administrador") {
        header('Location: ../../login.php');
        exit;
    }
} else {
    header('Location: ../../login.php');
    exit;
}

// Verificar si se proporcionó un ID válido en la URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de prioridad no válido.";
    exit;
}

$idPrioridad = $_GET['id'];

// Incluir archivo de obtención de prioridad
include('../../modulos/obtenerPrioridad.php');

// Ahora vamos a pasar $idPrioridad a JavaScript
echo '<script>';
echo 'var idPrioridad = ' . json_encode($idPrioridad) . ';'; // Pasamos $idPrioridad a JavaScript
echo '</script>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../../css/modMantenimiento.css">
    <link rel="icon" href="../../imagenes/cropped-ICONO-1-32x32.png">
    <title>Mantenimientos >> Modificación</title>
    <style>
        .input-color {
            height: 38px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="loader"></div>
    <div id="logo-container" class="text-center">
        <a href="../index.php">
            <img src="../../imagenes/logoMuniAzul.png" alt="logo" style="height: 100px; width: 145px;">
        </a>
    </div>
    <div class="container-wrapper">
        <div class="container-body">
            <a class="btn btn-danger mb-3" href="javascript:history.back()" role="button" style="text-decoration: none; color:white; font-size:17px; margin-right:auto;">
                <img src="../../imagenes/arrow_return_icon_175872.png" style="width: 20px; height: auto;"> Volver
            </a>

            <div class="mb-3">
                <label for="nombrePrioridad" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombrePrioridad" value="<?php echo $row['nombrePrioridad']; ?>">
            </div>
            <div class="mb-3">
                <label for="color" class="form-label">Color:</label>
                <input type="color" id="color" class="form-control input-color" value="<?php echo $row['colorHEX']; ?>">
            </div>
            <div class="d-flex justify-content-center">
                <button id="modificar" class="btn btn-success" data-id="<?php echo $idPrioridad; ?>">Modificar</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="../../funciones/modPrioridad.js"></script>
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
    <footer class="text-white text-center p-3" style="height: 60px; background-color: rgb(64, 165, 221);" id="footer">
        <div class="container">
            <p>&copy; <?php echo date("Y / "); ?>Municipalidad de La Costa – Av.Costanera 8001 – Mar del Tuyú Buenos Aires, CP(B7108GPE) – Tel: +54 (02246) 433-000</p>
            <a style="background-color: rgb(111, 166, 221); color: white; width: 200px" class="btn" href="../nosotros.php">Desarrolladores</a>
        </div>
    </footer>
</body>
</html>
