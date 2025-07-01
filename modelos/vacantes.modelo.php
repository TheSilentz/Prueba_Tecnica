<?php
require_once "conexion.php";

ini_set('display_errors', 0); // Apagar la visualización de errores
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/php_errors.log'); 

class ModeloVacantes {
   
    static public function mdlMostrarVacantes($tabla) {
        $stmt= null;
        try{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en mdlMostrarEntrevistas: " . $e->getMessage());
            return array (); // Retornar un array vacío en caso de error
        } finally {
            if ($stmt) {
                $stmt->closeCursor();
                $stmt = null; // Liberar el recurso
            }

        }
    }
}


if(isset($_POST["TraerVacantes"])) {
   
            $respuesta = ModeloVacantes::mdlMostrarEntrevistas($id);
            echo json_encode($respuesta);
            return;
}