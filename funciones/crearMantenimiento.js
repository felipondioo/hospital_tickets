$(document).ready(function() {
    let idSolic = null;  // Variable global para almacenar el id de la solicitud

    const botonesAceptar = document.querySelectorAll('.card-right #aceptar');

    botonesAceptar.forEach(function(boton) {
        boton.addEventListener('click', function(event) {
            const tarjeta = event.target.closest('.card-horizontal');
            
            if (tarjeta) {
                idSolic = tarjeta.querySelector('.card-title').id;
                const titulo = tarjeta.querySelector('.card-title').textContent;
                const descripcion = tarjeta.querySelector('#descripcionTarjeta').textContent.trim();
                const simbolo = ":";
                let partes = descripcion.split(simbolo);
                let descDeseada = partes.length > 1 ? partes[1].trim() : "";

                // Mostrar SweetAlert2 para confirmar la acción
                Swal.fire({
                    title: `¿Estás seguro de aceptar la solicitud para '${titulo}'?`,
                    icon: 'question',
                    showCancelButton: true, 
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        handleFormActions(tarjeta);
                        // alert(idSolic);  // Alerta para mostrar el id de la solicitud
                    }
                });
            }
        });
    });

    const botonesDenegar = document.querySelectorAll('.card-right #rechazar');

    botonesDenegar.forEach(function(boton) {
        boton.addEventListener('click', function(event) {
            const tarjeta = event.target.closest('.card-horizontal');
            
            if (tarjeta) {
                const idSolic = tarjeta.querySelector('.card-title').id;
                const titulo = tarjeta.querySelector('.card-title').textContent;

                // Mostrar SweetAlert2 para confirmar la acción
                Swal.fire({
                    title: `¿Denegar la solicitud para '${titulo}'?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Denegar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let respuestaNo = "Denegar";
                        const data = {
                            idSolicitud: idSolic,
                            respuesta: respuestaNo,
                        };

                        // Enviar solicitud mediante AJAX
                        $.ajax({
                            type: "POST",
                            url: `../../modulos/actualizarEstadoSolicitud.php`,
                            data: data,
                            success: function(response) {
                                // Mostrar mensaje de éxito con SweetAlert2
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: '¡Solicitud denegada correctamente!',
                                }).then(() => {
                                    // Recargar la página después de denegar la solicitud
                                    location.reload();
                                });
                            },
                            error: function(xhr, status, error) {
                                // Mostrar mensaje de error con SweetAlert2
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Ocurrió un error al denegar la solicitud.',
                                });
                            }
                        });
                    }
                });
            }
        });
    });

    // Función para deshabilitar campos y actualizar select
    function handleFormActions(tarjeta) {
        const mantenimiento = document.getElementById('mantenimiento');
        if (mantenimiento) {
            mantenimiento.value = tarjeta.querySelector('.card-title').textContent;
            mantenimiento.disabled = true;
        }

        const descripcion = document.getElementById('descripcion');
        if (descripcion) {
            descripcion.value = tarjeta.querySelector('#descripcionTarjeta').textContent.trim();
            descripcion.disabled = true;
        }

        const areaTarjeta = tarjeta.querySelector('#areaTarjeta').textContent.trim();
        const simbolo = ":";
        let partesArea = areaTarjeta.split(simbolo);
        let areaDeseada = partesArea.length > 1 ? partesArea[1].trim() : "";

        let select = document.getElementById("select");
        if (select) {
            let opcionEncontrada = false;
            for (let i = 0; i < select.options.length; i++) {
                let opcion = select.options[i];
                if (opcion.textContent.trim().toLowerCase() === areaDeseada.toLowerCase()) {
                    opcion.selected = true;
                    opcionEncontrada = true;
                    break;
                }
            }
            if (!opcionEncontrada) {
                // console.warn("No se encontró ninguna opción coincidente en el select.");
            }
        } else {
            // console.error("No se encontró el elemento select con id 'select'");
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// crear mantenimiento///////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    $('#mantenimiento, #descripcion, #select, #selectP, #selectUsuario').on('keydown', function(event) {
        if (event.which === 13) {
            event.preventDefault();
            $('#crear').click();
        }
    });

    $('#crear').click(function(){
        // Obtener valores de los campos
        let mantenimiento = $('#mantenimiento').val();
        let descripcion = $('#descripcion').val();
        let select = $('#select').val();
        let selectP = $('#selectP').val();
        let selectUser = $('#selectUsuario').val();

        // Validar que todos los campos estén completos
        if (mantenimiento === '' || descripcion === '' || select === null || selectP == null || selectUser === null) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor, complete todos los campos.'
            });
            return;
        }
        
        // Enviar datos mediante AJAX
        $.post('../../modulos/crearMantenimiento.php', {
            data_mantenimiento: mantenimiento,
            data_descripcion: descripcion,
            data_select: select,
            data_selectP: selectP,
            data_encargadoM: selectUser,
        })
        .done(function(response) {
            console.log(response); // Revisar la respuesta en la consola
            if (response === "1") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error, inténtelo nuevamente.'
                });
            } else {
                if (idSolic) {
                    let respuestaSi = "Aceptar";
                    const data = {
                        idSolicitud: idSolic,
                        respuesta: respuestaSi,
                    };
                    // console.log(data);
                    $.ajax({
                        type: "POST",
                        url: `../../modulos/actualizarEstadoSolicitud.php`,
                        data: data,
                        success: function(response) {
                        },
                        error: function(xhr, status, error) {
                            // Mostrar mensaje de error con SweetAlert2
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Ocurrió un error al aceptar la solicitud.',
                            });
                        }
                    });
                }
            
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: '¡Datos insertados correctamente!'
                }).then(function() {
                    // Limpiar campos del formulario y recargar la página
                    $('#mantenimiento, #descripcion').val('');
                    $('#select, #selectP').val('');
                    location.reload();
                });
            }
        })
        .fail(function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error, inténtelo nuevamente.'
            });
        });
    });
});
