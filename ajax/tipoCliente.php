<?php
require_once "../modelos/TipoCliente.php";

$tipoCliente = new TipoCliente();

$id = isset($_POST['id'])? limpiarCadena($_POST['id']) : "";
$tipo = isset($_POST['tipo'])? limpiarCadena($_POST['tipo']) : "";
$descripcion = isset($_POST['descripcion'])? limpiarCadena($_POST['descripcion']) : "";

switch ($_GET['op'])
{
    case 'guardaryeditar':
        if(empty($id))
        {
            $rspta = $tipoCliente->insertar($tipo,$descripcion);
            echo $rspta;
        }
        else
        {
            $rspta = $tipoCliente->editar($id,$tipo,$descripcion);
            echo $rspta;
        }
        break;

    case 'eliminar':
        $rspta = $tipoCliente->eliminar($id);
        echo $rspta;
        break;

    case 'mostrar':
        $rspta = $tipoCliente->mostrar($id);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $tipoCliente->listar();
        $data = array();

        while($reg = $rspta->fetch_object())
        {
            $data[]=array(
                "0"=>$reg->tipo,
                "1"=>$reg->descripcion,
                "2"=>'<a onclick="mostrar('.$reg->id.')" data-toggle="tooltip" title="Editar"><i class="fa fa-edit" ></i></a>&nbsp;&nbsp;&nbsp;
                <a onclick="eliminar('.$reg->id.')" data-toggle="tooltip" title="Eliminar"><i class="fa fa-times"></i></a>&nbsp;&nbsp;&nbsp;'
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
            echo '<option value=' . $reg->id . '>' . $reg->tipo . '</option>';
        }
        break;

    case 'detallePermiso':
        //Obtenemos los permisos de la tabla permisos según id_padre
        $id = $_POST['permiso'];
        require_once "../modelos/Permiso.php";
        $permiso = new Permiso();
        $rspta = $permiso->detallePermiso($id);

        //Obtenermos los permisos asignados al tipoCliente
        $id_tipoCliente=$_GET['id'];
        $marcados = $tipoCliente->marcadoPermiso($id_tipoCliente, $id);

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
            echo '<option' . $sw . 'value=' . $reg->id . '>' . $reg->tipo . '</option>';
            var_dump($sw);
        }
        break;

    case 'insertarTipoClientePermiso':
        $id_permiso = isset($_POST['slc_permiso'])? limpiarCadena($_POST['slc_permiso']) : "";
        $id_dpermiso = $_POST['slc_dpermiso'];

        var_dump($id_dpermiso);

        $rspta = $tipoCliente->insertTipoClientePermiso($id,$id_permiso);
        echo $rspta;
        break;
}


?>