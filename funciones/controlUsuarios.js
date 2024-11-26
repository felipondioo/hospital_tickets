$(document).ready(function(){
    cargarTablaUsuarios();

    $('#dni, #nombre, #apellido, #email, #cargo, #area').on('keydown', function(event) {
        if (event.which === 13) {
            event.preventDefault();
            $('#cargar').click();
        }
    });

    $('#dniVerificar, #mailVerificar').on('keydown', function(event) {
        if (event.which === 13) {
            event.preventDefault();
            $('#enviar').click();
        }
    });

    $('#enviar').click(function(){
        let dniVerificar = $('#dniVerificar').val();
        let mailVerificar = $('#mailVerificar').val();
        let estado = 0;

        if (dniVerificar === '' ||  mailVerificar === '') {
            Swal.fire('Error', 'Por favor, complete todos los campos.', 'error');
            return;
        }

        let emailFormatVerificar = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailFormatVerificar.test(mailVerificar)) {
            Swal.fire('Error', 'Por favor, ingrese un correo electrónico válido.', 'error');
            return;
        }

        $.ajax({
            type: 'POST',
            url: '../../modulos/buscarUsuario.php',
            data: {
                dniVerificar,
                mailVerificar,
                estado
            },
            success:function(response){
                if(response == 'success'){
                    Swal.fire(
                        'Éxito',
                        'El correo de reactivación fue enviado exitosamente.',
                        'success'
                    );
                    console.log(response);
                    $('#dniVerificar').val('');
                    $('#mailVerificar').val('');                    
                }else{
                    console.log(response);
                    Swal.fire('Error', 'Ha ocurrido un error', 'error');
                }
            },
            error: function(){
                console.log(response);
                Swal.fire('Error', 'Ha ocurrido un error', 'error');
            }
        })
    });

    $('#cargar').click(function(){
        let dni = $('#dni').val();
        let nombre = $('#nombre').val();
        let apellido = $('#apellido').val();
        let email = $('#email').val();
        let cargo = $('#cargo').val();
        let area = $('#area').val();
        
        if (dni === '' || nombre === '' || apellido === '' || email === '') {
            Swal.fire('Error', 'Por favor, complete todos los campos.', 'error');
            return;
        }
    
        let emailFormat = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailFormat.test(email)) {
            Swal.fire('Error', 'Por favor, ingrese un correo electrónico válido.', 'error');
            return;
        } else if(cargo == '') {
            Swal.fire('Error', 'Por favor, seleccione un cargo.', 'error');
            return;
        } else if(area == '') {
            Swal.fire('Error', 'Por favor, seleccione un área.', 'error');
            return;
        }
    
        $.ajax({
            type: 'POST',
            url: '../../modulos/crearUsuario.php',
            data: { 
                dni: dni,
                nombre: nombre,
                apellido: apellido,
                email: email,
                area: area,
                cargo: cargo
            },
            success: function(response){
                if(response == 'success'){
                    cargarTablaUsuarios();
                    $('#dni').val('');
                    $('#nombre').val('');
                    $('#apellido').val('');
                    $('#email').val('');
                    $('#cargo').val('Seleccione un cargo');
                    $('#area').val('Seleccione un área');
                    Swal.fire('Éxito', 'Usuario creado correctamente.', 'success');
                } else if(response == 'duplicate_dni_or_email') {
                    Swal.fire('Error', 'El usuario ya existe.', 'error');
                } else {
                    Swal.fire('Error', 'Ha ocurrido un error al crear el usuario.', 'error');
                }
            },
            error: function(){
                Swal.fire('Error', 'Ha ocurrido un error al crear el usuario.', 'error');
            }
        });
    });

    function cargarTablaUsuarios() {
        $.ajax({
            type: 'GET',
            url: '../../modulos/obtenerUsuarios.php',
            success: function(response) {
                const usuarios = JSON.parse(response);
                let tablaHTML = '<table id="miTabla" class="table table-striped table-bordered dt-responsive nowrap"><thead><tr><th class="dni">DNI</th><th class="nombre">Nombre</th><th class="apellido">Apellido</th><th class="gmail">Gmail</th><th class="area">Área</th><th class="cargo">Cargo</th><th class="estado">Estado</th><th class="editar">Editar</th><th class="borrar">Deshabilitar</th></tr></thead><tbody>';
                
                usuarios.forEach(function(usuario) {
                    tablaHTML += `<tr>
                                    <td>${usuario.dni}</td>
                                    <td>${usuario.nombre}</td>
                                    <td>${usuario.apellido}</td>
                                    <td>${usuario.gmail}</td>
                                    <td>${usuario.area}</td>
                                    <td>${usuario.cargo}</td>
                                    <td>${usuario.estado}</td>
                                    <td class="button-column acciones">
                                        <button class="confirmar" id="${usuario.dni}">
                                            Editar
                                        </button>
                                    </td>
                                    <td class="button-column acciones">
                                        <center>
                                            <button class="deshabilitar" id="${usuario.dni}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                            </button>
                                        </center>
                                    </td>
                                </tr>`;
                });
                
                tablaHTML += '</tbody></table>';
                $('#tabla').html(tablaHTML);

                if ($.fn.DataTable.isDataTable('#miTabla')) {
                    $('#miTabla').DataTable().destroy();
                }

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
                Swal.fire('Error', 'Ha ocurrido un error al obtener a los usuarios', 'error');
            }
        });
    }

    $(document).on('click', '.confirmar', function(){
        let dniUsuario = $(this).attr('id');
        window.location.href = `modUsuario.php?dni=${dniUsuario}`;
    });

    $(document).on('click', '.deshabilitar', function(){
        let idUsuario = $(this).attr('id');
        deshabilitarUsuario(idUsuario);
    });

    function deshabilitarUsuario(idUsuario){
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esta acción.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sí, deshabilítalo!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '../../modulos/deshabilitarUsuario.php',
                    data: { id: idUsuario },
                    success: function(response){
                        if(response == 'success'){
                            cargarTablaUsuarios();
                            Swal.fire('Deshabilitado!', 'El usuario ha sido deshabilitado correctamente.', 'success');
                        } else {
                            Swal.fire('Error', 'Ha ocurrido un error al deshabilitar el usuario.', 'error');
                        }
                    },
                    error: function(){
                        Swal.fire('Error', 'Ha ocurrido un error al deshabilitar el usuario.', 'error');
                    }
                });
            }
        });
    }
});
