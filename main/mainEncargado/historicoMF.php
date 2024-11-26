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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="../../imagenes/cropped-ICONO-1-32x32.png">
    <title>Mantenimientos >> Histórico</title>
    <style>
        body {
            padding-top: 0;
            padding-bottom: 3em;
            background-color: #f4f4f4 !important;
            position: relative;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #logo-container {
            margin-top: 80px;
            margin-bottom: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container-body {
            background-color: white !important;
            width: 700px;
            padding: 30px;
            border-radius: 10px;
            font-size: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            background-color: #f8f9fa;
            text-align: center;
            padding: 10px 0;
        }

        @media (min-width: 769px) {
            body {
                padding-bottom: 130px;
            }
        }

        @media (max-width: 768px) {
            #logo-container {
                margin-top: 30px;
                margin-bottom: 30px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            body {
                padding-top: 0;
                padding-bottom: 10px;
                position: relative;
                min-height: 100vh;
            }

            .container-body {
                max-width: 90%;
                margin-bottom: 30px;
            }

            #footer {
                visibility: hidden;
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
    </style>
</head>
<body>
    <div class="loader"></div>
    <div id="logo-container" class="text-center">
        <a href="../index.php">
            <img src="../../imagenes/logoMuniAzul.png" alt="logo" style="height: 100px; width: 145px;">
        </a>
    </div>
    <div class="container-body">
        <a class="btn btn-danger" href="mfEncargado.php" role="button" style="text-decoration: none; color: white; font-size: 17px;">
            <img src="../../imagenes/arrow_return_icon_175872.png" style="width: 20px; height: auto;"> Volver
        </a>
        <br>
        <div class="col-12 d-flex justify-content-center mt-1">
            <h2 style="font-weight: 400;">Historial de Mantenimiento</h2>
        </div>
        <label for="exampleFormControlInput1" class="form-label mt-3">Nombre del mantenimiento:</label>
        <?php include('../../modulos/historicoMF.php'); ?>
        <div class="table-responsive">
            <table class="table table-striped-columns table-hover" style="text-align: center;">
                <thead>
                    <tr>
                        <th scope="col">Área</th>
                        <th scope="col">Responsable</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Fecha y hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Iterar sobre los resultados y crear una fila para cada descripción
                        while($descripcion = mysqli_fetch_assoc($resultado_descripciones)) {
                            $fechaHoraOriginal = $descripcion['fechaHora'];

                            // Crear un objeto DateTime a partir de la cadena de fecha
                            $fecha = new DateTime($fechaHoraOriginal);
                            
                            // Formatear la fecha según tus necesidades
                            $fechaFormateada = $fecha->format('d/m/Y H:i:s');                                        echo '<tr>';
                            echo '<td>' . htmlspecialchars($descripcion['area']) . '</td>';
                            echo '<td>' . htmlspecialchars($descripcion['nombreResponsable']) . ' </td>';
                            echo '<td style="text-align: start;"> ' . htmlspecialchars($descripcion['descripcion']) . '</td>';
                            echo '<td>' . htmlspecialchars($fechaFormateada) . '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <footer class="text-white text-center p-3" style="height: auto; background-color: rgb(64, 165, 221);" id="footer">
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