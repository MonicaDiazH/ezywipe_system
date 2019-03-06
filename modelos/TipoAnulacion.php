<?php
require "../config/Conexion.php";

Class TipoAnulacion{
    //Implementamos constructor
    public function __construct(){
    }

    public function insertar($tipo_anulacion){
        $sql = "INSERT INTO tb_tipo_anulacion (tipo_anulacion,estado)
    VALUES ('$tipo_anulacion', '1')";
        return ejecutarConsulta($sql);
    }

    public function editar($id,$tipo_anulacion){
        $sql = "UPDATE tb_tipo_anulacion SET tipo_anulacion = '$tipo_anulacion' WHERE id = $id";
        return ejecutarConsulta($sql);
    }

    public function eliminar($id){
        $sql = "UPDATE tb_tipo_anulacion SET estado = 0 WHERE id = $id";
        return ejecutarConsulta($sql);
    }

    public function mostrar($id){
        $sql = "SELECT * FROM tb_tipo_anulacion WHERE id = $id";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listar(){
        $sql = "SELECT * FROM tb_tipo_anulacion WHERE estado = 1";
        return ejecutarConsulta($sql);
    }

}

?>
