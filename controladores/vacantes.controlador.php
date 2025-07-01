<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "../modelos/vacantes.modelo.php";

class ControladorVacantes {

    static public function ctrMostrarVacantes() {
        $tabla = 'vacante';
        $respuesta = ModeloVacantes::mdlMostrarVacantes($tabla);
        return $respuesta;
    }
}
