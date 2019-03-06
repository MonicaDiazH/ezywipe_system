<?php
require_once "../modelos/DetalleFAC.php";

$detalleFAC = new DetalleFAC();

$id = isset($_POST["id_detalle"]) ? limpiarCadena($_POST["id_detalle"]) : "";
$id_fac = isset($_POST["id_fac"]) ? limpiarCadena($_POST["id_fac"]) : "";
$id_servicio = isset($_POST["id_servicio"]) ? limpiarCadena($_POST["id_servicio"]) : "";
$tipo = isset($_POST["tipo"]) ? limpiarCadena($_POST["tipo"]) : "";
$costo = isset($_POST["costo"]) ? limpiarCadena($_POST["costo"]) : "";
$cantidad = isset($_POST["cantidad"]) ? limpiarCadena($_POST["cantidad"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";
$total = isset($_POST["total"]) ? limpiarCadena($_POST["total"]) : "";
$unitario = isset($_POST["unitario"]) ? limpiarCadena($_POST["unitario"]) : "";
$gravada = 0;
$exenta = 0;
$no_sujeta = 0;
$ajena = 0;

if($tipo == 1){
    $gravada = $total;
}
elseif($tipo == 2){
    $ajena = $total;
}
elseif($tipo == 3){
    $exenta = $total;
}
elseif($tipo == 4){
    $no_sujeta = $total;
}

switch ($_GET['op']) {
    case 'guardaryeditar':
        if (empty($id)) {
            $rspta = $detalleFAC->insertar($cantidad, $descripcion, $ajena, $unitario, $no_sujeta, $exenta, $gravada, $costo, $id_fac, $id_servicio);
            echo $rspta;
        } else {
            $rspta = $detalleFAC->editar($id, $cantidad, $descripcion, $ajena, $unitario, $no_sujeta, $exenta, $gravada, $costo, $id_servicio);
            echo $rspta;
        }
        break;

    case 'eliminar':
        $id_table_detalle = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
        $rspta = $detalleFAC->eliminar($id_table_detalle);
        echo $rspta;
        break;

    case 'mostrar':
        $id_table_detalle = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
        $rspta = $detalleFAC->mostrar($id_table_detalle);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $detalleFAC->listar();
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
