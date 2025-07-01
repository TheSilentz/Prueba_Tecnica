<?php

require_once "conexion.php";

ini_set('display_errors', 0); // Apagar la visualización de errores
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/php_errors.log'); 

class ModeloCandidatos {

     /*=============================================
    VERIFICAR SI EL CORREO YA EXISTE
    =============================================*/
    static public function mdlVerificarCorreoExistente($correo, $idExcluir = null) {
        $stmt = null;
        try {
            $sql = "SELECT COUNT(*) FROM prospecto WHERE correo = :correo";
            if ($idExcluir !== null) {
                $sql .= " AND id != :idExcluir"; // Excluir el propio ID al editar
            }

            $stmt = Conexion::conectar()->prepare($sql);
            $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
            if ($idExcluir !== null) {
                $stmt->bindParam(":idExcluir", $idExcluir, PDO::PARAM_INT);
            }
            $stmt->execute();
            
            $count = $stmt->fetchColumn();
            return ($count > 0); // Retorna true si el correo existe, false si no
        } catch (PDOException $e) {
            error_log("Error en mdlVerificarCorreoExistente: " . $e->getMessage());
            return true; // Asumimos que existe para prevenir duplicados en caso de error de BD
        } finally {
            if ($stmt) {
                $stmt->closeCursor();
                $stmt = null;
            }
        }
    }

    /*=============================================
    MOSTRAR CANDIDATOS TABLA PRINCIPAL
    =============================================*/
       static public function mdlMostrarCandidatos($tabla) {
        $stmt = null; // Inicializar a null
        try {
            $stmt = Conexion::conectar()->prepare("SELECT id, nombre, correo, fecha_registro FROM $tabla");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en mdlMostrarCandidatos: " . $e->getMessage()); // Registrar el error
            return array(); // Devolver un array vacío para que el frontend no tenga datos
        } finally {
            if ($stmt) {
                $stmt->closeCursor();
                $stmt = null;
            }
        }
    }

/* ==============================================
    INSERTAR CANDIDATO
================================================*/
static public function mdlInsertarCandidato($datos) {
        // Validación Backend 
        if (empty($datos['nombre']) || empty($datos['correo']) || empty($datos['fecha_registro'])) {
            return "error_datos_vacios";
        }
        if (!filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
            return "error_correo_invalido";
        }

        if (self::mdlVerificarCorreoExistente($datos['correo'])) {
            return "error_correo_duplicado";
        }

        $stmt = null; // Inicializar a null
        try {
            $stmt = Conexion::conectar()->prepare("INSERT INTO prospecto (nombre, correo, fecha_registro) VALUES (:nombre, :correo, :fecha_registro)");
            $stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(":correo", $datos['correo'], PDO::PARAM_STR);
            $stmt->bindParam(":fecha_registro", $datos['fecha_registro'], PDO::PARAM_STR);

            if($stmt->execute()) {
                return "ok";
            } else {
                // Esto solo se ejecutará si execute() devuelve false sin lanzar excepción
                error_log("Error de ejecución SQL en mdlInsertarCandidato (execute() devolvió false): " . implode(" - ", $stmt->errorInfo()));
                return "error_generico"; // Mensaje genérico para el frontend
            }
        } catch (PDOException $e) {
            error_log("Error de base de datos en mdlInsertarCandidato: " . $e->getMessage()); // Registrar el error
            return "error_generico"; // Mensaje genérico para el frontend
        } finally {
            if ($stmt) {
                $stmt->closeCursor();
                $stmt = null;
            }
        }
    }

