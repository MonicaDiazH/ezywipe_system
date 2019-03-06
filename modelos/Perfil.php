<?php
require "../config/Conexion.php";

class Perfil
{
    public function __construct(){

    }

    public function insertar($nombre,$descripcion)
    {
        $sql="INSERT INTO tb_perfil (nombre,descripcion,estado)
                VALUES('$nombre','$descripcion',1)";
        return ejecutarConsulta($sql);
    }

    public function editar($id,$nombre,$descripcion)
    {
        $sql ="UPDATE tb_perfil SET nombre='$nombre',descripcion='$descripcion'
                    WHERE id=$id";
        return ejecutarConsulta($sql);
    }

    public function eliminar($id)
    {
        $sql ="UPDATE tb_perfil SET estado=0 WHERE id=$id";
        return ejecutarConsulta($sql);
    }

    public function mostrar($id)
    {
        $sql ="SELECT * FROM tb_perfil WHERE id=$id";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listar()
    {
        $sql ="SELECT * FROM tb_perfil WHERE estado=1";
        return ejecutarConsulta($sql);

    }

    public function marcadoPermiso($id_perfil, $id)
    {
        $sql ="SELECT  a.id as id_permiso
                        ,a.nombre as permiso
                FROM tb_permiso as a
                INNER JOIN tb_perfil_permiso as b ON a.id = b.id_permiso
                INNER JOIN tb_perfil as c ON c.id = b.id_perfil
                WHERE c.id = $id_perfil
                AND a.id_padre=$id";
        var_dump($sql);
        return ejecutarConsulta($sql);

    }

    public function insertPerfilPermiso($id,$id_permiso)
    {
        $sql="INSERT INTO tb_perfil_permiso (id_perfil,id_permiso)
                VALUES($id_perfil, $id_permiso)";
        return ejecutarConsulta($sql);
    }
        
}

?>