$(document).ready(function() {
    cargarTablaMantenimientos();

    function cargarTablaMantenimientos() {
        $.ajax({
            method: 'GET',
            url: '../../modulos/obtenerMantenimientos.php',
            success: function(response) {
                const mantenimientos = JSON.parse(response);
                let tablaHTML = '';
                mantenimientos.forEach(function(mantenimiento) {
                    let colorHTML = `<div class="color-square" style="background-color: ${mantenimiento.colorHEX}; width: 20px;height: 20px;border-radius: 50%;display: inline-block;"></div>`;
                    tablaHTML += `<tr>
                                    <td>${mantenimiento.id}</td>
                                    <td>${mantenimiento.mantenimiento}</td>
                                    <td>${mantenimiento.area}</td>
                                    <td style="text-align: center;">${colorHTML}<br>${mantenimiento.nombrePrioridad}</td>
                                    <td>${mantenimiento.fechaCreacion}</td>
                                    <td>${mantenimiento.fechaHora}</td>
                                    <td>
                                        <a href="modMantenimientoCurso.php?id=${mantenimiento.id}" class="modificar btn btn-success btn-sm">
                                            Intervenir
                                        </a>
                                    </td>
                                    <td>
                                        <button class="eliminar" id="${mantenimiento.id}">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </td>
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
                        "decimal": "",
                        "emptyTable": "No hay datos disponibles en la tabla",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                        "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                        "infoFiltered": "(filtrado de _MAX_ entradas totales)",
                        "lengthMenu": "Mostrar _MENU_ entradas",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "No se encontraron coincidencias",
                        "paginate": {
                            "first": "Primero",
                            "last": "Último",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        },
                        "aria": {
                            "sortAscending": ": activar para ordenar la columna ascendente",
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

        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sí, finalizarlo!'
        }).then((result) => {
            if (result.isConfirmed) {
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
            }
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
