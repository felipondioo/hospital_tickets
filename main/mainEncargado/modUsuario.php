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


    if (isset($_GET['dni'])) {
        $dni = $_GET['dni'];
        include('../../modulos/conexion.php');
        $sql = "SELECT * FROM usuarios WHERE dni = '$dni'";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
        } else {
            echo "Usuario no encontrado";
            exit;
        }
    } else {
        echo "Parámetro DNI no recibido";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <title>Modificar Usuario</title>
        <style>
            body {
                padding-top: 0;
                background-color: #f4f4f4 !important;
                position: relative;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                color: black; /* Cambiado a negro para mejorar visibilidad */
                padding-bottom: 20px;
            }

            .container-body {
                background-color: white !important;
                width: 700px;
                padding: 30px;
                border-radius: 10px;
                font-size: 20px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            #logo-container {
                margin-top: 40px;
                margin-bottom: 30px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            label {
                color: #333;
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
        <br>
        <div class="container-body"> 
            <a class="btn btn-danger" href="controlEmpleados.php" role="button" style="text-decoration: none; color:white; font-size:17px; margin-bottom:10px;">
                <img src="../../imagenes/arrow_return_icon_175872.png" style="width: 20px; height: auto;"> Volver
            </a>
            <br>
            <form method="POST" id="formulario-modificar">
                <div class="mb-3 mt-3">
                    <label for="dni" class="form-label">DNI:</label>
                    <input type="text" name="dni" id="dni" class="form-control" value="<?php echo $row["dni"]; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $row['nombre']; ?>">
                </div>
                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido:</label>
                    <input type="text" name="apellido" id="apellido" class="form-control" value="<?php echo $row['apellido']; ?>">
                </div>
                <div class="mb-3">
                    <label for="gmail" class="form-label">Gmail:</label>
                    <input type="text" name="gmail" id="gmail" class="form-control" value="<?php echo $row['gmail']; ?>">
                </div>
                <div class="mb-3">
                    <label for="cargo" class="form-label">Cargo:</label>
                    <select name="cargo" id="cargo" class="form-select">
                        <?php
                        // Mostrar opciones de cargo
                        $cargoActualMostrado = false;
                        if ($row['cargo'] === '1') {
                            echo "<option value='1' selected>Administrador</option>";
                            $cargoActualMostrado = true;
                        } else if ($row['cargo'] === '2') {
                            echo "<option value='2' selected>Usuario</option>";
                            $cargoActualMostrado = true;
                        }
                        include("../../modulos/traerCargos.php");
                        if ($resultadoCargos->num_rows > 0) {
                            while ($cargo =  mysqli_fetch_assoc($resultadoCargos)) {
                                $selected = ($row['cargo'] == $cargo['nombreCargo']) ? "selected" : "";
                                echo "<option value='" . $cargo['idCargo'] . "' $selected>" . $cargo['nombreCargo'] . "</option>";
                            }
                        } else {
                            echo "<option disabled>No hay más cargos disponibles</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="area" class="form-label">Área:</label>
                    <select name="area" id="area" class="form-select">
                        <?php
                        // Mostrar opciones de área
                        echo $row['area'];
                        include("../../modulos/traerAreas.php");
                        if ($resultadoAreas->num_rows > 0) {
                            while ($area =  mysqli_fetch_assoc($resultadoAreas)) {
                                $selected = ($row['area'] == $area['nombre']) ? "selected" : "";
                                echo "<option value='" . $area['nombre'] . "' $selected>" . $area['nombre'] . "</option>";
                            }
                        } else {
                            echo "<option disabled>No hay áreas disponibles</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3 d-flex justify-content-center">
                    <button type="button" class="btn btn-warning" onclick="confirmarModificacion()">Guardar Modificación</button>
                </div>
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script src="../../funciones/guardarModificaciones.js"></script>
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
