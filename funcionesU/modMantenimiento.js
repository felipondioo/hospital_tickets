$(document).ready(function() {
    var esEscritorio = !/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

    // Si es un dispositivo de escritorio, agregar el manejador de eventos
    if (esEscritorio) {
        $('#mantenimiento, #descripcion, #select').on('keydown', function(event) {
            // Verificar si se está presionando la tecla "Enter"
            if (event.which === 13) {
                // Verificar si se está presionando también la tecla "Shift"
                if (event.shiftKey) {
                    // Insertar un salto de línea en el textarea
                    var cursorPos = $(this).prop('selectionStart');
                    var text = $(this).val();
                    var newText = text.substring(0, cursorPos) + '\n' + text.substring(cursorPos);
                    $(this).val(newText);
                    // Evitar que se envíe el formulario
                    event.preventDefault();
                } else {
                    // Si solo se presionó "Enter", ejecutar la acción predeterminada (hacer clic en el botón #modificar)
                    $('#modificar').click();
                }
            }
        });
    }

    $('#modificar').click(function() {
        let descripcion = $('#descripcion').val();
        let urlParams = new URLSearchParams(window.location.search);
        let id = urlParams.get('id');

        // console.log('Descripción:', descripcion); // Añadido para depuración
        // console.log('ID:', id); // Añadido para depuración

        if(descripcion.trim() === "") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor describa los avances del mantenimiento.'
            });
            return;
        }

        $.post('../../modulos/modMantenimientoUser.php', {
            data_descripcion: descripcion,
            data_id: id,
        })
        .done(function(response) {            
            if (response === "1") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ha ocurrido un error, por favor inténtalo de nuevo.'
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: '¡Mantenimiento modificado correctamente!'
                }).then(() => {
                    window.location.href = '../indexEmpleado.php';
                });
            }
        })
        .fail(function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ha ocurrido un error, por favor inténtalo de nuevo.'
            });
        });
    });
});
