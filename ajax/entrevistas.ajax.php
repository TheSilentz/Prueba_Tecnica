<?php
require_once "../controladores/entrevistas.controlador.php";
require_once "../modelos/entrevistas.modelo.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);   

class TablaEntrevistas {

    public function mostrarTablaEntrevistas() {

        $entrevistas = ControladorEntrevistas::ctrMostrarEntrevistas();

        if(count($entrevistas) == 0) {
            echo '{"data": []}';
            return;
        }

        $datosJson = '{
        "data": [';

        for($i = 0; $i < count($entrevistas); $i++) {

            $botones = "<div class='btn-group'><button class='btn btn-warning btnEditarEntrevista' idEntrevista='".$entrevistas[$i]["id"]."' data-bs-toggle='modal' data-bs-target='#editarEntrevistaModal' title='Editar'><i class='fa fa-pencil'></i></button><button type='button' class='btn btn-danger btnBorrarEntrevista' idBorrarEntrevista='".$entrevistas[$i]['id']."' ><i class='fa fa-trash' title='Eliminar'></i></button></div>";

            $datosJson .= '[
                "'.($i+1).'",
                "'.$entrevistas[$i]["vacante"].'",
                "'.$entrevistas[$i]["fecha_entrevista"].'",
                "'.$entrevistas[$i]["notas"].'",
                "'.$entrevistas[$i]["reclutado"].'",
                "'.$botones.'"
            ],';
        }

        $datosJson = substr($datosJson, 0, -1); // Elimina el último carácter (la coma)
        $datosJson .= ']}';

        echo $datosJson;

    }
}

$activarEntrevistas = new TablaEntrevistas();
$activarEntrevistas->mostrarTablaEntrevistas();