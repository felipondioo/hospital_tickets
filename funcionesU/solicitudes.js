$(document).ready(function() {
    $('#mantenimiento, #descripcion, #selectP').on('keydown', function(event) {
        if (event.which === 13) {
            event.preventDefault();
            $('#crear').click();
        }
    });

    $('#crear').click(function() {
        let mantenimiento = $('#mantenimiento').val();
        let descripcion = $('#descripcion').val();
        let selectP = $('#selectP').val();

        // Validar que todos los campos estén completos
        if (mantenimiento === '' || descripcion === '' || selectP == null) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: 'Por favor, complete todos los campos.'
            });
            return;
        }

        $.post('../../modulos/crearSolicitud.php', {
            data_mantenimiento: mantenimiento,
            data_descripcion: descripcion,
            data_selectP: selectP,
        })
        .done(function(response) {
            if (response.includes("Solicitud enviada correctamente")) {
                Swal.fire({
                    icon: 'success',
                    title: 'Solicitud enviada',
                    text: response
                }).then(() => {
                    // Limpiar los campos del formulario
                    $('#mantenimiento, #descripcion').val('');
                    $('#selectP').val('');

                    $('#crear').prop('disabled', true);
                    location.reload(); // Recargar la página
                });
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Respuesta del servidor',
                    text: response
                });
            }
        })
        .fail(function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error, intentelo nuevamente.'
            });
        });
    });
});
