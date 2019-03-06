<?php
require "../config/Conexion.php";

Class Cliente{
    //Implementamos constructor
    public function __construct(){
    }

    public function insertar($cliente, $direccion, $nit, $registro, $giro, $fecha_ingreso, $contacto, $telefono,  $mail, $id_ciudad, $id_condicion_pago, $id_tipo_cliente,$id_user){
        $sql = "INSERT INTO tb_cliente (cliente, direccion, nit, registro, giro, fecha_ingreso, contacto, telefono, mail, id_ciudad, id_condicion_pago, id_user, estado, id_tipo_cliente)
        VALUES ('$cliente', '$direccion', '$nit', '$registro', '$giro', '$fecha_ingreso', '$contacto', '$telefono', '$mail', '$id_ciudad', '$id_condicion_pago', '$id_user', '1',$id_tipo_cliente)";
        //var_dump($sql);
        return ejecutarConsulta($sql);
    }

    public function editar($id,$cliente, $direccion, $nit, $registro, $giro, $fecha_ingreso, $contacto,
                            $telefono, $mail, $id_ciudad, $id_condicion_pago, $id_tipo_cliente,$id_user){
        $sql = "UPDATE tb_cliente SET 
                cliente = '$cliente', 
                direccion = '$direccion', 
                nit = '$nit', 
                registro = '$registro', 
                giro = '$giro', 
                fecha_ingreso = '$fecha_ingreso', 
                contacto = '$contacto',  
                telefono = '$telefono', 
                mail1 = '$mail',  
                id_ciudad = $id_ciudad, 
                id_condicion_pago = '$id_condicion_pago', 
                id_tipo_cliente = '$id_tipo_cliente',
                id_user = $id_user
                WHERE id = $id";
        //var_dump($sql);
        return ejecutarConsulta($sql);
    }

    public function eliminar($id){
        $sql = "UPDATE tb_cliente SET estado = 0 WHERE id = $id";
        return ejecutarConsulta($sql);
    }

    public function mostrar($id){
        $sql = "SELECT a.*, b.ciudad, c.pais, c.id as id_pais, f.nombre_estado, f.id as id_estado,d.condicion, e.nombre, h.tipo as tipo_cliente FROM tb_cliente as a 
                INNER JOIN tb_ciudad as b ON a.id_ciudad = b.id
                INNER JOIN tb_estado as f ON b.id_estado = f.id
                INNER JOIN tb_pais as c ON f.id_pais = c.id
                INNER JOIN tb_condicion_pago as d ON a.id_condicion_pago = d.id
                INNER JOIN tb_user as e ON a.id_user = e.id
                INNER JOIN tb_tipo_cliente as h ON a.id_tipo_cliente = h.id
                WHERE a.id = $id";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listar(){
        $sql = "SELECT a.*, b.ciudad, c.pais, d.condicion, e.nombre, h.tipo as tipo_cliente FROM tb_cliente as a 
                    INNER JOIN tb_ciudad as b ON a.id_ciudad = b.id
                    INNER JOIN tb_estado as f ON b.id_estado = f.id
                    INNER JOIN tb_pais as c ON f.id_pais = c.id
                    INNER JOIN tb_condicion_pago as d ON a.id_condicion_pago = d.id
                    INNER JOIN tb_user as e ON a.id_user = e.id
                    INNER JOIN tb_tipo_cliente as h ON a.id_tipo_cliente = h.id
                    WHERE a.estado = 1";
        return ejecutarConsulta($sql);
    }
}

?>
