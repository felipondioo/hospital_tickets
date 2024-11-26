$(document).ready(function() {
    cargarTablaMantenimientos();

    function cargarTablaMantenimientos() {
        $.ajax({
            method: 'GET',
            url: '../../modulos/obtenerMantenimientosNuevos.php',
            success: function(response) {
                const data = JSON.parse(response);
                const mantenimientos = data.mantenimientos;

                if (data.nuevosMantenimientos) {
                    let tablaHTML = '';

                    mantenimientos.forEach(function(mantenimiento) {
                        tablaHTML += `
                            <tr>
                                <td>${mantenimiento.mantenimiento}</td>
                                <td>${mantenimiento.area}</td>
                                <td>${mantenimiento.fechaCreacion}</td>
                                <td>${mantenimiento.fechaHora}</td>
                                <td>
                                    <a href="modMantenimiento.php?id=${mantenimiento.id}" class="btn btn-success btn-sm modificar">
                                        Devolución
                                    </a>
                                </td>
                            </tr>`;
                    });

                    $('#tabla').html(tablaHTML);
                    $('#tabla-mantenimientos').DataTable();
                } else {
                    $('#tabla').html('<tr><td colspan="7">No hay mantenimientos en curso.</td></tr>');
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ha ocurrido un error al obtener los mantenimientos.'
                });
            }
        });
    }
});