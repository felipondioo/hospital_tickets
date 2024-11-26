$(document).ready(function() {
    cargarTablaAreas();

    $('#area').on('keydown', function(event) {
        if (event.which === 13) {
            event.preventDefault();
            $('#cargar').click();
        }
    });

    $('#cargar').click(function(){
        let nombre = $('#area').val();
        if (nombre == ''){
            Swal.fire({
                icon: 'error',
                title: 'Campos incompletos',
                text: 'Por favor complete el campo de nombre.'
            });
            return;
        }
    
        $.post('../../modulos/crearArea.php', {
            data_nombre: nombre
        })
        .done(function(response){
            if(response === "1"){
                Swal.fire({
                    icon: 'error',
                    title: 'Área existente',
                    text: 'El área ya existe.'
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Área creada',
                    text: 'Área creada exitosamente.'
                });
                $('#area').val('');
                cargarTablaAreas(); // Llama a la función para actualizar la tabla
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
    
    function cargarTablaAreas() { 
        $.ajax({
            method: 'GET',
            url: '../../modulos/areasTabla.php',
            success: function(response) {
                const areas = JSON.parse(response);
                let tablaHTML = '';
    
                areas.forEach(function(area) {
                    let estadoTexto = area.estado == 1 ? 'Habilitado' : 'Deshabilitado';
                    tablaHTML += `<tr>
                                    <td class="nombre">${area.nombre}</td>
                                    <td>${estadoTexto}</td>
                                    <td>
                                        <button class="habilitar" id="${area.id}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-unlock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 9.9-1"></path></svg>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="eliminar" id="${area.id}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                        </button>
                                    </td>
                                </tr>`;
                });
    
                // Actualizar el contenido del tbody y reiniciar DataTables
                $('#miTabla').DataTable().destroy(); // Destruir instancia previa de DataTable
                $('#miTabla tbody').html(tablaHTML);
    
                // Inicializar DataTables después de actualizar el tbody
                $('#miTabla').DataTable({
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
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ha ocurrido un error al obtener las áreas.'
                });
            }
        });
    }
    

    $(document).on('click', 'button.eliminar', function() {
        var id = $(this).attr('id');
        var estado = 0;

        $.post('../../modulos/deshabilitarAreas.php', {
            data_id: id,
            data_estado: estado
        })
        .done(function(response) {
            if (response === "1") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El área no pudo ser deshabilitada.'
                });
            } else {
                cargarTablaAreas();
                Swal.fire({
                    icon: 'success',
                    title: 'Área deshabilitada',
                    text: 'Área deshabilitada correctamente!'
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

        $.post('../../modulos/habilitarAreas.php', {
            data_id: id,
            data_estado: estado
        })
        .done(function(response) {
            if (response === "1") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El área no pudo ser habilitada.'
                });
            } else {
                cargarTablaAreas();
                Swal.fire({
                    icon: 'success',
                    title: 'Área habilitada',
                    text: 'Área habilitada correctamente!'
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
