<?php
require "../config/Conexion.php";

Class Ciudad{
    //Implementamos constructor
    public function __construct(){
    }

    public function insertar($ciudad,$id_estado){
        $sql = "INSERT INTO tb_ciudad (ciudad,id_estado,estado)
    VALUES ('$ciudad','$id_estado', '1')";
        return ejecutarConsulta($sql);
    }

    public function editar($id,$ciudad,$id_estado){
        $sql = "UPDATE tb_ciudad SET ciudad = '$ciudad', id_estado = '$id_estado' WHERE id = $id";
        return ejecutarConsulta($sql);
    }

    public function eliminar($id){
        $sql = "UPDATE tb_ciudad SET estado = 0 WHERE id = $id";
        return ejecutarConsulta($sql);
    }

    public function mostrar($id){
        $sql = "SELECT a.id, a.ciudad, a.id_estado, a.estado, b.nombre_estado, c.id as id_pais, pais 
                FROM tb_ciudad as a 
                INNER JOIN tb_estado as b ON a.id_estado = b.id
                INNER JOIN tb_pais as c ON c.id = b.id_pais 
                WHERE a.id = $id";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listar(){
        $sql = "SELECT a.id, a.ciudad, a.id_estado, a.estado, b.nombre_estado, c.id as id_pais, pais 
                FROM tb_ciudad as a 
                INNER JOIN tb_estado as b ON a.id_estado = b.id
                INNER JOIN tb_pais as c ON c.id = b.id_pais 
                where a.estado = 1";
        return ejecutarConsulta($sql);
    }

    public function selectCiudad($id){
        $sql = "SELECT a.id, a.ciudad, a.id_estado, a.estado, b.estado 
                FROM tb_ciudad as a 
                INNER JOIN tb_estado as b ON a.id_estado = b.id 
                WHERE a.id_estado=$id AND a.estado = 1";
        return ejecutarConsulta($sql);
    }

}

?>