    /*============================================
    MOSTRAR DATOS DEL CANDIDATO EN MODAL EDITAR 
    ============================================*/

static public function mdlMostrarCandidatoEdit($id) {
        $stmt = null; // Inicializar a null
        try {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM prospecto WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error en mdlMostrarCandidatoEdit: " . $e->getMessage()); // Registrar el error
            return false; // Devolver false o un array vacío en caso de error
        } finally {
            if ($stmt) {
                $stmt->closeCursor();
                $stmt = null;
            }
        }
    }
    

/*=============================================
    MODIFICAR CANDIDATO (mdlModificarCandidato)
    =============================================*/
static public function mdlModificarCandidato($datos) {
        // Validación Backend 
        if (empty($datos['idCandidato']) || empty($datos['nombreProspecto']) || empty($datos['correo']) || empty($datos['fechaRegistro'])) {
            return "error_datos_vacios";
        }
        if (!filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
            return "error_correo_invalido";
        }

         // NUEVA VALIDACIÓN: Verificar si el correo ya existe, excluyendo el ID del propio candidato
        if (self::mdlVerificarCorreoExistente($datos['correo'], $datos['idCandidato'])) {
            return "error_correo_duplicado";
        }


        $stmt = null; // Inicializar a null
        try {
            $stmt = Conexion::conectar()->prepare("UPDATE prospecto SET nombre = :nombre, correo = :correo, fecha_registro = :fecha_registro WHERE id = :id");

            $stmt->bindParam(":id", $datos['idCandidato'], PDO::PARAM_INT); 
            $stmt->bindParam(":nombre", $datos['nombreProspecto'], PDO::PARAM_STR); 
            $stmt->bindParam(":correo", $datos['correo'], PDO::PARAM_STR); 
            $stmt->bindParam(":fecha_registro", $datos['fechaRegistro'], PDO::PARAM_STR); 
            
            if($stmt->execute()) {
                $rowsAffected = $stmt->rowCount(); 
                if ($rowsAffected > 0) {
                    return "ok"; 
                } else {
                    // Si no se afectaron filas, puede ser que el ID no exista o no haya cambios
                    return "no_cambios_o_id_inexistente"; 
                }
            } else {
                error_log("Error de ejecución SQL en mdlModificarCandidato (execute() devolvió false): " . implode(" - ", $stmt->errorInfo()));
                return "error_generico"; // Mensaje genérico para el frontend
            }
        } catch (PDOException $e) {
            error_log("Error de base de datos en mdlModificarCandidato: " . $e->getMessage()); // Registrar el error
            return "error_generico"; // Mensaje genérico para el frontend
        } finally {
            if ($stmt) {
                $stmt->closeCursor();
                $stmt = null;
            }
        }
    }
    
    /*=============================================
    BORRAR CANDIDATO
    =============================================*/
    
   static public function mdlBorrarCandidato($id) {
        $stmt = null; // Inicializar a null
        try {
            $stmt = Conexion::conectar()->prepare("DELETE FROM prospecto WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            
            if($stmt->execute()) {
                $rowsAffected = $stmt->rowCount();
                if ($rowsAffected > 0) {
                    return "ok";
                } else {
                    return "no_encontrado_para_borrar"; // Si el ID no existe
                }
            } else {
                error_log("Error de ejecución SQL en mdlBorrarCandidato (execute() devolvió false): " . implode(" - ", $stmt->errorInfo()));
                return "error_generico"; // Mensaje genérico
            }
        } catch (PDOException $e) {
            error_log("Error de base de datos en mdlBorrarCandidato: " . $e->getMessage()); // Registrar el error
            return "error_generico"; // Mensaje genérico para el frontend
        } finally {
            if ($stmt) {
                $stmt->closeCursor();
                $stmt = null;
            }
        }
    }
    


}


if(isset($_POST['TraerReclutados'])) {
    $respuesta = ModeloCandidatos::mdlMostrarCandidatos($id);
    echo json_encode($respuesta);
    return;
}

if(isset($_POST['InsertarCandidato'])) { 
    $datos = array(
        'nombre' => $_POST['nombreProspecto'], 
        'correo' => $_POST['correo'],        
        'fecha_registro' => $_POST['fechaRegistro'] 
    );
    $respuesta = ModeloCandidatos::mdlInsertarCandidato($datos);
    echo json_encode($respuesta);
    return;
}

if(isset($_POST['EditarCandidato'])) { 
    $id = $_POST['idCandidato'];
    $respuesta = ModeloCandidatos::mdlMostrarCandidatoEdit($id); 
    echo json_encode($respuesta); 
    return;
}

if(isset($_POST['ModificarCandidato'])) {

    $datos = array(
        'idCandidato' => $_POST['idCandidatoEdit'], 
        'nombreProspecto' => $_POST['nombreProspectoEdit'], 
        'correo' => $_POST['correoEdit'], 
        'fechaRegistro' => $_POST['fechaRegistroEdit'], 
    );
    
    $respuesta = ModeloCandidatos::mdlModificarCandidato($datos); 
    echo json_encode($respuesta);
    return; 
}

if(isset($_POST['idBorrarCandidato'])) { 
    $id = $_POST['idBorrarCandidato']; 
    $respuesta = ModeloCandidatos::mdlBorrarCandidato($id);
    echo json_encode($respuesta);
    return; 
}


