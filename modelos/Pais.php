<?php
require "../config/Conexion.php";

Class Pais{
    //Implementamos constructor
    public function __construct(){
    }

    public function insertar($pais){
        $sql = "INSERT INTO tb_pais (pais,estado)
    VALUES ('$pais', '1')";
        return ejecutarConsulta($sql);
    }

    public function editar($id,$pais){
        $sql = "UPDATE tb_pais SET pais = '$pais' WHERE id = $id";
        return ejecutarConsulta($sql);
    }

    public function eliminar($id){
        $sql = "UPDATE tb_pais SET estado = 0 WHERE id = $id";
        return ejecutarConsulta($sql);
    }

    public function mostrar($id){
        $sql = "SELECT * FROM tb_pais WHERE id = $id";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listar(){
        $sql = "SELECT * FROM tb_pais WHERE estado = 1";
        return ejecutarConsulta($sql);
    }

}

?>
