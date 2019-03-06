<?php
require "../config/Conexion.php";

class Permiso
{
    public function __construct(){

    }

    public function insertar($nombre,$url,$icono,$id_padre)
    {
        $sql="INSERT INTO tb_permiso (nombre,url,icono,id_padre,estado)
                VALUES('$nombre','$url','$icono',$id_padre,1)";
        return ejecutarConsulta($sql);
    }

    public function editar($id,$nombre,$url,$icono,$id_padre)
    {
        $sql ="UPDATE tb_permiso SET nombre='$nombre',url='$url',icono='$icono', id_padre=$id_padre
                    WHERE id=$id";
        return ejecutarConsulta($sql);
    }

    public function eliminar($id)
    {
        $sql ="UPDATE tb_permiso SET estado=0 WHERE id=$id";
        return ejecutarConsulta($sql);
    }

    public function mostrar($id)
    {
        $sql ="SELECT * FROM tb_permiso WHERE id=$id";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listar()
    {
        $sql ="SELECT * FROM tb_permiso WHERE estado=1 Order by id_padre asc";
        return ejecutarConsulta($sql);

    }
    
    public function selectPermiso()
    {
        $sql ="SELECT * FROM tb_permiso WHERE estado=1 and id_padre IS NULL";
        return ejecutarConsulta($sql);
    }

     
    public function detallePermiso($id)
    {
        $sql ="SELECT * FROM tb_permiso WHERE estado=1 AND id_padre=$id";
        return ejecutarConsulta($sql);
    }

}

?>