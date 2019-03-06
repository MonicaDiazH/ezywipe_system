<?php
require "../config/Conexion.php";

Class TipoCliente{
    //Implementamos constructor
    public function __construct(){
    }

    public function insertar($tipo_tipo_cliente, $descripcion){
        $sql = "INSERT INTO tb_tipo_cliente (tipo, descripcion,estado)
    VALUES ('$tipo_tipo_cliente','$descripcion', '1')";
        return ejecutarConsulta($sql);
    }

    public function editar($id,$tipo_tipo_cliente){
        $sql = "UPDATE tb_tipo_cliente SET tipo = '$tipo_tipo_cliente', descripcion = '$descripcion' WHERE id = $id";
        return ejecutarConsulta($sql);
    }

    public function eliminar($id){
        $sql = "UPDATE tb_tipo_cliente SET estado = 0 WHERE id = $id";
        return ejecutarConsulta($sql);
    }

    public function mostrar($id){
        $sql = "SELECT * FROM tb_tipo_cliente WHERE id = $id";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listar(){
        $sql = "SELECT * FROM tb_tipo_cliente WHERE estado = 1";
        return ejecutarConsulta($sql);
    }

}

?>
