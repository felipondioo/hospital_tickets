//----------------------CSS----------------------------------------------------------------

document.getElementById("btn__iniciar-sesion").addEventListener("click", iniciarSesion);
document.getElementById("btn__registrarse").addEventListener("click", register);
window.addEventListener("resize", anchoPage);

var formulario_login = document.querySelector(".formulario__login");
var formulario_register = document.querySelector(".formulario__register");
var contenedor_login_register = document.querySelector(".contenedor__login-register");
var caja_trasera_login = document.querySelector(".caja__trasera-login");
var caja_trasera_register = document.querySelector(".caja__trasera-register");

//FUNCIONES CSS (RESPONSIVE)

function anchoPage(){
    if (window.innerWidth > 850){
        caja_trasera_register.style.display = "block";
        caja_trasera_login.style.display = "block";
    } else {
        caja_trasera_register.style.display = "block";
        caja_trasera_register.style.opacity = "1";
        caja_trasera_login.style.display = "none";
        formulario_login.style.display = "block";
        contenedor_login_register.style.left = "0px";
        formulario_register.style.display = "none";   
    }
}

anchoPage();

function iniciarSesion(){
    if (window.innerWidth > 850){
        formulario_login.style.display = "block";
        contenedor_login_register.style.left = "10px";
        formulario_register.style.display = "none";
        caja_trasera_register.style.opacity = "1";
        caja_trasera_login.style.opacity = "0";
    } else {
        formulario_login.style.display = "block";
        contenedor_login_register.style.left = "0px";
        formulario_register.style.display = "none";
        caja_trasera_register.style.display = "block";
        caja_trasera_login.style.display = "none";
    }
}

function register(){
    if (window.innerWidth > 850){
        formulario_register.style.display = "block";
        contenedor_login_register.style.left = "410px";
        formulario_login.style.display = "none";
        caja_trasera_register.style.opacity = "0";
        caja_trasera_login.style.opacity = "1";
    } else {
        formulario_register.style.display = "block";
        contenedor_login_register.style.left = "0px";
        formulario_login.style.display = "none";
        caja_trasera_register.style.display = "none";
        caja_trasera_login.style.display = "block";
        caja_trasera_login.style.opacity = "1";
    }
}

//----------------------LOGIN----------------------------------------------------------------

// Función para manejar el login
function handleLogin() {
    const dniInput = document.getElementById('loginDNI');
    const dniLogin = dniInput.value.trim();

    const contraseñaInput = document.getElementById('loginContraseña');
    const contraseñaLogin = contraseñaInput.value.trim();

    if (dniLogin !== '' && contraseñaLogin !== '') {
        loginVerificacion(dniLogin, contraseñaLogin);
        dniInput.value = ''; // Limpiar el campo después de la verificación
        contraseñaInput.value = ''; // Limpiar el campo después de la verificación
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Campos incompletos',
            text: 'Por favor ingrese su DNI y contraseña.'
        });
    }
}

// Evento para manejar el clic en el botón de enviar
document.getElementById('enviarLogin').addEventListener('click', handleLogin);

// Evento para manejar la tecla Enter en los campos de texto
$('#loginDNI, #loginContraseña').on('keydown', function(event) {
    if (event.which == 13) {
        event.preventDefault(); // Prevenir el envío del formulario
        handleLogin();
    }
});

// Enviar las tareas por Json método post
function loginVerificacion(dni, contraseña) { 
    const opciones = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ 
            dni: dni,
            contraseña: contraseña
        })
    };

    fetch('modulos/loginuser.php', opciones) // Ruta relativa
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en el registro');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Login exitoso.',
                text: data.message
            }).then(() => {
                window.location.href = data.redirect;
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error.',
                text: data.message
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error al registrarse.',
            text: error.message
        });
    });
}
