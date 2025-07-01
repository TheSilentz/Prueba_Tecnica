<?php
require_once "../controladores/vacantes.controlador.php";
require_once "../modelos/vacantes.modelo.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);   

class TablaVacantes {

    public function mostrarTablaVacantes() {

        $vacantes = ControladorVacantes::ctrMostrarVacantes();

        if(count($vacantes) == 0) {
            echo '{"data": []}';
            return;
        }

        $datosJson = '{
        "data": [';

        for($i = 0; $i < count($vacantes); $i++) {

            $botones = "<div class='btn-group'><button class='btn btn-warning btnEditarEntrevista' idVacantes='".$vacantes[$i]["id"]."' data-bs-toggle='modal' data-bs-target='#editarEntrevistaModal' title='Editar'><i class='fa fa-pencil'></i></button><button type='button' class='btn btn-danger btnBorrarEntrevista' idVacantes='".$vacantes[$i]['id']."' ><i class='fa fa-trash' title='Eliminar'></i></button></div>";

            $datosJson .= '[
                "'.($i+1).'",
                "'.$vacantes[$i]["area"].'",
                "'.$vacantes[$i]["sueldo"].'",
                "'.$vacantes[$i]["activo"].'",
                "'.$botones.'"
            ],';
        }

        $datosJson = substr($datosJson, 0, -1); // Elimina el último carácter (la coma)
        $datosJson .= ']}';

        echo $datosJson;

    }
}

$activarVacantes = new TablaVacantes();
$activarVacantes->mostrarTablaVacantes();