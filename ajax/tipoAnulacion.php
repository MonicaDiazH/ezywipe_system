<?php
require_once "../modelos/TipoAnulacion.php";

$tipoAnulacion = new TipoAnulacion();

$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$tipo_anulacion = isset($_POST["tipo_anulacion"]) ? limpiarCadena($_POST["tipo_anulacion"]) : "";

switch ($_GET['op']) {
    case 'guardaryeditar':
        if (empty($id)) {
            $rspta = $tipoAnulacion->insertar($tipo_anulacion);
            echo $rspta;
        } else {
            $rspta = $tipoAnulacion->editar($id, $tipo_anulacion);
            echo $rspta;
        }
        break;

    case 'eliminar':
        $rspta = $tipoAnulacion->eliminar($id);
        echo $rspta;
        break;

    case 'mostrar':
        $rspta = $tipoAnulacion->mostrar($id);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $tipoAnulacion->listar();
        $data = Array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->tipo_anulacion,
                "1" => '<a onclick="mostrar('.$reg->id.')" data-toggle="tooltip" title="Editar"><i class="fa fa-edit" ></i></a>&nbsp;&nbsp;&nbsp;
                        <a onclick="eliminar('.$reg->id.')" data-toggle="tooltip" title="Eliminar"><i class="fa fa-times"></i></a>'
            );
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data);
        echo json_encode($results);
        break;
}
?>
