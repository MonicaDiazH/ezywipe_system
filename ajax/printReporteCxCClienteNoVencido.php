<?php

require_once '../vendor/autoload.php';
require_once "../modelos/CXC.php";

function diff_dte($date1, $date2)
{
    if (!is_integer($date1)) {
        $date1 = strtotime($date1);
    }

    if (!is_integer($date2)) {
        $date2 = strtotime($date2);
    }

    return floor(abs($date1 - $date2) / 60 / 60 / 24);
}

$id = isset($_GET["id"]) ? limpiarCadena($_GET["id"]) : "";
$cxc = new CXC();

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'default_font_size' => 10,
    'default_font' => 'verdana',
    'orientation' => 'L',
    'format' => 'Letter'
]);
//$mpdf = new mPDF('utf-8', '', '8', 'chelvetica');
$mpdf->SetImportUse();

$mpdf->SetDocTemplate('formatoCxC.pdf', 1); // 1|0 to continue after end of document or not - used on matching page numbers
//===================================================
$mpdf->AddPage();

/* FECHA Y HORA */
$mpdf->WriteFixedPosHTML(date('m/d/Y g:ia'), 9, 7, 200, 30, 'auto');
$mpdf->WriteFixedPosHTML('Pag. 1', 9, 2, 200, 30, 'auto');

//DINAMICO
$Y = 43;
$Y1 = 30;
$YCL = 36;
$total_debe = 0;
$pag = 1;

$total_cliente_debe = 0;
$total_cliente_nodebe = 0;
$d30 = 0;
$d60 = 0;
$d90 = 0;
$d180 = 0;
$d365 = 0;
$d365_mas = 0;

$idCliente = $id;
$cliente = $cxc -> consultaCliente($idCliente);

$nombrecliente = $cliente['cliente'];
$nombrecliente = strtoupper($nombrecliente);
$mpdf->WriteFixedPosHTML($nombrecliente, 9, $YCL, 200, 30, 'auto');

/* INICIO CCF */
$listadoCCF = $cxc->totalPendienteNoVencidoCCF($idCliente);
while ($listCCF = $listadoCCF->fetch_array()) {
    $hoy = date("Y/m/d");
    $fecha = $listCCF['fecha'];
    $dias = diff_dte($fecha, $hoy);
    $fecha = date('d-m-Y', strtotime(str_replace('-', '/', $fecha)));

    $idCCF = $listCCF['idCCF'];

    //ABONO
    $total_abono = $listCCF['abonos'];
    //TOTAL GENERAL
    $total_general = $listCCF['total_general'];
    //CORRELATIVO
    $correlativo = $listCCF['correlativo'];


    if ($total_abono != 0.00) {
        $mpdf->SetXY(42, $Y1);
        $mpdf->Cell(40, 30, '$', '', '', 'R');
        $mpdf->SetXY(56, $Y1);
        $mpdf->Cell(40, 30, $total_abono, '', '', 'R');
    }

    $debe = $listCCF['saldo_pendiente'];
    $total_debe += $debe;
    $total_cliente_debe += $debe;
    if ($dias <= 30) {
        if ($total_general != 0.00) {
            $mpdf->SetXY(65, $Y1);
            $mpdf->Cell(40, 30, '$', '', '', 'R');
            $mpdf->SetXY(105, $Y1);
            $mpdf->Cell(15, 30, $debe, '', '', 'R');
            $d30 += $debe;
            $d30_total += $debe;
        }
    } else if ($dias <= 60) {
        if ($total_general != 0.00) {
            $mpdf->SetXY(88, $Y1);
            $mpdf->Cell(40, 30, '$', '', '', 'R');
            $mpdf->SetXY(128, $Y1);
            $mpdf->Cell(15, 30, $debe, '', '', 'R');
            $d60 += $debe;
            $d60_total += $debe;
        }
    } else if ($dias <= 90) {
        if ($total_general != 0.00) {
            $mpdf->SetXY(110, $Y1);
            $mpdf->Cell(40, 30, '$', '', '', 'R');
            $mpdf->SetXY(150, $Y1);
            $mpdf->Cell(15, 30, $debe, '', '', 'R');
            $d90 += $debe;
            $d90_total += $debe;
        }
    } else if ($dias <= 180) {
        if ($total_general != 0.00) {
            $mpdf->SetXY(132, $Y1);
            $mpdf->Cell(40, 30, '$', '', '', 'R');
            $mpdf->SetXY(172, $Y1);
            $mpdf->Cell(15, 30, $debe, '', '', 'R');
            $d180 += $debe;
            $d180_total += $debe;
        }
    } else if ($dias <= 365) {
        if ($total_general != 0.00) {
            $mpdf->SetXY(155, $Y1);
            $mpdf->Cell(40, 30, '$', '', '', 'R');
            $mpdf->SetXY(195, $Y1);
            $mpdf->Cell(15, 30, $debe, '', '', 'R');
            $d365 += $debe;
            $d365_total += $debe;
        }
    } else if ($dias > 365) {
        if ($total_general != 0.00) {
            $mpdf->SetXY(182, $Y1);
            $mpdf->Cell(40, 30, '$', '', '', 'R');
            $mpdf->SetXY(222, $Y1);
            $mpdf->Cell(15, 30, $debe, '', '', 'R');
            $d365_mas += $debe;
            $d365_mas_total += $debe;
        }
    }

    if ($correlativo != '') {
        $mpdf->SetXY(10, $Y1);
        $mpdf->Cell(15, 30, 'CCF-' . $correlativo, '', '', 'R');
    }

    //FECHA
    $mpdf->SetXY(9, $Y1);
    $mpdf->Cell(43, 30, $fecha, '', '', 'R');
    //TOTAL
    if ($total_general != 0.00) {
        $mpdf->SetXY(18, $Y1);
        $mpdf->Cell(40, 30, '$', '', '', 'R');
        $mpdf->SetXY(36, $Y1);
        $mpdf->Cell(40, 30, $total_general, '', '', 'R');
    }

    $Y = $Y + 6;
    $Y1 = $Y1 + 6;
    if ($Y1 > 155) {
        $mpdf->AddPage('L');
        $pag++;
        /* FECHA Y HORA */
        $mpdf->WriteFixedPosHTML(date('m/d/Y g:ia'), 9, 7, 200, 30, 'auto');
        $mpdf->WriteFixedPosHTML('Pag.' . $pag, 9, 2, 200, 30, 'auto');
        $Y = 43;
        $Y1 = 30;
        $YCL = 36;
    }
} // /while
/* FIN CCF */

