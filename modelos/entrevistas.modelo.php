<?php
require_once "conexion.php";

ini_set('display_errors', 0); // Apagar la visualización de errores
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/php_errors.log'); 

class ModeloEntrevistas {
   
    static public function mdlMostrarEntrevistas($tabla) {
        $stmt= null;
        try{
            $stmt = Conexion::conectar()->prepare("SELECT id, vacante, fecha_entrevista, notas, reclutado FROM $tabla" );
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

    // Aquí puedes agregar más métodos para insertar, actualizar o eliminar entrevistas
    static public function mdlInsertarEntrevista($datos, $tabla) {
        $stmt = null;
        try {
            $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (vacante, fecha_entrevista, notas, reclutado) VALUES (:vacante, :fecha_entrevista, :notas, :reclutado)");
            $stmt->bindParam(":vacante", $datos["vacante"], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_entrevista", $datos["fecha_entrevista"], PDO::PARAM_STR);
            $stmt->bindParam(":notas", $datos["notas"], PDO::PARAM_STR);
            $stmt->bindParam(":reclutado", $datos["reclutado"], PDO::PARAM_INT);
            if($stmt->execute()) {
                return "ok";
            } else {
                return "error";
            }
        } catch (PDOException $e) {
            error_log("Error en mdlInsertarEntrevista: " . $e->getMessage());
            return "error";
        } finally {
            if ($stmt) {
                $stmt->closeCursor();
                $stmt = null; // Liberar el recurso
            }

        }
       
    }


    /* ===================
    TRAER DATOS DE VACANTES EN EL SELECT 
    =====================*/
    static public function mdlSelectVacantes() {
        $stmt = null;
        try {
            $stmt = Conexion::conectar()->prepare("SELECT id, area, sueldo FROM VACANTE WHERE activo = 1");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en mdlSelectVacantes: " . $e->getMessage());
            return array(); // Retornar un array vacío en caso de error
        } finally {
            if ($stmt) {
                $stmt->closeCursor();
                $stmt = null; 
            }
        }
    }

   
}


if(isset($_POST["TraerEntrevistas"])) {
   
            $respuesta = ModeloEntrevistas::mdlMostrarEntrevistas();
            echo json_encode($respuesta);
            return;
}

if(isset($_POST["TraerDatosSelectVacantes"])) {
    $respuesta = ModeloEntrevistas::mdlSelectVacantes();
    echo json_encode($respuesta);
    return;
}




