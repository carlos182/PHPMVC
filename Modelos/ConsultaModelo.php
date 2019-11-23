<?php

include_once 'Modelos/EntidadError.php';
class ConsultaModelo extends PlantillaModelo{

    public function __construct(){
        parent::__construct();
    }

    public function Recuperar(){
        $items = [];
        try{
            $query = $this->db->conexion()->query("SELECT*FROM errores");

            while($row = $query->fetch()){
                $item = new EntidadError();
                $item->id = $row['Id'];
                $item->CodigoError = $row['CodigoError'];
                $item->FechaRegistro = $row['FechaRegistro'];
                $item->Usuario = $row['Usuario'];
                $item->Comentario = $row['Comentario'];

                array_push($items, $item);
            }

            return $items;
        }catch(PDOException $e){
            return [];
        }
    }

    public function RecuperarId($id){
        $item = new EntidadError();

        $query = $this->db->conexion()->prepare("SELECT*FROM errores WHERE Id = :id");
        try{
            $query->execute(['id'=> $id]);

            while($row = $query->fetch()){
                $item->id = $row['Id'];
                $item->CodigoError = $row['CodigoError'];
                $item->FechaRegistro = $row['FechaRegistro'];
                $item->Usuario = $row['Usuario'];
                $item->Comentario = $row['Comentario'];
            }
            return $item;

        }catch(PDOException $e){
            return null;
        }
    }
    public function Actualizar($item){
        $query = $this->db->conexion()->prepare("UPDATE errores SET CodigoError = :CodigoError, FechaRegistro = :FechaRegistro, Usuario = :Usuario, Comentario = :Comentario WHERE Id = :id");
        try{
            $query->execute([
                'id' => $item['id'],
                'CodigoError' => $item['CodigoError'],
                'FechaRegistro' => $item['FechaRegistro'],
                'Usuario' => $item['Usuario'],
                'Comentario' => $item['Comentario']
            ]);
            return true;

        }catch(PDOException $e){
            return false;
        }
    }
    
    public function Eliminar($id){
        $query = $this->db->conexion()->prepare("DELETE FROM errores WHERE Id=:id");
        try{
            $query->execute([
                'id' => $id,
            ]);
            return true;

        }catch(PDOException $e){
            return false;
        }
    }
}
?>