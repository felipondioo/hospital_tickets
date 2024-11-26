$(document).ready(function() {
    $('#recuperar').click(function() {
        let correo = $('#correo').val();

        // Validar que el campo de correo no esté vacío
        if (correo === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Campo vacío',
                text: 'Por favor, ingrese un correo válido.'
            });
            return;
        }

        // Validar el formato del email utilizando una expresión regular simple
        let emailFormat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailFormat.test(correo)) {
            Swal.fire({
                icon: 'warning',
                title: 'Formato incorrecto',
                text: 'Por favor, ingrese un correo electrónico válido.'
            });
            return;
        }
        
        $.post('modulos/recuperarContra.php', {
            data_correo: correo
        })
        .done(function(response) {
            let res = JSON.parse(response);
            if (res.status === 'ok') {
                // Redireccionar a la página de login con un mensaje de éxito en la URL
                Swal.fire({
                    icon: 'success',
                    title: 'Correo enviado',
                    text: 'Por favor, revise su bandeja de entrada.',
                }).then(() => {
                    window.location.href = 'login.php?message=ok';
                });
            } else if (res.status === 'not_found') {
                Swal.fire({
                    icon: 'error',
                    title: 'Correo no encontrado',
                    text: 'Ocurrió un error, por favor intentelo mas tarde.'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error: ' + res.message
                });
            }
        })
        .fail(function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al intentar recuperar la contraseña. Inténtelo nuevamente.'
            }).then(() => {
                window.location.href = 'login.php?message=error';
            });
        });
    });
});
