<!DOCTYPE html>
<html>
    <head>
        <style>
            .form-control {
                display: block;
                width: 100%;
                padding: .375rem .75rem;
                font-size: 1rem;
                line-height: 1.5;
                color: #495057;
                background-color: #fff;
                background-clip: padding-box;
                border: 1px solid #ced4da;
                border-radius: .25rem;
                transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            }

            .form-label {
                margin-bottom: .5rem;
            }

            .color-square {
                width: 20px;
                height: 20px;
                border-radius: 50%;
                display: inline-block;
                margin-left: 10px;
            }
            
            .form-control-inline {
                display: flex;
                align-items: center;
                margin-bottom: 1rem;
            }
            
            .form-control-inline .form-control {
                display: flex;
                align-items: center;
                margin-bottom: 0;
            }
        </style>
    </head>
    <body>
        <?php
            if(isset($_GET['id'])) {
                $id = $_GET['id'];
                
                include('conexion.php');

                // Update the query to join the mantenimientos and prioridades tables
                $consulta = "SELECT m.*, p.* FROM mantenimientos m 
                            JOIN prioridades p ON m.prioridad = p.idPrioridad 
                            WHERE m.id = $id AND m.estado = 0";
                $resultado = mysqli_query($conexion, $consulta);

                if(mysqli_num_rows($resultado) > 0) {
                    // Iterar sobre cada fila de resultados
                    while($row = mysqli_fetch_assoc($resultado)) {
                        echo '<div class="form-control">' . $row['mantenimiento'] . '</div>';
                        
                        echo '<br><label for="exampleFormControlTextarea1" class="form-label">Prioridad del mantenimiento:</label>';
                        $nombrePrioridad = $row['nombrePrioridad'];
                        $colorHEX = $row['colorHEX'];
                        echo '
                                <div class="form-control">'.$nombrePrioridad.'
                                <div class="color-square" style="background-color:' . $colorHEX . '; margin-bottom: -5px;"></div>
                                </div>';

                        // Formatear la fecha de creación
                        echo '<br><label for="exampleFormControlTextarea1" class="form-label">Fecha de creación del mantenimiento:</label>';
                        $fechaCreacion = date('d/m/y H:i:s', strtotime($row['fechaCreacion']));
                        echo '<div class="form-control">' . $fechaCreacion . '</div>';

                        echo '<br><label for="exampleFormControlTextarea1" class="form-label">Primer área del mantenimiento:</label>';
                        $primerArea = ($row['primerArea']);
                        echo '<div class="form-control">' . $primerArea . '</div>';

                        echo '<br><label for="exampleFormControlTextarea1" class="form-label">Histórico de Descripción: ' .$row['mantenimiento']. '</label>';
                    }

                    // Consulta para obtener las descripciones del mantenimiento específico
                    $consulta_descripciones = "SELECT * FROM descripciones WHERE fkMantenimiento = $id ORDER BY fechaHora ASC";
                    $resultado_descripciones = mysqli_query($conexion, $consulta_descripciones);


                    mysqli_free_result($resultado);
                    mysqli_close($conexion);
                } else {
                    echo "No se encontraron resultados para el ID especificado.";
                }
            } else {
                echo "No se especificó un ID en la URL.";
            }
        ?>
    </body>
</html>
