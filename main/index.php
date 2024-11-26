<?php
    session_start();
    if (isset($_SESSION['dni'])) {
        $dniUsuario = $_SESSION['dni'];
        $cargoUsuario = $_SESSION['Cargo'];
        
        if ($cargoUsuario != "Administrador") {
            header('Location: ../login.php');
            exit;
        }
    } else {
        header('Location: ../login.php');
        exit;
    }
    include ('../modulos/ultimaConexion.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../imagenes/cropped-ICONO-1-32x32.png">
        <title>Menu de inicio</title>
        <link rel="stylesheet" href="../css/menu.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
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
                color: white;
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
            .notification-bell {
                display: none;
                margin-left: 5px;
                color: red; /* Cambia el color de la campana a rojo */
            }
            .notification-bell2 {
                display: none;
                margin-left: 5px;
                color: red;
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
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="mainEncargado/agregarPrioridad.php">Administrar prioridades</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="mainEncargado/agregarAreas.php">Administrar áreas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="mainEncargado/miCuenta.php">Mi cuenta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="logout-link" href="#">Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid d-flex align-items-center justify-content-center mt-5">    
            <div class="card mt-100" style="max-width: 400px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="../imagenes/userr.png" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8 d-flex align-items-center">
                        <div class="card-body text-center">
                            <a class="btn" href="mainEncargado/controlEmpleados.php" style="background-color: rgb(64, 165, 221); color: white; width: 200px">Administrar usuarios</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-2 text-center">
            <div class="row">
                <div class="col-md-4">
                    <a class="panel panel-default" id="panel" href="mainEncargado/nmEncargado.php">
                        <div class="panel-body">
                            <h3>Nuevos mantenimientos <span class="notification-bell">🔔</span></h3>
                            <p>Asignar nuevas tareas</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a class="panel panel-default" id="panel2" href="mainEncargado/mcEncargado.php">
                        <div class="panel-body">
                            <h3>Mantenimientos en curso <span class="notification-bell2">🔔</span></h3>
                            <p>Controlar las tareas o modificarlas</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a class="panel panel-default" id="panel3" href="mainEncargado/mfEncargado.php">
                        <div class="panel-body">
                            <h3>Mantenimientos finalizados</h3>
                            <p>Visualizar tareas finalizadas</p>
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
                    console.log("Actualizando última conexión...");
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

                // Realizar ambas solicitudes en paralelo y esperar a que ambas finalicen
                Promise.all([
                    fetch('../modulos/checkNuevosMantenimientosAdmin.php').then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la solicitud de nuevos mantenimientos: ' + response.status);
                        }
                        return response.json();
                    }),
                    fetch('../modulos/checkNuevasSolicitudes.php').then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la solicitud de nuevas solicitudes: ' + response.status);
                        }
                        return response.json();
                    })
                ])
                .then(([dataMantenimientos, dataSolicitudes]) => {
                    // Crear una lista de alertas para la cola
                    const alertas = [];

                    // Agregar alerta de mantenimientos si hay nuevos
                    const hayNuevosMantenimientos = dataMantenimientos.hayNuevosMantenimientos;
                    if (hayNuevosMantenimientos) {
                        document.querySelector('.notification-bell2').style.display = 'inline';
                        alertas.push({
                            icon: 'info',
                            title: 'Nuevas devoluciones',
                            text: 'Hay nuevas devoluciones de los usuarios.',
                            footer: 'Las devoluciones están visibles en la tabla correspondiente.',
                            didClose: () => {
                                actualizarUltimaConexion(); // Actualizar después de mostrar el mensaje
                            }
                        });
                    }

                    // Agregar alerta de solicitudes si hay nuevas
                    const hayNuevasSolicitudes = dataSolicitudes.hayNuevasSolicitudes;
                    if (hayNuevasSolicitudes) {
                        document.querySelector('.notification-bell').style.display = 'inline';
                        alertas.push({
                            icon: 'info',
                            title: 'Nuevas solicitudes',
                            text: 'Hay nuevas solicitudes de los usuarios.',
                            footer: 'Las solicitudes están visibles en la tabla correspondiente.',
                            didClose: () => {
                                actualizarUltimaConexion(); // Actualizar después de mostrar el mensaje
                            }
                        });
                    }

                    // Función recursiva para mostrar las alertas una a una
                    function mostrarAlertas(alertas) {
                        if (alertas.length === 0) return; // Si no hay alertas, salir

                        const alerta = alertas.shift(); // Obtener la primera alerta
                        Swal.fire(alerta).then(() => {
                            mostrarAlertas(alertas); // Llamada recursiva para la siguiente alerta
                        });
                    }

                    // Iniciar la secuencia de alertas si hay alguna notificación
                    if (alertas.length > 0) {
                        mostrarAlertas(alertas);
                    }
                })
                .catch(error => {
                    // Mostrar error con detalles específicos
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: `Se produjo un error al intentar verificar las nuevas notificaciones: ${error.message}`
                    });
                });


                document.getElementById("logout-link").addEventListener("click", function(event) {
                    event.preventDefault();
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
    <footer class="text-white text-center p-3" style="height: auto; background-color: rgb(64, 165, 221);" id="footer">
        <div class="container">
            <p>&copy; <?php echo date("Y / "); ?>Municipalidad de La Costa – Av.Costanera 8001 – Mar del Tuyú Buenos Aires, CP(B7108GPE) – Tel: +54 (02246) 433-000</p>
            <a style="background-color: rgb(111, 166, 221); color: white; width: 200px" class="btn" href="nosotros.php">Desarrolladores</a>
        </div>
    </footer>
</html>
