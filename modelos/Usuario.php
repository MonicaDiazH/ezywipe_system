<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

    class Usuario
    {

        //Implementamos nuestro constructor
        public function __construct()
        {

        }

        //Implementamos un método para insertar registros
        public function insertar($user,$pass,$nombre,$mail,$id_perfil)
        {
            $sql="INSERT INTO tb_user (
                                            user
                                            ,pass
                                            ,nombre
                                            ,mail
                                            ,id_perfil
                                            ,estado

                                          )
                                VALUES(
                                        '$user'
                                        ,'$pass'
                                        ,'$nombre'
                                        ,'$mail'
                                        ,$id_perfil
                                        ,1
                                )";
            //var_dump($sql);
            return ejecutarConsulta($sql);
        }

        //Implementamos método para editar
        public function editar($id,$user,$pass,$nombre,$mail,$id_perfil)
        {
            $sql = "UPDATE tb_user SET user =  '$user'
                                        ,pass = '$pass'
                                        ,nombre = '$nombre'
                                        ,mail = '$mail'
                                        ,id_perfil = $id_perfil
                                WHERE id = $id";

            return ejecutarConsulta($sql);
        }

         //Implementamos el método para desactivar criterios
        public function eliminar($id)
        {
            $sql = "UPDATE tb_user SET estado=0 WHERE id = $id";
            return ejecutarConsulta($sql);
        }

        //Implementamos un método para descativar usuario
        public function desactivar($id)
        {
            $sql="UPDATE tb_user SET estado='2' WHERE id=$id";
            return ejecutarConsulta($sql);
        }

        //Implementamos un método para activar usuario
        public function activar($id)
        {
            $sql="UPDATE tb_user SET estado='1' WHERE id=$id";
            return ejecutarConsulta($sql);
        }

        //Implimentar método para mostrar los datos de un registro a modificar
        public function mostrar($id)
        {
            $sql = "SELECT * FROM tb_user WHERE id = $id";
            return ejecutarConsultaSimpleFila($sql);
        }

        //Implementar método para listar registros
        public function listar()
        {
            $sql = "SELECT  a.id as id_user
                            ,user
                            ,a.nombre as nombre
                            ,mail
                            ,b.id
                            ,b.nombre as perfil
                            ,a.estado as estado
                    FROM tb_user as a
                    INNER JOIN tb_perfil as b ON b.id=a.id_perfil
                    WHERE a.estado !=0";
            return ejecutarConsulta($sql);
        }

        //Implementar un método para listar los permisos marcados
        public function listarmarcados($id_perfil)
        {
            $sql ="SELECT  a.id as id_permiso
                            ,a.nombre as permiso
                            ,c.id as id_perfil
                            ,c.nombre as perfil
                    FROM tb_permiso as a
                    INNER JOIN tb_perfil_permiso as b ON a.id = b.id_permiso
                    INNER JOIN tb_perfil as c ON c.id = b.id_perfil
                    WHERE c.id = $id_perfil";
            return ejecutarConsulta($sql);
        }

         //Implementar un método para listar los permisos marcados
        public function listarpermisos()
        {
            $sql ="SELECT * FROM tb_permiso WHERE estado =1";
            return ejecutarConsulta($sql);
        }

        //Función para verificar acceso al sistema
        public function verificar($username,$clavehash)
        {
            $sql = "SELECT a.id as id
                            ,user
                            ,pass
                            ,a.nombre as nombre
                            ,mail
                            ,id_perfil
                            ,b.nombre as perfil
                    FROM tb_user as a
                    INNER JOIN tb_perfil as b ON b.id = a.id_perfil
                    WHERE user='$username'
                    AND pass='$clavehash'
                    AND a.estado=1";

            return ejecutarConsulta($sql);
        }

        public function menu()
        {
            $sql ="SELECT * FROM tb_permiso WHERE estado =1 order by orden asc";
            return ejecutarConsulta($sql);
        }

        public function submenu($id_padre)
        {
            $sql ="SELECT * FROM tb_permiso WHERE estado =1 AND id_padre=$id_padre order by orden asc";
            return ejecutarConsulta($sql);
        }
    }

?>
