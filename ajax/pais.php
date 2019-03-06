<?php
require_once "../modelos/Pais.php";

$pais = new Pais();

$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$nombre_pais = isset($_POST["pais"]) ? limpiarCadena($_POST["pais"]) : "";

switch ($_GET['op']) {
    case 'guardaryeditar':
        if (empty($id)) {
            $rspta = $pais->insertar($nombre_pais);
            echo $rspta;
        } else {
            $rspta = $pais->editar($id, $nombre_pais);
            echo $rspta;
        }
        break;

    case 'eliminar':
        $rspta = $pais->eliminar($id);
        echo $rspta;
        break;

    case 'mostrar':
        $rspta = $pais->mostrar($id);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $pais->listar();
        $data = Array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->pais,
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
