$(document).ready(function() {
    $('#enviar').click(function(){
        let dni = $('#dni').val();
        let nombre = $('#nombre').val();
        let apellido = $('#apellido').val();
        let gmail = $('#gmail').val();
        let contraseña = $('#contraseña').val();
        // Validar que todos los campos estén completos
        if (dni === '' || nombre === '' || apellido === '' || gmail === '' || contraseña === '') {
            alert('Por favor, complete todos los campos.');
            return;
        }

        // Validar el formato del email utilizando una expresión regular simple
        let emailFormat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailFormat.test(gmail)) {
            alert('Por favor, ingrese un correo electrónico válido.');
            return;
        }
        
        $.post('../modulos/crearUsuario.php', {
            data_dni: dni,
            data_nombre: nombre,
            data_apellido: apellido,
            data_gmail: gmail,
            data_contraseña: contraseña
        })
        .done(function(response) {
            // Este código se ejecuta si la solicitud AJAX se completa correctamente
            // El parámetro 'response' contiene la respuesta del servidor
            
            if (response === "1") {
                alert("El DNI ya existe. Por favor, utilice un DNI diferente."); // Mostrar mensaje de error cuando el DNI ya existe
            } else {
                alert("¡Datos insertados correctamente!");
            }
        })
        .fail(function() {
            // Este código se ejecuta si la solicitud AJAX falla
            alert("Ocurrió un error, revise su DNI."); // Mostrar mensaje de error genérico en caso de fallo
        });
    });
});

