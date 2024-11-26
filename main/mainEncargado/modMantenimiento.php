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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="../../css/modMantenimiento.css">
        <link rel="icon" href="../../imagenes/cropped-ICONO-1-32x32.png">
        <title>Mantenimientos >> Modificación</title>
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
                <?php
                    include('../../modulos/modManObte.php');
                ?>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">¿Qué necesita mantenimiento?</label>
                    <input type="text" class="form-control" readonly value="<?php echo $row['mantenimiento'];?>">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Descripción</label>
                    <div class="table-responsive">
                        <table class="table table-striped-columns table-hover" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th scope="col">Área</th>
                                    <th scope="col">Responsable</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Fecha y hora de modificación</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // Iterar sobre los resultados y crear una fila para cada descripción
                                    while($descripcion = mysqli_fetch_assoc($respuesta_descripciones)) {
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
                    <br>
                    <textarea class="form-control" rows="2" id="descripcion" placeholder="Describa los avances aquí."></textarea>
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Derivar a</label>
                    <select id="select" class="form-select" aria-label="Default select example">
                        <option selected disabled value="">Seleccione un área</option>
                            <?php
                                include ('../../modulos/traerAreas.php');
                            ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Usuarios</label>
                    <select id="selectUsuario" class="form-select" aria-label="Default select example" disabled>
                        <option selected disabled value="">Seleccione un usuario</option>
                    </select>
                </div>
                <div class="d-flex justify-content-center">
                    <button id="modificar" class="btn btn-success">Modificar</button>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script src="../../funciones/modMantenimiento.js"></script>
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

            $('#select').on('change', function() {
                var areaId = $(this).val();
                if (areaId) {
                    $.ajax({
                        url: '../../modulos/selectUsuariosAreasNuevo.php',
                        type: 'GET',
                        data: { areaId: areaId },
                        dataType: 'json',
                        success: function(data) {
                            $('#selectUsuario').empty();
                            $('#selectUsuario').append('<option selected disabled value="">Seleccione un usuario</option>');
                            $.each(data, function(key, value) {
                                $('#selectUsuario').append('<option value="'+ value.dni +'">'+ value.dni + " - " + value.nombre + " " + value.apellido +'</option>');
                            });
                            $('#selectUsuario').prop('disabled', false);
                        },
                        error: function() {
                            alert('Error al cargar los usuarios.');
                        }
                    });
                } else {
                    $('#selectUsuario').empty();
                    $('#selectUsuario').append('<option selected disabled value="">Seleccione un usuario</option>');
                    $('#selectUsuario').prop('disabled', true);
                }
            });
        </script>

        <footer class="text-white text-center p-3" style="background-color: rgb(64, 165, 221);" id="footer">
            <div class="container">
                <p>&copy; <?php echo date("Y / "); ?>Municipalidad de La Costa – Av.Costanera 8001 – Mar del Tuyú Buenos Aires, CP(B7108GPE) – Tel: +54 (02246) 433-000</p>
                <a style="background-color: rgb(111, 166, 221); color: white; width: 200px" class="btn" href="../nosotros.php">Desarrolladores</a>
            </div>
        </footer>
    </body>
</html>
