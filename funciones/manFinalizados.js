$(document).ready(function() {
    cargarTablaMantenimientos();

    function cargarTablaMantenimientos() {
        $.ajax({
            method: 'GET',
            url: '../../modulos/obtenerMantenimientosFinalizados.php',
            success: function(response) {
                const mantenimientos = JSON.parse(response);
                let tablaHTML = '';
                mantenimientos.forEach(function(mantenimiento) {
                    let colorHTML = `<div class="color-square" style="background-color: ${mantenimiento.colorHEX};"></div>`;
                    tablaHTML += `<tr>
                                    <td>${mantenimiento.id}</td>
                                    <td>${mantenimiento.mantenimiento}</td>
                                    <td>${mantenimiento.area}</td>
                                    <td style="text-align: center;">${colorHTML}<br>${mantenimiento.nombrePrioridad}</td>
                                    <td>${mantenimiento.fechaCreacion}</td>
                                    <td>${mantenimiento.fechaHora}</td>
                                    <td>
                                        <a href="historicoMF.php?id=${mantenimiento.id}" class="btn btn-warning" style="color: black;">
                                            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-clock'>
                                                <circle cx='12' cy='12' r='10'></circle>
                                                <polyline points='12 6 12 12 16 14'></polyline>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>`;
                });

                $('#tabla').html(tablaHTML);
    
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
                alert("Ha ocurrido un error al obtener los mantenimientos.");
            }
        });
    }
    
});