<?php
session_start();
require_once "../modelos/Usuario.php";

$usuario = new Usuario();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$user = isset($_POST["user"])? limpiarCadena($_POST["user"]):"";
$pass = isset($_POST["pass"])? limpiarCadena($_POST["pass"]):"";
$nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$mail = isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$id_perfil = isset($_POST["id_perfil"])? limpiarCadena($_POST["id_perfil"]):"";

switch ($_GET["op"])
{
    case 'guardaryeditar':

        //Hash SHA256 en la contraseña
        $clavehash=hash("SHA256",$pass);

        if (empty($id))
        {
            $rspta=$usuario->insertar($user,$clavehash,$nombre,$mail,$id_perfil);
            echo $rspta;
        }
        else
        {
            $rspta=$usuario->editar($id,$user,$clavehash,$nombre,$mail,$id_perfil);
            echo $rspta;
        }
    break;

    case 'eliminar':
        $rspta=$usuario->eliminar($id);
        echo $rspta;
    break;

    case 'desactivar':
        $rspta=$usuario->desactivar($id);
        echo $rspta;
    break;

    case 'activar':
        $rspta=$usuario->activar($id);
        echo $rspta;
    break;

    case 'mostrar':
        $rspta = $usuario->mostrar($id);
        echo json_encode($rspta);
        //var_dump($rspta);
    break;

    case 'listar':
        $rspta=$usuario->listar();

        $data=Array();

        while($reg=$rspta->fetch_object())
        {
           if($reg->estado!=1)
            {
                $estado="Inactivo";
                $data[]=array(
                    "0"=>$reg->nombre,
                    "1"=>$reg->mail,
                    "2"=>$reg->user,
                    "3"=>$reg->perfil,
                    "4"=>$estado,
                    "5"=>'<div class="btn-group">
                                                <button type="button" class="btn btn-default btn-flat">Acción</button>
                                                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="#" onclick="mostrar('.$reg->id_user.')"><i class="fa fa-pencil"></i>Modificar</a></li>
                                                    <li><a href="#" onclick="activar('.$reg->id_user.')"><i class="fa fa-arrow-down"></i>Activar</a></li>
                                                    <li><a href="#" onclick="eliminar('.$reg->id_user.')"><i class="fa fa-close"></i>Eliminar</a></li>
                                                </ul>
                                            </div>'
                );
            }
            else
            {
                $estado="Activo";
                $data[]=array(
                    "0"=>$reg->nombre,
                    "1"=>$reg->mail,
                    "2"=>$reg->user,
                    "3"=>$reg->perfil,
                    "4"=>$estado,
                    "5"=>'<div class="btn-group">
                                                <button type="button" class="btn btn-default btn-flat">Acción</button>
                                                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="#" onclick="mostrar('.$reg->id_user.')"><i class="fa fa-pencil"></i>Modificar</a></li>
                                                    <li><a href="#" onclick="desactivar('.$reg->id_user.')"><i class="fa fa-arrow-down"></i>Desactivar</a></li>
                                                    <li><a href="#" onclick="eliminar('.$reg->id_user.')"><i class="fa fa-close"></i>Eliminar</a></li>
                                                </ul>
                                            </div>'
                );
            }
        }
        $results = array(
            "sEcho"=>1, //Información para el datatable
            "iTotalRecords"=>count($data), //Se envia el total de registros al datatable
            "iTotalDisplayRecords"=>count($data), //Se envia el total de registros a vizualizar
            "aaData"=>$data
        );

        echo json_encode($results);
    break;

    case "selectPerfil":
        require_once "../modelos/Perfil.php";
        $perfil = new Perfil();

        $rspta = $perfil->listar();

        while ($reg = $rspta->fetch_object())
            {
            echo '<option value=' . $reg->id . '>' . $reg->nombre . '</option>';
            }
    break;

    case 'verificar':
        $username = $_POST['username'];
        $password = $_POST['password'];

        //Hash SHA256 en la contraseña
        $clavehash = hash("SHA256", $password);

        $rspta = $usuario->verificar($username, $clavehash);
        $fetch = $rspta->fetch_object();

        if(isset($fetch))
        {
            //Declaramos variables de sesión
            $_SESSION['id_usuario']=$fetch->id;
            $_SESSION['nombre']=$fetch->nombre;
            $_SESSION['user']=$fetch->user;
            $_SESSION['perfil']=$fetch->perfil;

            //Obtener los permiso del usuario
            $marcados = $usuario->listarmarcados($fetch->id_perfil);

            //Declaramos el array para almacenar todos los permisos marcados
            $valores=array();
        
            while($per=$marcados->fetch_object())
            {   
                array_push($valores, $per->id_permiso);
                
            }

            //Determinamos los accesos del usuario
            $permisos = $usuario->listarpermisos();

            while($reg=$permisos->fetch_object())
            {
                in_array($reg->id,$valores)?$_SESSION[$reg->nombre]=1:$_SESSION[$reg->nombre]=0;    
            }

        }
        echo json_encode($fetch);
    break;

    case 'salir':
        //Limpiar variables de sesión
        session_unset();
        //Desctruimos las sesión
        session_destroy();
        //Redirección al login
        header("Location: ../index.php");
    break;
}


?>
