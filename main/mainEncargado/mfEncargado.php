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
        <meta name="viewport" content="width=device-width, initial-scale=0.7, maximum-scale=1, user-scalable=no">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <link rel="icon" href="../../imagenes/cropped-ICONO-1-32x32.png">
        <title>Mantenimientos >> Finalizados</title>
        <style>
            /* Tus estilos CSS aquí */
            body {
                padding-top: 0;
                background-color: #f4f4f4 !important;
                position: relative;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                color: white;
                padding-bottom: 100px;
            }
            .container-body {
                padding: 30px;
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                color: black !important;
            }
            /* table {
                border-collapse: collapse;
                margin-top: 20px;
                width: 100%;
                border-radius: 5px;
                overflow: hidden;
            }
            #tabla {
                overflow: auto;
            } */
            th, td {
                padding: 8px;
                border: 1px solid #ddd;
                text-align: center;
            }
            th {
                /* background-color: #f2f2f2; */
                color: #333;
            }
            td {
                max-width: 125px;
                word-wrap: break-word;
            }
            #logo-container {
                margin-top: 80px;
                margin-bottom: 20px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            footer {
                width: 100%;
                background-color: rgb(64, 165, 221);
                text-align: center;
                padding: 10px 0;
                position: absolute;
                bottom: 0;
            }
            @media (min-width: 426px) and (max-width: 768px) {
                #logo-container {
                    margin-top: 20px;
                    margin-bottom: 20px;
                }
                body {
                    padding-top: 0;
                    background-color: #f4f4f4 !important;
                    position: relative;
                    min-height: 100vh;
                    padding-bottom: 100px;
                }
                #footer {
                    width: 100%;
                }
            }
            @media (min-width: 320px) and (max-width: 425px) {
                #logo-container {
                    margin-top: 20px;
                    margin-bottom: 20px;
                }
                body {
                    padding-top: 0;
                    background-color: #f7fafa !important;
                    position: relative;
                    min-height: 100vh;
                    padding-bottom: 100px;
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
            .descripcion {
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                max-width: 300px; /* Establece la anchura máxima para la descripción */
            }
            .color-square {
                width: 20px;
                height: 20px;
                border-radius: 50%;
                display: inline-block;
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
        <div class="container container-body">
            <a class="btn btn-danger" href="../index.php" role="button" style="text-decoration: none; color:white; font-size:17px; margin-right:auto;">
                <img src="../../imagenes/arrow_return_icon_175872.png" style="width: 20px; height: auto;"> Volver
            </a>
            <br><br>
            <div class="table-responsive">
                <table id="tabla-mantenimientos" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Primer área</th>
                            <th>Prioridad</th>
                            <th>Fecha de Creación</th>
                            <th>Fecha Finalizado</th>
                            <th>Histórico</th>
                        </tr>
                    </thead>
                    <tbody id="tabla">
                    </tbody>
                </table>
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
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
        <script src="../../funciones/manFinalizados.js"></script>
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
