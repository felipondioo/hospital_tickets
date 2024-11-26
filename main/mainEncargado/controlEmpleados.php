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
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="../../css/controlEmpleados.css">
        <link rel="icon" href="../../imagenes/cropped-ICONO-1-32x32.png">
        <title>Control de empleados >> Verificiacion</title>
    </head>
    <body>
        <div class="loader"></div>
        <div id="logo-container" class="text-center">
            <a href="../index.php">
                <img src="../../imagenes/logoMuniAzul.png" alt="logo" style="height: 100px; width: 145px;">
            </a>
        </div>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 mb-4">
                    <div class="container-body">
                        <a class="btn btn-danger mb-3" href="../index.php" role="button" style="color: white;">
                            <img src="../../imagenes/arrow_return_icon_175872.png" style="width: 20px;"> Volver
                        </a>
                        <div class="form-container">
                            <h2 class="titulo mb-3" style="font-weight:400;">Cargar usuarios</h2>
                            <input type="text" id="dni" placeholder="DNI del usuario..." class="form-control mb-3">
                            <input type="text" id="nombre" placeholder="Nombre del usuario..." class="form-control mb-3">
                            <input type="text" id="apellido" placeholder="Apellido del usuario..." class="form-control mb-3">
                            <input type="email" id="email" placeholder="Email del usuario..." class="form-control mb-3">
                            <select id="cargo" class="form-select mb-3">
                                <option selected disabled>Seleccione un cargo</option>
                                <?php include('../../modulos/traerCargos.php'); ?>
                            </select>
                            <select id="area" class="form-select mb-3">
                                <option selected disabled>Seleccione un área</option>
                                <?php include('../../modulos/traerAreas.php'); ?>
                            </select>
                            <button class="btn btn-success" style="width: 25%;" id="cargar">Cargar</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="container-body">
                        <div class="form-container">
                            <h2 class="titulo mb-4" style="font-weight:400;">Enviar mail de verificacion</h2>
                            <input type="text" id="dniVerificar" placeholder="Ingrese el Dni del Usuario..." class="form-control mb-3">
                            <input type="text" id="mailVerificar" placeholder="Ingrese el mail del usuario..." class="form-control mb-3">
                            <button class="btn btn-success" id="enviar" style="width: 25%;">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-body2 scrollable">
                <div id="tabla" class="form-group"></div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
        <script src="../../funciones/controlUsuarios.js"></script>
        
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
    <footer class="text-white text-center p-3">
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Municipalidad de La Costa – Av.Costanera 8001 – Mar del Tuyú Buenos Aires, CP(B7108GPE) – Tel: +54 (02246) 433-000</p>
            <a style="background-color: rgb(111, 166, 221); color: white; width: 200px" class="btn" href="../nosotros.php">Desarrolladores</a>
        </div>
    </footer>
</html>
