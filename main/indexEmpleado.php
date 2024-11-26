<?php
    session_start();
    if (!isset($_SESSION['dni'])) {
        header('Location: ../login.php');
        exit;
    }
    include('../modulos/ultimaConexion.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../imagenes/cropped-ICONO-1-32x32.png">
        <title>Menu de inicio</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
        <link rel="stylesheet" href="../css/menuEmpleado.css">
        <style>
            .navbar {
                background-color: rgb(64, 165, 221);
            }
            .navbar-brand img {
                height: 100px;
            }
            .navbar-toggler {
                border: none;
                background-color: transparent;
            }
            .navbar-toggler-icon {
                color: white; /* Cambia el color del ícono de hamburguesa */
            }
            .navbar-toggler:focus {
                outline: none;
            }
            .navbar-nav {
                margin-left: auto;
            }
            .navbar-nav .nav-link {
                color: white;
                margin-left: 20px;
            }
            #footer .container {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            #footer p {
                margin-bottom: 10px;
            }

            #footer .btn {
                display: block;
                margin-top: 10px;
                background-color: rgb(111, 166, 221);
                color: white;
                width: 200px;
            }

        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand"><img src="../imagenes/logoMuni.png" alt="logo"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="mainUsuarios/miCuenta.php">Mi cuenta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link2" id="logout-link" href="#">Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
            
        <div id="content" class="container mt-2 text-center">
            <div class="row">
                <div class="col-md-4">
                    <a class="panel panel-default" id="panel" href="mainUsuarios/solicitudUsuario.php">
                        <div class="panel-body">
                            <h3>Solicitudes</h3>
                            <p>Solicitar mantenimientos para su área</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a class="panel panel-default" id="panel2" href="mainUsuarios/mcUsuarios.php">
                        <div class="panel-body">
                            <h3>Mantenimientos del área</h3>
                            <p>Visualizar mantenimientos de su área</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a class="panel panel-default" id="panel3" href="mainUsuarios/mantenimientosN.php">
                        <div class="panel-body">
                            <h3>Mantenimientos asignados</h3>
                            <p>Mantenimientos asignados a USTED en su área</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                function actualizarUltimaConexion() {
                    fetch('../modulos/conexionActual.php')
                        .then(response => response.json())
                        .then(data => {
                            if (!data.success) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Se produjo un error al intentar actualizar la última conexión.'
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Se produjo un error al intentar actualizar la última conexión.'
                            });
                        });
                }

                Promise.all([
                    fetch('../modulos/checkNuevosMantenimientos.php').then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la solicitud de mantenimientos individuales');
                        }
                        return response.json();
                    }),
                    fetch('../modulos/checkNuevosMantenimientosArea.php').then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la solicitud de mantenimientos de área');
                        }
                        return response.json();
                    })
                ])
                .then(data => {
                    const hayNuevosMantenimientos = data[0].hayNuevosMantenimientos;
                    const hayNuevosMantenimientosArea = data[1].hayNuevosMantenimientosArea;

                    let swalOptions = {};

                    if (hayNuevosMantenimientos && hayNuevosMantenimientosArea) {
                        swalOptions = {
                            icon: 'info',
                            title: 'Nuevos Mantenimientos',
                            text: 'Tiene nuevos mantenimientos asignados.',
                            footer: 'Los nuevos mantenimientos han sido asignados a usted específicamente y al área.',
                            didClose: actualizarUltimaConexion // Llama a la función para actualizar la última conexión
                        };
                    } else if (hayNuevosMantenimientos) {
                        swalOptions = {
                            icon: 'info',
                            title: 'Nuevos Mantenimientos',
                            text: 'Tiene nuevos mantenimientos asignados.',
                            footer: 'Los nuevos mantenimientos han sido asignados a usted específicamente.',
                            didClose: actualizarUltimaConexion // Llama a la función para actualizar la última conexión
                        };
                    } else if (hayNuevosMantenimientosArea) {
                        swalOptions = {
                            icon: 'info',
                            title: 'Nuevos Mantenimientos de Área',
                            text: 'Hay nuevos mantenimientos asignados para el área.',
                            footer: 'Los nuevos mantenimientos han sido asignados al área donde usted trabaja.',
                            didClose: actualizarUltimaConexion // Llama a la función para actualizar la última conexión
                        };
                    }

                    if (Object.keys(swalOptions).length > 0) {
                        Swal.fire(swalOptions);
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Se produjo un error al intentar verificar los nuevos mantenimientos.'
                    });
                });
                
                document.getElementById("logout-link").addEventListener("click", function(event) {
                    event.preventDefault(); // Previene el comportamiento por defecto del enlace
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "Tu sesión se cerrará",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, cerrar sesión',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '../modulos/logout.php';
                        }
                    });
                });
            });
        </script>
    </body>
    <<footer class="text-white text-center p-3 d-flex flex-column align-items-center" style="height: auto; background-color: rgb(64, 165, 221);" id="footer">
        <div class="container">
            <p>&copy; <?php echo date("Y / "); ?>Municipalidad de La Costa – Av.Costanera 8001 – Mar del Tuyú Buenos Aires, CP(B7108GPE) – Tel: +54 (02246) 433-000</p>
            <a style="background-color: rgb(111, 166, 221); color: white; width: 200px; display: block; margin-top: 10px;" class="btn" href="nosotros.php">Desarrolladores</a>
        </div>
    </footer>

</html>
