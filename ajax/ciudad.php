<?php
require_once "../modelos/Ciudad.php";

$ciudad = new Ciudad();

$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$nombre_ciudad = isset($_POST["ciudad"]) ? limpiarCadena($_POST["ciudad"]) : "";
$id_estado = isset($_POST["id_estado"]) ? limpiarCadena($_POST["id_estado"]) : "";

switch ($_GET['op']) {
    case 'guardaryeditar':
        if (empty($id)) {
            $rspta = $ciudad->insertar($nombre_ciudad,$id_estado);
            echo $rspta;
        } else {
            $rspta = $ciudad->editar($id, $nombre_ciudad,$id_estado);
            echo $rspta;
        }
        break;

    case 'eliminar':
        $rspta = $ciudad->eliminar($id);
        echo $rspta;
        break;

    case 'mostrar':
        $rspta = $ciudad->mostrar($id);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $ciudad->listar();
        $data = Array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->ciudad,
                "1" => $reg->nombre_estado,
                "2" => $reg->pais,
                "3" => '<a onclick="mostrar('.$reg->id.')" data-toggle="tooltip" title="Editar"><i class="fa fa-edit" ></i></a>&nbsp;&nbsp;&nbsp;
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

    case "selectPais":
        require_once "../modelos/Pais.php";
        $pais = new Pais();

        $rspta = $pais->listar();

        while ($reg = $rspta->fetch_object())
        {
            echo '<option value=' . $reg->id . '>' . $reg->pais . '</option>';
        }
        break;    
}
?>
