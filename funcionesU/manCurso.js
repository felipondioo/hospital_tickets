$(document).ready(function() {
    cargarTablaMantenimientos();

    function cargarTablaMantenimientos() {
        $.ajax({
            method: 'GET',
            url: '../../modulos/obtenerManAreas.php',
            success: function(response) {
                try {
                    const data = JSON.parse(response);
                    const mantenimientos = data.mantenimientos;

                    if (mantenimientos.length > 0) {
                        let tablaHTML = '';

                        mantenimientos.forEach(function(mantenimiento) {
                            tablaHTML += `<tr>
                                <td>${mantenimiento.mantenimiento}</td>
                                <td>${mantenimiento.area}</td>
                                <td>${mantenimiento.userD}</td>
                                <td>${mantenimiento.fechaCreacion}</td>
                                <td>${mantenimiento.fechaHora}</td>
                            </tr>`;
                        });

                        $('#tabla').html(tablaHTML);
                        $('#tabla-mantenimientos').DataTable();

                    } else {
                        $('#tabla').html('<tr><td colspan="6">No hay mantenimientos en curso.</td></tr>');
                    }
                } catch (error) {
                    console.error("Error parsing JSON:", error);
                    console.error("Response:", response);
                    alert("Ha ocurrido un error al procesar la información de los mantenimientos.");
                }
            },
            error: function() {
                alert("Ha ocurrido un error al obtener los mantenimientos.");
            }
        });
    }
});