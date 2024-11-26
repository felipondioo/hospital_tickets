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
    <link rel="icon" href="../../imagenes/cropped-ICONO-1-32x32.png">
    <title>Agregar áreas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/formularios.css">

    <style>
        .input-color {
            height: 38px;
            padding: 0;
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
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="container-body">
                    <div class="form-group form-container">
                        <a class="btn btn-danger mb-2" href="../index.php" role="button" style="color: white; width:100px;">
                            <img src="../../imagenes/arrow_return_icon_175872.png" style="width: 20px; height: auto;"> Volver
                        </a>
                        <br>
                        <center><h2 class="titulo mb-4" style="font-weight: 400;">Crear Prioridades</h2></center>
                        <div class="input-group mb-3">
                            <input type="text" id="prioridad" placeholder="Nombre de la prioridad" class="form-control">
                        </div>
                        <div class="input-group input-color mb-3">
                            <input type="color" id="color" class="form-control">
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-success" id="cargar">Cargar</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-8 mx-auto">
                <div id="contenedorTabla" class="container-body2">
                    <center><h3 class="titulo" style="font-weight: 400;">Prioridades existentes</h3></center>
                    <br>
                    <div class="table-responsive">
                        <table class="table" id="tabla">
                            <!-- Contenido de la tabla de áreas -->
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Color</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí se cargarán dinámicamente las filas -->
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../funciones/crearPrioridades.js"></script>
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
