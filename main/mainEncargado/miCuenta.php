<?php
    session_start();
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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="icon" href="../../imagenes/cropped-ICONO-1-32x32.png">
        <title>Mi Cuenta</title>
        <style>
            body {
                padding-top: 0;
                background-color: #f4f4f4 !important;
                position: relative;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                color: black;
                padding-bottom: 100px;
            }

            .card {
                width: 500px;
            }

            #logo-container {
                margin-top: 100px;
                margin-bottom: 40px;
                display: flex;
                justify-content: center;
                align-items: center;
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

            /* Media queries */
            @media (max-width: 768px) {
                .card {
                    width: 90%; /* Reducir el ancho del card en pantallas más pequeñas */
                }
            }

            @media (max-width: 425px) {
                #logo-container {
                    margin-top: 40px; /* Ajustar el margen superior */
                }
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
        <br>
        <div class="card" style="background-color: #fff; border-radius: 15px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border: none; padding: 25px;">
            <div class="card-body text-center">
                <img src="../../imagenes/userr.png" alt="logo" style="height: 120px;">
                <br>
                <h5 class="card-title" style="margin-top:10px; text-align: center;"><?php echo $_SESSION['Usuario'] . " " . $_SESSION['Apellido'];?></h5>
                <p  style="text-align: center;" class="card-text"><?php echo $_SESSION['Cargo'];?></p>
                <ul class="list-group">
                    <li class="list-group-item">DNI: <?php echo $_SESSION['dni'];?></li>
                    <li class="list-group-item">Correo: <?php echo $_SESSION['Correo'];?></li>
                    <li class="list-group-item">Área: <?php echo $_SESSION['Area'];?></li>
                </ul>
                <br>
                <a class="btn btn-danger" href="../index.php" role="button"
                    style="text-decoration: none; color:white; font-size:15px; margin-right:auto;">
                    <img src="../../imagenes/arrow_return_icon_175872.png" style="width: 20px; height: auto;"> Volver
                </a>
            </div>
        </div>


        
        <footer class="text-white text-center p-3" style="background-color: rgb(64, 165, 221);" id="footer">
            <div class="container">
                <p>&copy; <?php echo date("Y / "); ?>Municipalidad de La Costa – Av.Costanera 8001 – Mar del Tuyú Buenos Aires, CP(B7108GPE) – Tel: +54 (02246) 433-000</p>
                <a style="background-color: rgb(111, 166, 221); color: white; width: 200px" class="btn" href="../nosotros.php">Desarrolladores</a>
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
        </script>
    </body>
</html>
