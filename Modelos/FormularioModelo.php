<?php

class FormularioModelo extends PlantillaModelo{

    public function __construct(){
        parent::__construct();
    }

    public function Insertar($Datos){
        try{
            $query = $this->db->conexion()->prepare('INSERT INTO errores (CodigoError, FechaRegistro, Usuario, Comentario) VALUES (:CodigoError, :FechaRegistro, :Usuario, :Comentario)');
            $query->execute(['CodigoError' => $Datos['CodigoError'], 'FechaRegistro' => $Datos['FechaRegistro'], 'Usuario' => $Datos['Usuario'], 'Comentario' => $Datos['Comentario']]);
            return true;
        }catch(PDOException $e){
            return false;
        }

    }
}
?>