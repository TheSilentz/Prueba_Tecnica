<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "../modelos/candidatos.modelo.php";

class ControladorCandidatos {

    /*=============================================
    MOSTRAR CANDIDATOS
    =============================================*/
    static public function ctrMostrarCandidatos() {
        $tabla = 'prospecto';
        $respuesta = ModeloCandidatos::mdlMostrarCandidatos($tabla);
        return $respuesta;
    }

    
}
