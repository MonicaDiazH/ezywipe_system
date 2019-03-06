<?php
session_start();
require_once "../modelos/CCF.php";
include "../public/plugins/numaletras.php";
$convert = new NumberToLetterConverter();

$ccf = new CCF();

$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$fecha1 = isset($_POST["fecha"]) ? limpiarCadena($_POST["fecha"]) : "";
$fecha = date('Y-m-d', strtotime(str_replace('-', '/', $fecha1)));
$referencia = isset($_POST["referencia"]) ? limpiarCadena($_POST["referencia"]) : "";
$total_ajena = isset($_POST["ajena"]) ? limpiarCadena($_POST["ajena"]) : "";
$total_no_sujeta = isset($_POST["no_sujetas"]) ? limpiarCadena($_POST["no_sujetas"]) : "";
$total_exentas = isset($_POST["exentas"]) ? limpiarCadena($_POST["exentas"]) : "";
$total_gravadas = isset($_POST["gravadas"]) ? limpiarCadena($_POST["gravadas"]) : "";
$iva = isset($_POST["iva"]) ? limpiarCadena($_POST["iva"]) : "";
$venta_total = isset($_POST["venta_total"]) ? limpiarCadena($_POST["venta_total"]) : "";
$costo_total = isset($_POST["costo_total"]) ? limpiarCadena($_POST["costo_total"]) : "";
$sub_total = $venta_total;
$total_general = isset($_POST["total_general"]) ? limpiarCadena($_POST["total_general"]) : "";
$correlativo = isset($_POST["correlativo"]) ? limpiarCadena($_POST["correlativo"]) : "";
$id_condicion_pago = isset($_POST["id_condicion_pago"]) ? limpiarCadena($_POST["id_condicion_pago"]) : "";
$id_cliente = isset($_POST["id_cliente"]) ? limpiarCadena($_POST["id_cliente"]) : "";
$id_anulacion = isset($_POST["id_anulacion"]) ? limpiarCadena($_POST["id_anulacion"]) : "";
$comentario = isset($_POST["comentario"]) ? limpiarCadena($_POST["comentario"]) : "";
$id_ccf_anular = isset($_POST["id_ccf_anular"]) ? limpiarCadena($_POST["id_ccf_anular"]) : "";
$id_user = $_SESSION['id_usuario'];
$total_letras = $convert->toWord($total_general, 'USD');

