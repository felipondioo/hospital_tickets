document.addEventListener("DOMContentLoaded", function() {
    const botonEliminar = document.querySelectorAll('.card-right #eliminar');

    botonEliminar.forEach(function(boton) {
        boton.addEventListener('click', function(event) {
            const tarjeta = event.target.closest('.card-horizontal');
            const idSolic = tarjeta.querySelector('.card-title').id;
            const titulo = tarjeta.querySelector('.card-title').textContent;

            Swal.fire({
                title: `¿Eliminar la solicitud '${titulo}'?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    let respuestaEliminar = "Eliminar";
                    const data = {
                        idSolicitud: idSolic,
                        respuesta: respuestaEliminar,
                    };

                    $.ajax({
                        type: "POST",
                        url: `../../modulos/actualizarEstadoSolicitudRespuesta.php`,
                        data: data,
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Eliminado',
                                text: response,
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al eliminar la solicitud. Inténtelo nuevamente.',
                            });
                        }
                    });
                }
            });
        });
    });

    const botonCancelar = document.querySelectorAll('.card-right #cancelar');

    botonCancelar.forEach(function(boton) {
        boton.addEventListener('click', function(event) {
            const tarjeta = event.target.closest('.card-horizontal');
            const idSolic = tarjeta.querySelector('.card-title').id;
            const titulo = tarjeta.querySelector('.card-title').textContent;

            Swal.fire({
                title: `¿Cancelar la solicitud para '${titulo}'?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Cancelar solicitud',
                cancelButtonText: 'No cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    let respuestaCancelar = "Cancelar";
                    const data = {
                        idSolicitud: idSolic,
                        respuesta: respuestaCancelar,
                    };

                    $.ajax({
                        type: "POST",
                        url: `../../modulos/actualizarEstadoSolicitudRespuesta.php`,
                        data: data,
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Cancelado',
                                text: response,
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al cancelar la solicitud. Inténtelo nuevamente.',
                            });
                        }
                    });
                }
            });
        });
    });

    const botonArchivar = document.querySelectorAll('.card-right #archivar');

    botonArchivar.forEach(function(boton) {
        boton.addEventListener('click', function(event) {
            const tarjeta = event.target.closest('.card-horizontal');
            const idSolic = tarjeta.querySelector('.card-title').id;
            const titulo = tarjeta.querySelector('.card-title').textContent;

            Swal.fire({
                title: `¿Archivar '${titulo}'?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Archivar',
                cancelButtonText: 'No archivar'
            }).then((result) => {
                if (result.isConfirmed) {
                    let respuestaArchivar = "Archivar";
                    const data = {
                        idSolicitud: idSolic,
                        respuesta: respuestaArchivar,
                    };

                    $.ajax({
                        type: "POST",
                        url: `../../modulos/actualizarEstadoSolicitudRespuesta.php`,
                        data: data,
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Archivado',
                                text: response,
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al archivar la solicitud. Inténtelo nuevamente.',
                            });
                        }
                    });
                }
            });
        });
    });
});
