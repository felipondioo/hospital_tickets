$(document).ready(function() {
    cargarTablaPrioridades();

    $('#prioridad').on('keydown', function(event) {
        if (event.which === 13) {
            event.preventDefault();
            $('#cargar').click();
        }
    });

    $('#cargar').click(function(){
        let nombre = $('#prioridad').val();
        let color = $('#color').val();
        if (nombre == ''){
            Swal.fire({
                icon: 'error',
                title: 'Campos incompletos',
                text: 'Por favor complete el campo de nombre.'
            });
            return;
        }

        $.post('../../modulos/crearPrioridad.php', {
            data_nombre: nombre,
            data_color: color
        })
        .done(function(response){
            if(response === "1"){
                Swal.fire({
                    icon: 'error',
                    title: 'Prioridad existente',
                    text: 'La prioridad ya existe.'
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Prioridad creada',
                    text: 'Prioridad creada exitosamente.'
                });
                $('#prioridad').val('');
                cargarTablaPrioridades();
            }
        })
        .fail(function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error, inténtelo más tarde.'
            });
        });
    });

    function cargarTablaPrioridades() {
        $.ajax({
            method: 'GET',
            url: '../../modulos/prioridadesTabla.php',
            success: function(response) {
                const prioridades = JSON.parse(response);
                let tablaHTML = '<table id="miTabla" class="display" style="width: 100%;">';
                tablaHTML += '<thead><tr><th>Nombre</th><th>Color</th><th>Estado</th><th>Editar</th><th>Habilitar</th><th>Deshabilitar</th></tr></thead>';
                tablaHTML += '<tbody>';
    
                prioridades.forEach(function(prioridad) {
                    let estadoTexto = prioridad.estado == 1 ? 'Habilitado' : 'Deshabilitado';
                    tablaHTML += `<tr>
                                    <td class="nombre">${prioridad.nombre}</td>
                                    <td style="background-color:${prioridad.color};"></td>
                                    <td>${estadoTexto}</td>
                                    <td><a href="modPrioridad.php?id=${prioridad.id}" class="btn btn-warning">Editar</a></td>
                                    <td>
                                        <button class="habilitar" id="${prioridad.id}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-unlock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 9.9-1"></path></svg>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="eliminar" id="${prioridad.id}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                        </button>
                                    </td>
                                </tr>`;
                });
                
                tablaHTML += '</tbody></table>';
                $('#tabla').html(tablaHTML);
    
                // Inicializar DataTables
                $('#miTabla').DataTable({
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
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ha ocurrido un error al obtener las prioridades.'
                });
            }
        });
    }
    

    $(document).on('click', 'button.eliminar', function() {
        var id = $(this).attr('id');
        var estado = 0;

        $.post('../../modulos/deshabilitarPrioridad.php', {
            data_id: id,
            data_estado: estado
        })
        .done(function(response) {
            if (response === "1") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La prioridad no pudo ser deshabilitada.'
                });
            } else {
                cargarTablaPrioridades();
                Swal.fire({
                    icon: 'success',
                    title: 'Prioridad deshabilitada',
                    text: 'Prioridad deshabilitada correctamente!'
                });
            }
        })
        .fail(function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error.'
            });
        });
    });

    $(document).on('click', 'button.habilitar', function() {
        var id = $(this).attr('id');
        var estado = 1;

        $.post('../../modulos/habilitarPrioridad.php', {
            data_id: id,
            data_estado: estado
        })
        .done(function(response) {
            if (response === "1") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La prioridad no pudo ser habilitada.'
                });
            } else {
                cargarTablaPrioridades();
                Swal.fire({
                    icon: 'success',
                    title: 'Prioridad habilitada',
                    text: 'Prioridad habilitada correctamente!'
                });
            }
        })
        .fail(function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error.'
            });
        });
    });
});
