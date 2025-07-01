<?php

class Conexion{

    static public function conectar(){
        try {
            $link = new PDO("mysql:host=localhost;dbname=db_reclutamiento", "root", "", array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                // Configura PDO para lanzar excepciones en caso de error
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
            ));
            return $link;
        } catch (PDOException $e) {
            // Puedes loguear el error aquí en un archivo de log en lugar de mostrarlo directamente
            error_log("Error de conexión a la base de datos: " . $e->getMessage());
            die("Error de conexión a la base de datos."); // Detiene la ejecución y muestra un mensaje genérico al usuario
        }
    }
}