$Y1 += 15;
$YCL = $Y1 + 8;
$total_cliente = $total_cliente_debe + $total_cliente_nodebe;
$total_cliente = number_format($total_cliente, 2, ".", ",");
$fix = $Y1 - 5;
if ($fix == 25) {
    $mpdf->WriteFixedPosHTML('<hr/>', 80, $Y1 - 30, 190, 30, 'auto');
    $mpdf->WriteFixedPosHTML('TOTAL', 81, $Y1 - 1, 190, 30, 'auto');
    //TOTAL GENERAL
    $mpdf->SetXY(208, $Y1 - 13);
    $mpdf->Cell(40, 30, '$', '', '', 'R');
    $mpdf->SetXY(228, $Y1 - 13);
    $mpdf->Cell(40, 30, $total_cliente, '', '', 'R');
    //30 DIAS
    if ($d30 > 0) {
        $d30 = number_format($d30, 2, ".", ",");
        $mpdf->SetXY(65, $Y1 - 13);
        $mpdf->Cell(40, 30, '$', '', '', 'R');
        $mpdf->SetXY(105, $Y1 - 13);
        $mpdf->Cell(15, 30, $d30, '', '', 'R');

    }

    //60 DIAS
    if ($d60 > 0) {
        $d60 = number_format($d60, 2, ".", ",");
        $mpdf->SetXY(88, $Y1 - 13);
        $mpdf->Cell(40, 30, '$', '', '', 'R');
        $mpdf->SetXY(128, $Y1 - 13);
        $mpdf->Cell(15, 30, $d60, '', '', 'R');
    }
    //90 DIAS
    if ($d90 > 0) {
        $d90 = number_format($d90, 2, ".", ",");
        $mpdf->SetXY(110, $Y1 - 13);
        $mpdf->Cell(40, 30, '$', '', '', 'R');
        $mpdf->SetXY(150, $Y1 - 13);
        $mpdf->Cell(15, 30, $d90, '', '', 'R');
    }
    //180 DIAS
    if ($d180 > 0) {
        $d180 = number_format($d180, 2, ".", ",");
        $mpdf->SetXY(132, $Y1 - 13);
        $mpdf->Cell(40, 30, '$', '', '', 'R');
        $mpdf->SetXY(172, $Y1 - 13);
        $mpdf->Cell(15, 30, $d180, '', '', 'R');
    }
    //365 DIAS
    if ($d365 > 0) {
        $d365 = number_format($d365, 2, ".", ",");
        $mpdf->SetXY(155, $Y1 - 13);
        $mpdf->Cell(40, 30, '$', '', '', 'R');
        $mpdf->SetXY(195, $Y1 - 13);
        $mpdf->Cell(15, 30, $d365, '', '', 'R');
    }
    //MAS 365 DIAS
    if ($d365_mas > 0) {
        $d365_mas = number_format($d365_mas, 2, ".", ",");
        $mpdf->SetXY(182, $Y1 - 13);
        $mpdf->Cell(40, 30, '$', '', '', 'R');
        $mpdf->SetXY(222, $Y1 - 13);
        $mpdf->Cell(15, 30, $d365_mas, '', '', 'R');
    }
} else {
    $mpdf->WriteFixedPosHTML('<hr/>', 80, $Y1 - 5, 190, 30, 'auto');
    $mpdf->WriteFixedPosHTML('TOTAL', 81, $Y1 - 1, 190, 30, 'auto');
    //TOTAL GENERAL
    $mpdf->SetXY(208, $Y1 - 13);
    $mpdf->Cell(40, 30, '$', '', '', 'R');
    $mpdf->SetXY(228, $Y1 - 13);
    $mpdf->Cell(40, 30, $total_cliente, '', '', 'R');
    //30 DIAS
    if ($d30 > 0) {
        $d30 = number_format($d30, 2, ".", ",");
        $mpdf->SetXY(65, $Y1 - 13);
        $mpdf->Cell(40, 30, '$', '', '', 'R');
        $mpdf->SetXY(105, $Y1 - 13);
        $mpdf->Cell(15, 30, $d30, '', '', 'R');
    }

    //60 DIAS
    if ($d60 > 0) {
        $d60 = number_format($d60, 2, ".", ",");
        $mpdf->SetXY(88, $Y1 - 13);
        $mpdf->Cell(40, 30, '$', '', '', 'R');
        $mpdf->SetXY(128, $Y1 - 13);
        $mpdf->Cell(15, 30, $d60, '', '', 'R');
    }
    //90 DIAS
    if ($d90 > 0) {
        $d90 = number_format($d90, 2, ".", ",");
        $mpdf->SetXY(110, $Y1 - 13);
        $mpdf->Cell(40, 30, '$', '', '', 'R');
        $mpdf->SetXY(150, $Y1 - 13);
        $mpdf->Cell(15, 30, $d90, '', '', 'R');
    }
    //180 DIAS
    if ($d180 > 0) {
        $d180 = number_format($d180, 2, ".", ",");
        $mpdf->SetXY(132, $Y1 - 13);
        $mpdf->Cell(40, 30, '$', '', '', 'R');
        $mpdf->SetXY(172, $Y1 - 13);
        $mpdf->Cell(15, 30, $d180, '', '', 'R');
    }
    //365 DIAS
    if ($d365 > 0) {
        $d365 = number_format($d365, 2, ".", ",");
        $mpdf->SetXY(155, $Y1 - 13);
        $mpdf->Cell(40, 30, '$', '', '', 'R');
        $mpdf->SetXY(195, $Y1 - 13);
        $mpdf->Cell(15, 30, $d365, '', '', 'R');
    }
    //MAS 365 DIAS
    if ($d365_mas > 0) {
        $d365_mas = number_format($d365_mas, 2, ".", ",");
        $mpdf->SetXY(182, $Y1 - 13);
        $mpdf->Cell(40, 30, '$', '', '', 'R');
        $mpdf->SetXY(222, $Y1 - 13);
        $mpdf->Cell(15, 30, $d365_mas, '', '', 'R');
    }
}
if ($YCL > 155) {
    $mpdf->AddPage('L');
    $pag++;
    /* FECHA Y HORA */
    $mpdf->WriteFixedPosHTML(date('m/d/Y g:ia'), 9, 7, 200, 30, 'auto');
    $mpdf->WriteFixedPosHTML('Pag.' . $pag, 9, 2, 200, 30, 'auto');
    $Y = 43;
    $Y1 = 30;
    $YCL = 36;
}

$mpdf->Output();
exit;
