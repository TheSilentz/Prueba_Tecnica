<?php
require_once "../controladores/candidatos.controlador.php";
require_once "../modelos/candidatos.modelo.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);




class TablaCandidatos{

    public function mostrarTablaCandidatos(){

        $candidatos = ControladorCandidatos::ctrMostrarCandidatos();

        if(count($candidatos) == 0){

            echo '{"data": []}';

            return;
        }

        $datosJson = '{
        "data": [';

        for($i = 0; $i < count($candidatos); $i++){

            $botones = "<div class='btn-group'><button class='btn btn-warning btnEditarCandidato' idCandidato='".$candidatos[$i]["id"]."' data-bs-toggle='modal' data-bs-target='#editarCandidatoModal' title = 'Editar'><i class='fa fa-pencil'></i></button><button type='button' class='btn btn-danger btnBorrarCandidato' idborrarCandidato='".$candidatos[$i]['id']."' ><i class='fa fa-trash' title='Eliminar'></i></button><button type='button' class='btn btn-info btnVerCandidato' idVerCandidato='".$candidatos[$i]['id']."' data-bs-toggle='modal' data-bs-target='#verCandidatoModal' ><i class='fa fa-eye' title='Ver'></i></button></div>";

            $datosJson .= '[
                "'.($i+1).'",
                "'.$candidatos[$i]["nombre"].'",
                "'.$candidatos[$i]["correo"].'",
                "'.$candidatos[$i]["fecha_registro"].'",
                "'.$botones.'"
            ],';
        }

        $datosJson = substr($datosJson, 0, -1); // Elimina el último carácter (la coma)
        $datosJson .= ']}';

        echo $datosJson;

    }
}

$activarCandidatos = new TablaCandidatos();
$activarCandidatos -> mostrarTablaCandidatos();
