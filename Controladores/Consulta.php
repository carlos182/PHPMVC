<?php
    class Consulta extends PlantillaControlador{

        function __construct(){
            parent:: __construct();
            $this->PlantillaVista->Errores = [];
        }
        function CrearVista(){
            $Errores = $this->modelo->Recuperar();
            $this->PlantillaVista->Errores = $Errores;
            $this->PlantillaVista->LlamarVista('Consulta/index');
        }

        function VerRegistro($param = null){
            $id = $param[0];
            $Error = $this->modelo->RecuperarId($id);

            session_start();
            $_SESSION['id_Error'] = $Error->id;


            $this->PlantillaVista->EntidadError = $Error;
            $this->PlantillaVista->mensaje = "";
            $this->PlantillaVista->LlamarVista('Consulta/Detalle');

        }

        function ActualizarRegistro(){
            session_start();
            $id = $_SESSION['id_Error'];
            $CodigoError = $_POST['ddlCodigoError'];

            $date_array = getdate();             
            $formated_date  = "";
            $formated_date .= $date_array['mday'] . "/";
            $formated_date .= $date_array['mon'] . "/";
            $formated_date .= $date_array['year'];

            $FechaRegistro = $formated_date;

            $Usuario = $_POST['txtUsuario'];
            $Comentario = $_POST['txtComentario'];

            unset($_SESSION['id_Error']);

            if ($this->modelo->Actualizar(['id' => $id, 'CodigoError' => $CodigoError, 'FechaRegistro' => $FechaRegistro, 'Usuario' => $Usuario, 'Comentario' => $Comentario])){
                $EntidadError = new EntidadError();
                $EntidadError->id = $id;
                $EntidadError->CodigoError = $CodigoError;
                $EntidadError->FechaRegistro = $FechaRegistro;
                $EntidadError->Usuario = $Usuario;
                $EntidadError->Comentario = $Comentario;

                $this->PlantillaVista->EntidadError = $EntidadError;
                $this->PlantillaVista->mensaje = "Registro Actualizado Correctamente";
            }else{
                
                $this->PlantillaVista->mensaje = "No se pudo realizar la actualizacion";
            }
            $this->PlantillaVista->LlamarVista('Consulta/Detalle');
        }

        function EliminarRegistro($param = null){
            $id = $param[0];
            if ($this->modelo->Eliminar($id)){
                $this->PlantillaVista->mensaje = "Registro Eliminado Correctamente";
            }else{
                
                $this->PlantillaVista->mensaje = "No se pudo realizar la Eliminacion";
            }
            $this->CrearVista();

        }
    }
?>