<?php
require "../config/Conexion.php";

Class Banco{
    //Implementamos constructor
    public function __construct(){
    }

    public function insertar($banco){
        $sql = "INSERT INTO tb_banco (banco,estado)
    VALUES ('$banco', '1')";
        return ejecutarConsulta($sql);
    }

    public function editar($id,$banco){
        $sql = "UPDATE tb_banco SET banco = '$banco' WHERE id = $id";
        return ejecutarConsulta($sql);
    }

    public function eliminar($id){
        $sql = "UPDATE tb_banco SET estado = 0 WHERE id = $id";
        return ejecutarConsulta($sql);
    }

    public function mostrar($id){
        $sql = "SELECT * FROM tb_banco WHERE id = $id";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listar(){
        $sql = "SELECT * FROM tb_banco WHERE estado = 1";
        return ejecutarConsulta($sql);
    }

}

?>
