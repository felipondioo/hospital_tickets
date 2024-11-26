function confirmarModificacion() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Se modificará el usuario. ¿Deseas continuar?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, modificar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            enviarDatos(); // Llamar a la función para enviar los datos
        }
    });
}

function enviarDatos() {
    let datosFormulario = $('#formulario-modificar').serialize();
    $.ajax({
        type: 'POST',
        url: '../../modulos/guardarModificacion.php',
        data: datosFormulario,
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: response,
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'controlEmpleados.php';
                }
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al enviar los datos: ' + error,
                confirmButtonText: 'Aceptar'
            });
        }
    });
}