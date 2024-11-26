<?php
    include('conexion.php');

    if(isset($_POST['busqueda'])) {
        $busqueda = $_POST['busqueda'];
        $query = "SELECT * FROM usuarios WHERE dni LIKE '%$busqueda%' ORDER BY dni DESC";
        
        $resultado = mysqli_query($conexion, $query);

        // Define la variable $tablaHTML
        $tablaHTML = '';

        if(mysqli_num_rows($resultado) > 0){
            while($fila = mysqli_fetch_assoc($resultado)){
                // Concatena cada fila a $tablaHTML
                $tablaHTML .= '<tr>';
                $tablaHTML .= '<td>'.$fila['dni'].'</td>';
                $tablaHTML .= '<td>'.$fila['nombre'].'</td>';
                $tablaHTML .= '<td>'.$fila['apellido'].'</td>';
                $tablaHTML .= '<td>'.$fila['gmail'].'</td>';
                $tablaHTML .= '<td>'.$fila['area'].'</td>';
                $tablaHTML .= '<td>'.$fila['cargo'].'</td>';
                $tablaHTML .= '<td>'.$fila['estado'].'</td>';
                $tablaHTML .= '<td class="button-column">
                                <button class="confirmar" id='.$fila['dni'].'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </button>
                            </td>';
                $tablaHTML .= '<td class="button-column">
                                <button class="eliminar" id='.$fila['dni'].'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </td>';
                $tablaHTML .= '</tr>';
            }
        }

        // Imprime la tabla HTML al final
        echo '<table><thead><tr><th class="dni">DNI</th><th class="nombre">Nombre</th><th class="apellido">Apellido</th><th class="gmail">Gmail</th><th class="area">Área</th><th class="cargo">Cargo</th><th class="estado">Estado</th><th class="editar">Editar</th><th class="borrar">Borrar</th></tr></thead><tbody>';
        echo $tablaHTML;
        echo '</tbody></table>';
    } 
    else {
        echo ''; // Puedes imprimir un mensaje aquí si lo deseas
    }
?>
