<?php
require_once "../modelos/Permiso.php";

$permiso = new Permiso();

$id = isset($_POST['id'])? limpiarCadena($_POST['id']) : "";
$nombre = isset($_POST['nombre'])? limpiarCadena($_POST['nombre']) : "";
$url = isset($_POST['url'])? limpiarCadena($_POST['url']) : "";
$icon = isset($_POST['icono'])? limpiarCadena($_POST['icono']) : "";
$id_pad = isset($_POST['id_padre']) ? limpiarCadena($_POST['id_padre']): "";
$id_padre ='' ;
if($id_pad != ''){$id_padre=$id_pad;}else{$id_padre='null';} 
$icono = 'fa '.$icon;


switch ($_GET['op'])
{
    case 'guardaryeditar':
        if(empty($id))
        {
            $rspta = $permiso->insertar($nombre,$url,$icono,$id_padre);
            echo $rspta;
        }
        else
        {
            $rspta = $permiso->editar($id,$nombre,$url,$icono,$id_padre);
            echo $rspta;
        }
    break;

    case 'eliminar':
        $rspta = $permiso->eliminar($id);
        echo $rspta;
    break;

    case 'mostrar':
        $rspta = $permiso->mostrar($id);
        echo json_encode($rspta);
    break;

    case 'listar':
        $rspta = $permiso->listar();
        $data = array();

        while($reg = $rspta->fetch_object())
        {
            $data[]=array(
                "0"=>$reg->nombre,
                "1"=>$reg->url,
                "2"=>$reg->icono,
                "3"=>'<a onclick="mostrar('.$reg->id.')" data-toggle="tooltip" title="Editar"><i class="fa fa-edit" ></i></a>&nbsp;&nbsp;&nbsp;
                <a onclick="eliminar('.$reg->id.')" data-toggle="tooltip" title="Eliminar"><i class="fa fa-times"></i></a>'
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
            $rspta = $permiso->selectPermiso();
            while ($reg = $rspta->fetch_object())
            {
            echo '<option value=' . $reg->id . '>' . $reg->nombre . '</option>';         
            }
    break;
}


?>