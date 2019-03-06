<?php
require "../config/Conexion.php";

Class TipoPago{
    //Implementamos constructor
    public function __construct(){
    }

    public function insertar($forma_pago){
        $sql = "INSERT INTO tb_tipo_pago (tipo_pago, estado)
    VALUES ('$forma_pago','1')";
        return ejecutarConsulta($sql);
    }

    public function editar($id,$forma_pago){
        $sql = "UPDATE tb_tipo_pago SET tipo_pago = '$forma_pago' WHERE id = $id";
        return ejecutarConsulta($sql);
    }

    public function eliminar($id){
        $sql = "UPDATE tb_tipo_pago SET estado = 0 WHERE id = $id";
        return ejecutarConsulta($sql);
    }

    public function mostrar($id){
        $sql = "SELECT * FROM tb_tipo_pago WHERE id = $id";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listar(){
        $sql = "SELECT * FROM tb_tipo_pago WHERE estado = 1";
        return ejecutarConsulta($sql);
    }
}

?>