switch ($_GET['op']) {

    case 'nuevo':
        $rspta = $ccf->nuevo();
        $codigo = 'CO-' . str_pad($rspta, 5, "0", STR_PAD_LEFT);
        $data = Array(
            "codigo" => $codigo,
            "id" => $rspta
        );
        echo json_encode($data);
        break;

    case 'guardaryeditar':
        if (empty($id)) {
            $rspta = $ccf->insertar($fecha, $referencia, $total_letras, $total_ajena, $total_no_sujeta,
                $total_exentas, $total_gravadas, $iva, $venta_total, $sub_total, $total_general,
                $costo_total, $correlativo, $id_condicion_pago, $id_cliente, $id_user);
            //echo $rspta ? "Dato ingresado correctamente" : "Dato no se pudo ingresar correctamente";
            echo $rspta;
        } else {
            $rspta = $ccf->editar($id, $fecha, $referencia, $total_letras, $total_ajena, $total_no_sujeta,
                $total_exentas, $total_gravadas, $iva, $venta_total, $sub_total, $total_general,
                $costo_total, $correlativo, $id_condicion_pago, $id_cliente, $id_user);
            //echo $rspta ? "Dato modificado correctamente" : "Dato no se pudo modificar correctamente";
            echo $rspta;
        }
        break;

    case 'eliminar':
        $rspta = $ccf->eliminar($id);
        //echo $rspta ? "Dato eliminado correctamente" : "Dato no se pudo eliminar correctamente";
        echo $rspta;
        break;

    case 'mostrarCCF':
        $rspta = $ccf->mostrarCCF($id);
        $codigo = 'CO-' . str_pad($rspta['id'], 5, "0", STR_PAD_LEFT);
        $data = Array(
            "codigo" => $codigo,
            "id" => $rspta['id'],
            "fecha" => $rspta['fecha'],
            "id_cliente" => $rspta['id_cliente'],
            "referencia" => $rspta['referencia'],
            "id_condicion_pago" => $rspta['id_condicion_pago'],
            "correlativo" => $rspta['correlativo']
        );
        echo json_encode($data);
        break;

    case 'listar':
        $rspta = $ccf->listar();
        $data = Array();
        while ($reg = $rspta->fetch_object()) {
            //CODIGO
            $codigo = $reg->id;
            $codigo = str_pad($codigo, 5, "0", STR_PAD_LEFT);

            //ESTADO
            $estado = $reg->estado;

            if ($estado == 1) {
                $estado_print = "<span class='label label-info'>Proceso</span>";

                $opciones = '
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        Acción
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a onclick="mostrarCCF(' . $reg->id . ')"><i class="fa fa-pencil"></i>Editar</a></li>
                    </ul>
                </div>
                ';

            } else if ($estado == 2) {
                $estado_print = "<span class='label label-warning'>Pendiente</span>";
                $opciones = '
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        Acción
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="../ajax/printProformaCCF.php?id=' . $reg->id . '" target="_blank" ><i class="fa fa-print"></i>Proforma</a></li>
                        <li><a href="../ajax/printCCF.php?id=' . $reg->id . '" target="_blank" ><i class="fa fa-print"></i>CCF</a></li>
                        <li><a  onclick="anular(' . $reg->id . ')" data-toggle="modal" href="#modalAnular"><i class="fa fa-close"></i>Anular</a></li>
                    </ul>
                </div>';
            } else if ($estado == 3) {
                $estado_print = "<span class='label label-success'>Pagada</span>";
                $opciones = '
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        Acción
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a onclick="mostrarPago(' . $reg->id . ')" data-toggle="modal" href="#modalPago"><i class="fa fa-eye"></i>Pagos</a></li>
                    </ul>
                </div>';
            } else if ($estado == 4) {
                $estado_print = "<span class='label label-danger'>Anulada</span>";
                $opciones = '
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        Acción
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a onclick="mostrarAnular(' . $reg->id . ')" data-toggle="modal" href="#modalAnular"><i class="fa fa-eye"></i>Comentario</a></li>
                    </ul>
                </div>';

            } else {
                $estado_print = "Error";
            }

            $data[] = array(
                "0" => 'CO-' . $codigo,
                "1" => $reg->referencia,
                "2" => $reg->fecha,
                "3" => $reg->cliente,
                "4" => $reg->correlativo,
                "5" => $reg->condicion,
                "6" => '$ ' . $reg->total_general,
                "7" => $estado_print,
                "8" => $opciones
            );//onclick="imprimirCCF('.$reg->id.')" || <a onclick="mostrar('.$reg->id.')" data-toggle="tooltip" title="Editar"><i class="fa fa-edit" ></i></a>&nbsp;&nbsp;&nbsp;
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data);
        echo json_encode($results);
        break;

    case "selectCliente":
        require_once "../modelos/Cliente.php";
        $cliente = new Cliente();

        $rspta = $cliente->listar();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->id . '>' . $reg->cliente . '</option>';
        }
        break;

    case "selectCondicionPago":
        require_once "../modelos/CondicionPago.php";
        $condicionPago = new CondicionPago();

        $rspta = $condicionPago->listar();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->id . '>' . $reg->condicion . '</option>';
        }
        break;

    case "selectServicio":
        require_once "../modelos/Servicio.php";
        $servicio = new Servicio();

        $rspta = $servicio->listar();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->id . '>' . $reg->nombre . '</option>';
        }
        break;

    case "selectAnulacion":
        require_once "../modelos/TipoAnulacion.php";
        $tipoAnulacion = new TipoAnulacion();

        $rspta = $tipoAnulacion->listar();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->id . '>' . $reg->tipo_anulacion . '</option>';
        }
        break;

    case 'listarDetalle':
        $id = $_POST['id'];
        require_once "../modelos/DetalleCCF.php";
        $detalleCCF = new DetalleCCF();
        $rspta = $detalleCCF->listar($id);
        $data = Array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->cantidad,
                "1" => $reg->nombre,
                "2" => $reg->descripcion,
                "3" => '$ ' . $reg->unitario,
                "4" => '$ ' . $reg->ajena,
                "5" => '$ ' . $reg->no_sujeta,
                "6" => '$ ' . $reg->exenta,
                "7" => '$ ' . $reg->gravada,
                "8" => '$ ' . $reg->costo,
                "9" => '<a onclick="mostrarDetalle(' . $reg->id . ')" data-toggle="tooltip" title="Editar"><i class="fa fa-edit" ></i></a>&nbsp;&nbsp;&nbsp;
                        <a onclick="eliminarDetalle(' . $reg->id . ')" data-toggle="tooltip" title="Eliminar"><i class="fa fa-close"></i></a>'
            );
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data);
        echo json_encode($results);
        break;

    case 'totalesCCF':
        $rspta = $ccf->totalesCCF($id);
        echo json_encode($rspta);
        break;

    case 'anular':
        $rspta = $ccf->anular($id_ccf_anular, $comentario, $id_anulacion);
        echo json_encode($rspta);
        break;

    case 'mostrarAnular':
        $id = isset($_POST["id_mostrar_anular"]) ? limpiarCadena($_POST["id_mostrar_anular"]) : "";
        $rspta = $ccf->mostrarAnular($id);
        echo json_encode($rspta);
        break;

    case 'ccfImpreso':
        $id = isset($_POST["id_ccf_impreso"]) ? limpiarCadena($_POST["id_ccf_impreso"]) : "";
        $rspta = $ccf->ccfImpreso($id);
        echo json_encode($rspta);
        break;

    case 'mostrarPago':
        require_once "../modelos/PagoCCF.php";
        $pagoccf = new PagoCCF();
        //$id = isset($_POST["id_mostrar_pago"]) ? limpiarCadena($_POST["id_mostrar_pago"]) : "";
        $rspta = $pagoccf->mostrarPago($id);
        echo json_encode($rspta);
        break;

}
?>
