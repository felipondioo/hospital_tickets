$(document).ready(function() {
    $('#modificar').click(function() {
        modificarPrioridad();
    });

    // Escuchar el evento keypress en los campos de entrada
    $('#nombrePrioridad, #color').keypress(function(event) {
        if (event.which === 13) { // Verificar si la tecla presionada es Enter (código 13)
            modificarPrioridad();
        }
    });

    function modificarPrioridad() {
        var idPrioridad = $('#modificar').data('id'); // Obtener el ID de prioridad del atributo data-id del botón
        var nombrePrioridad = $('#nombrePrioridad').val();
        var colorHEX = $('#color').val();

        // Objeto con los datos a enviar al servidor
        var datos = {
            idPrioridad: idPrioridad,
            nombrePrioridad: nombrePrioridad,
            colorHEX: colorHEX
        };

        // Enviar los datos al servidor usando AJAX
        $.post('../../modulos/modificarPrioridad.php', datos, function(response) {
            // Manejar la respuesta del servidor
            console.log(response);

            // Ejemplo de mostrar una alerta de éxito usando SweetAlert2
            Swal.fire({
                icon: 'success',
                title: 'Prioridad modificada',
                text: 'Los datos han sido actualizados correctamente.',
                showConfirmButton: false,
                timer: 1000
            }).then(function() {
                // Redirigir o realizar otra acción después de la actualización
                window.location.href = 'agregarPrioridad.php'; // Ejemplo de redirección
            });
        }).fail(function(error) {
            // Manejar errores si la petición falla
            console.error(error.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error al modificar prioridad',
                text: 'Ocurrió un error al intentar actualizar la prioridad.'
            });
        });
    }
});
