$(document).ready(function() {
    var esEscritorio = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

    // Manejo del Enter y Shift+Enter en dispositivos no escritorio
    if (!esEscritorio) {
        $('#mantenimiento, #descripcion').on('keydown', function(event) {
            if (event.which === 13) { // Tecla "Enter" presionada
                if (event.shiftKey) { // Shift + Enter para salto de línea en textarea
                    var cursorPos = $(this).prop('selectionStart');
                    var text = $(this).val();
                    var newText = text.substring(0, cursorPos) + '\n' + text.substring(cursorPos);
                    $(this).val(newText);
                    event.preventDefault(); // Evitar envío del formulario
                } else {
                    $('#modificar').click(); // Solo "Enter", ejecutar acción de modificar
                }
            }
        });
    }

    // Modificar mantenimiento
    $('#modificar').click(function() {
        var descripcion = $('#descripcion').val();
        var urlParams = new URLSearchParams(window.location.search);
        var id = urlParams.get('id');

        
        if (descripcion == "") {
            mostrarAlertaError("Por favor, completa todos los campos antes de continuar.");
            return;
        }

        $.post('../../modulos/modMantenimientoCurso.php', {
            data_descripcion: descripcion,
            data_id: id,
        })
        .done(function(response) {            
            if (response === "1") {
                mostrarAlertaError("Ha ocurrido un error, por favor inténtalo de nuevo.");
            } else {
                mostrarAlertaExito("¡Mantenimiento modificado correctamente!" , function() {
                    window.location.href = 'mcEncargado.php';
                });
            }
        })
        .fail(function() {
            mostrarAlertaError("Ha ocurrido un error, por favor inténtalo de nuevo.");
        });
    });

    // Función para mostrar alerta de error con SweetAlert2
    function mostrarAlertaError(mensaje) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: mensaje,
        });
    }

    // Función para mostrar alerta de éxito con SweetAlert2
    function mostrarAlertaExito(mensaje, callback) {
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: mensaje,
        }).then(function(result) {
            if (callback && typeof callback === 'function') {
                callback();
            }
        });
    }
});
