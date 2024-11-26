$(document).ready(function() {
    $.ajax({
        url: '../../modulos/obtenerMantenimientos.php', // URL del archivo PHP que devuelve los datos en formato JSON
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // Generar la tabla dinámicamente
            var tableHTML = "<table class='table'>";
            tableHTML += "<tr><th>Nombre</th><th>Descripción</th><th>Área</th><th>Fecha y Hora</th><th>Modificar</th><th>Finalizar</th></tr>";
            data.forEach(function(row) {
                tableHTML += "<tr>";
                tableHTML += "<td>" + row.mantenimiento + "</td>";
                tableHTML += "<td>" + row.descripcion + "</td>";
                tableHTML += "<td>" + row.area + "</td>";
                tableHTML += "<td>" + row.fechaHora + "</td>";
                tableHTML += "<td><a href='modMantenimiento.php?id=" + row.id + "' class='btn btn-warning'>Modificar</a></td>";
                tableHTML += "<td><button class='btn btn-danger finalizar-btn' data-id='" + row.id + "'>Finalizar</button></td>";
                tableHTML += "</tr>";
            });
            tableHTML += "</table>";

            // Insertar la tabla en el contenedor
            $('#tabla-container').html(tableHTML);

            // Agregar evento de clic a los botones de "Finalizar"
            $('.finalizar-btn').click(function() {
                var id = $(this).data('id');
                // Aquí puedes enviar el ID a tu archivo PHP para finalizar el mantenimiento
                // Utiliza AJAX para enviar el ID y manejar la respuesta del servidor
                console.log('Finalizar mantenimiento con ID:', id);
            });
        },
        error: function() {
            // Manejar errores de la solicitud AJAX
            console.log('Error al obtener los datos');
        }
    });
});

