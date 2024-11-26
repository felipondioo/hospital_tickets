$(document).ready(function() {
    cargarTablaMantenimientos();

    function cargarTablaMantenimientos() {
        $.ajax({
            method: 'POST',
            url: '../../modulos/solicitudUsuarioHistorial.php',
            success: function(response) {
                const solicitudes = JSON.parse(response);
                let tablaHTML = '';
                solicitudes.forEach(function(solicitud) {
                    tablaHTML += `<tr>
                        <td>${solicitud.id}</td>
                        <td>${solicitud.nombre}</td>
                        <td>${solicitud.descripcion}</td>
                        <td>${solicitud.area}</td>
                        <td>${solicitud.fechaCreacion}</td>
                        <td>${solicitud.estado}</td>
                    </tr>`;
                });

                $('#tabla').html(tablaHTML);

                if ($.fn.DataTable.isDataTable('#tabla-mantenimientos')) {
                    $('#tabla-mantenimientos').DataTable().clear().destroy();
                }
                // Inicializar DataTables
                $('#tabla-mantenimientos').DataTable({
                    ordering: false,
                    language: {
                        "decimal":        "",
                        "emptyTable":     "No hay datos disponibles en la tabla",
                        "info":           "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                        "infoEmpty":      "Mostrando 0 a 0 de 0 entradas",
                        "infoFiltered":   "(filtrado de _MAX_ entradas totales)",
                        "infoPostFix":    "",
                        "thousands":      ",",
                        "lengthMenu":     "Mostrar _MENU_ entradas",
                        "loadingRecords": "Cargando...",
                        "processing":     "Procesando...",
                        "search":         "Buscar:",
                        "zeroRecords":    "No se encontraron coincidencias",
                        "paginate": {
                            "first":      "Primero",
                            "last":       "Último",
                            "next":       "Siguiente",
                            "previous":   "Anterior"
                        },
                        "aria": {
                            "sortAscending":  ": activar para ordenar la columna ascendente",
                            "sortDescending": ": activar para ordenar la columna descendente"
                        }
                    }
                });
            },
            error: function() {
                mostrarAlertaError("Ha ocurrido un error al obtener los mantenimientos");
            }
        });
    }

    $(document).on('click', 'button.eliminar', function() {
        var id = $(this).attr('id');
        var estado = 0;

        $.post('../../modulos/fMantenimiento.php', {
            data_id: id,
            data_estado: estado
        })
        .done(function(response) {
            if (response === "1") {
                mostrarAlertaError("El mantenimiento no pudo ser finalizado.");
            } else {
                cargarTablaMantenimientos();
                mostrarAlertaExito("Mantenimiento finalizado correctamente!");
            }
        })
        .fail(function() {
            mostrarAlertaError("Ocurrió un error al intentar finalizar el mantenimiento.");
        });
    });

    function mostrarAlertaError(mensaje) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: mensaje,
        });
    }

    function mostrarAlertaExito(mensaje) {
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: mensaje,
        }).then(function() {
            location.reload(); // Recargar la página después de mostrar el mensaje de éxito
        });
    }
});