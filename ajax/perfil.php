<?php
require_once "../modelos/Perfil.php";

$perfil = new Perfil();

$id = isset($_POST['id'])? limpiarCadena($_POST['id']) : "";
$nombre = isset($_POST['nombre'])? limpiarCadena($_POST['nombre']) : "";
$descripcion = isset($_POST['descripcion'])? limpiarCadena($_POST['descripcion']) : "";

switch ($_GET['op'])
{
    case 'guardaryeditar':
        if(empty($id))
        {
            $rspta = $perfil->insertar($nombre,$descripcion);
            echo $rspta;
        }
        else
        {
            $rspta = $perfil->editar($id,$nombre,$descripcion);
            echo $rspta;
        }
    break;

    case 'eliminar':
        $rspta = $perfil->eliminar($id);
        echo $rspta;
    break;

    case 'mostrar':
        $rspta = $perfil->mostrar($id);
        echo json_encode($rspta);
    break;

    case 'listar':
        $rspta = $perfil->listar();
        $data = array();

        while($reg = $rspta->fetch_object())
        {
            $data[]=array(
                "0"=>$reg->nombre,
                "1"=>$reg->descripcion,
                "2"=>'<a onclick="mostrar('.$reg->id.')" data-toggle="tooltip" title="Editar"><i class="fa fa-edit" ></i></a>&nbsp;&nbsp;&nbsp;
                <a onclick="eliminar('.$reg->id.')" data-toggle="tooltip" title="Eliminar"><i class="fa fa-times"></i></a>&nbsp;&nbsp;&nbsp;
                <a onclick="mostrarPermisos('.$reg->id.')" data-toggle="modal" href="#myModal" title="Agregar Permiso"><i class="fa fa-list-ol"></i></a>'
            );
        }
        $results = array(
            "sEcho"=>1,
            "iTotalRecords"=>count($data),
            "iTotalDisplayRecords"=>count($data),
            "aaData"=>$data);
            
        echo json_encode($results);
    break;

    case 'selectPermiso':
        require_once "../modelos/Permiso.php";
        $permiso = new Permiso();

        $rspta = $permiso->selectPermiso();
        while ($reg = $rspta->fetch_object())
            {
            echo '<option value=' . $reg->id . '>' . $reg->nombre . '</option>';         
            }
    break;

    case 'detallePermiso':
        //Obtenemos los permisos de la tabla permisos según id_padre
        $id = $_POST['permiso'];    
        require_once "../modelos/Permiso.php";
        $permiso = new Permiso();
        $rspta = $permiso->detallePermiso($id);

        //Obtenermos los permisos asignados al perfil    
        $id_perfil=$_GET['id'];
        $marcados = $perfil->marcadoPermiso($id_perfil, $id);
        
        //Declaramos el array para almacernar todos los permisos marcados
        $valores=array();
        
        //Almacer los permisos asignados al usuario en el array
        while($per = $marcados->fetch_object())
        {
            array_push($valores, $per->id_permiso);
        }

        //Mostramos la lista de permisos en la vista si estan marcados o no
        while ($reg = $rspta->fetch_object())
        {
            $sw =in_array($reg->id,$valores)?'selected':'';
            echo '<option' . $sw . 'value=' . $reg->id . '>' . $reg->nombre . '</option>';         
            var_dump($sw);
        }
    break;

    case 'insertarPerfilPermiso':
    $id_permiso = isset($_POST['slc_permiso'])? limpiarCadena($_POST['slc_permiso']) : "";
    $id_dpermiso = $_POST['slc_dpermiso'];

    var_dump($id_dpermiso);

            $rspta = $perfil->insertPerfilPermiso($id,$id_permiso);
            echo $rspta;
    break;
}


?>