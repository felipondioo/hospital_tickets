<?php
    session_start();
    if (isset($_SESSION['dni'])) {
        $dniUsuario = $_SESSION['dni'];
        $cargoUsuario = $_SESSION['Cargo'];
    } else {
        header('Location: ../../login.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="../imagenes/cropped-ICONO-1-32x32.png">
    <title>Desarrolladores</title>
    <style>
        body {
            background-color: #f4f4f4 !important;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding-bottom: 100px;
        }

        .card {
            width: 300px;
            margin: 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-top: 15px;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            flex: 1;
            align-items: center;
        }

        .card-title {
            margin-top: 10px;
        }

        .card-text {
            flex-grow: 1;
        }

        .btn {
            margin-top: auto;
        }

        #card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        @media (max-width: 576px) {
            #card-container {
                flex-direction: column;
            }
        }
        
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #333333;
            transition: opacity 2s, visibility 2s;
            z-index: 9999;
            pointer-events: none;
        }

        .loader--hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader::after {
            content: "";
            width: 75px;
            height: 75px;
            border: 15px solid #dddddd;
            border-top-color: #009578;
            border-radius: 50%;
            animation: loading 2s ease infinite;
        }

        @keyframes loading {
            from {
                transform: rotate(0turn);
            }
            to {
                transform: rotate(3turn);
            }
        }

        footer {
            width: 100%;
            background-color: rgb(64, 165, 221);
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            color: white;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="loader"></div>

    <div id="logo-container" class="text-center">
        <a href="index.php">
            <img src="../imagenes/logoMuniAzul.png" alt="logo" style="height: 100px; width: 145px;">
        </a>
    </div>
    <a class="btn btn-danger mb-3" role="button" onclick="history.back()">
        <img src="../imagenes/arrow_return_icon_175872.png" alt="Volver" style="width: 20px; height: auto;">
        Volver
    </a>


    <!-- Contenedor de los cards -->
    <div id="card-container">
        <div class="card">
            <img src="../imagenes/userr.png" alt="Foto desarrollador 1">
            <div class="card-body">
                <h5 class="card-title">Santiago Exposito</h5>
                <p class="card-text">Desarrollador back-end y front-end.</p>
                <button class="btn btn-primary" onclick="showInfo('Santiago Exposito', 'Llevó a cabo todas las funcionalidades del sistema participando en las áreas de: back-end, front-end y base de datos. Teniendo mayor influencia en el área de back-end y base de datos.')">Más sobre Santiago</button>
            </div>
        </div>

        <div class="card">
            <img src="../imagenes/userr.png" alt="Foto desarrollador 2">
            <div class="card-body">
                <h5 class="card-title">Joaquín Emiliano Sebastian Lorenzo</h5>
                <p class="card-text">Desarrollador back-end y front-end.</p>
                <button class="btn btn-primary" onclick="showInfo('Joaquín Emiliano Sebastian Lorenzo', 'Llevó a cabo todas las funcionalidades del sistema participando en las áreas de: back-end, front-end y base de datos. Teniendo la misma influencia en todas las áreas mencionadas.')">Más sobre Joaquín</button>
            </div>
        </div>

        <div class="card">
            <img src="../imagenes/userr.png" alt="Foto desarrollador 3">
            <div class="card-body">
                <h5 class="card-title">Felipe Jacob Maldonado</h5>
                <p class="card-text">Analista de Calidad.</p>
                <button class="btn btn-primary" onclick="showInfo('Felipe Jacob Maldonado', 'Llevó a cabo el rol de analista de calidad. Realizando las tareas de documentación, encuestas, requerimientos del sistema, diseño visual del sistema, testeo del sistema, etc.')">Más sobre Felipe</button>
            </div>
        </div>
    </div>

    <footer class="text-white text-center p-3" style="height: auto; background-color: rgb(64, 165, 221);" id="footer">
        <div class="container">
            <p>&copy; <?php echo date("Y / "); ?>Municipalidad de La Costa – Av.Costanera 8001 – Mar del Tuyú Buenos Aires, CP(B7108GPE) – Tel: +54 (02246) 433-000</p>
            <a style="background-color: rgb(111, 166, 221); color: white; width: 200px" class="btn" href="nosotros.php">Desarrolladores</a>
        </div>
    </footer>
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

        function showInfo(title, description) {
            Swal.fire({
                title: title,
                text: description,
                icon: 'info',
                confirmButtonText: 'Cerrar'
            });
        }
    </script>
</body>
</html>
