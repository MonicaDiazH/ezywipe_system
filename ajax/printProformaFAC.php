<?php
require_once '../vendor/autoload.php';
require_once "../modelos/FAC.php";


$fac = new FAC();
$id = isset($_GET["id"]) ? limpiarCadena($_GET["id"]) : "";
$value = $fac->mostrar($id);
//DATOS GENERALES
$cliente = $value['cliente'];
$direccion = $value['direccion'];
$fecha = $value['fecha'];
$nit = $value['nit'];
$registro = $value['registro'];
$giro = $value['giro'];
$letras = $value['total_letras'];
$ajena = $value['total_ajena'];
$sujeta = $value['total_no_sujeta'];
$exentas = $value['total_exentas'];
$gravadas = $value['total_gravadas'];
//$iva = $value['iva'];
$ventatotal = $value['venta_total'];
$subtotal = $value['sub_total'];
$totalgeneral = $value['total_general'];
$municipio = $value['ciudad'];
$departamento = $value['nombre_estado'];
$condicion = $value['condicion'];

$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'default_font_size' => 8,
    'default_font' => 'chelvetica'
]);
//$mpdf = new mPDF('utf-8', '', '8', 'chelvetica');
$mpdf->SetImportUse();

$mpdf->SetDocTemplate('formatoCOMARProformaFAC.pdf', 1); // 1|0 to continue after end of document or not - used on matching page numbers
//===================================================
$mpdf->AddPage();

$n_id = str_pad($id, 5, "0", STR_PAD_LEFT);

//ESTATICO
$mpdf->WriteFixedPosHTML('CO-' . $n_id, 178, 22, 100, 30, 'auto'); //CORRELATIVO
$mpdf->WriteFixedPosHTML($cliente, 24, 46, 100, 30, 'auto'); //CLIENTE
$mpdf->WriteFixedPosHTML($direccion, 29, 53, 100, 30, 'auto'); //DIRECCIÓN
$mpdf->WriteFixedPosHTML($fecha, 146, 46, 100, 30, 'auto'); //FECHA
$mpdf->WriteFixedPosHTML($nit, 142, 53, 100, 30, 'auto'); //NIT
$mpdf->WriteFixedPosHTML($registro, 150, 60.5, 100, 30, 'auto'); //REGISTRO
$mpdf->WriteFixedPosHTML($giro, 143, 68, 60, 30, 'auto'); //GIRO
$mpdf->WriteFixedPosHTML($letras, 23, 176, 60, 30, 'auto'); //CANTIDAD EN LETRAS
$mpdf->WriteFixedPosHTML($condicion, 45, 60.7, 100, 30, 'auto'); //CONDICION

//$ SUMA AJENA
if ($ajena != 0.00) {
    $mpdf->SetXY(43, 161);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY(55, 161);
    $mpdf->Cell(60, 30, number_format($ajena, 2), '', '', 'R');
}

//$ SUMA EXENTAS
if ($exentas != 0.00) {
    $mpdf->SetXY(103, 161);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY(115, 161);
    $mpdf->Cell(60, 30, number_format($exentas, 2), '', '', 'R');
}

//$ SUMA GRAVADAS
if ($gravadas != 0.00) {
    $mpdf->SetXY(127, 161);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY(141, 161);
    $mpdf->Cell(60, 30, number_format($gravadas, 2), '', '', 'R');
}

//$ IVA
/*if ($iva != 0.00) {
    $mpdf->SetXY(127, 168);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY(141, 168);
    $mpdf->Cell(60, 30, number_format($iva, 2), '', '', 'R');
}*/

//$ NO SUJETAS
if ($sujeta != 0.00) {
    $mpdf->SetXY(127, 173);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY(141, 173);
    $mpdf->Cell(60, 30, number_format($sujeta, 2), '', '', 'R');
}

//$ EXENTAS
if ($exentas != 0.00) {
    $mpdf->SetXY(127, 178);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY(141, 178);
    $mpdf->Cell(60, 30, number_format($exentas, 2), '', '', 'R');
}

//$ RETENIDO
if ($retenido != 0.00) {
    $mpdf->SetXY(127, 183);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY(141, 183);
    $mpdf->Cell(60, 30, number_format($retenido, 2), '', '', 'R');
}

//$ VENTA TOTAL
if ($ventatotal != 0.00) {
    $mpdf->SetXY(127, 188);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY(141, 188);
    $mpdf->Cell(60, 30, number_format($ventatotal, 2), '', '', 'R');
}

//$ ajena
if ($ajena != 0.00) {
    $mpdf->SetXY(127, 193);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY(141, 193);
    $mpdf->Cell(60, 30, number_format($ajena, 2), '', '', 'R');
}

//$ adelanto
if ($adelanto != 0.00) {
    $mpdf->SetXY(127, 198);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY(141, 198);
    $mpdf->Cell(60, 30, number_format($adelanto, 2), '', '', 'R');
}

//$ SUB TOTAL
if ($subtotal != 0.00) {
    $mpdf->SetXY(127, 203);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY(141, 203);
    $mpdf->Cell(60, 30, number_format($subtotal, 2), '', '', 'R');
}

//$ TOTAL GENERAL
if ($totalgeneral != 0.00) {
    $mpdf->SetXY(127, 209);
    $mpdf->Cell(60, 30, '$', '', '', 'R');
    $mpdf->SetXY(141, 209);
    $mpdf->Cell(60, 30, number_format($totalgeneral, 2), '', '', 'R');
}

//DINAMICO
$Y = 87;
$Y1 = 74;

$detalle = $fac->listadoDetalle($id);
while ($row = $detalle->fetch_array()){

    $mpdf->WriteFixedPosHTML($row['cantidad'], 20, $Y, 60, 30, 'auto');
    $mpdf->WriteFixedPosHTML($row['nombre'].' '.$row['descripcion'], 27, $Y, 100, 30, 'auto');

//AJENA
    if ($row['ajena'] != 0.00) {
        $mpdf->SetXY(43, $Y1);
        $mpdf->Cell(60, 30, '$', '', '', 'R');
        $mpdf->SetXY(55, $Y1);
        $mpdf->Cell(60, 30, number_format($row['ajena'], 2), '', '', 'R');
    }

//UNITARIO
    if ($row['unitario'] != 0.00) {
        $mpdf->SetXY(66, $Y1);
        $mpdf->Cell(60, 30, '$', '', '', 'R');
        $mpdf->SetXY(78, $Y1);
        $mpdf->Cell(60, 30, number_format($row['unitario'], 2), '', '', 'R');
    }

//NO SUJETAS
    if ($row['no_sujeta'] != 0.00) {
        $mpdf->SetXY(86, $Y1);
        $mpdf->Cell(60, 30, '$', '', '', 'R');
        $mpdf->SetXY(97, $Y1);
        $mpdf->Cell(60, 30, number_format($row['no_sujeta'], 2), '', '', 'R');
    }

//EXENTAS
    if ($row['exenta'] != 0.00) {
        $mpdf->SetXY(103, $Y1);
        $mpdf->Cell(60, 30, '$', '', '', 'R');
        $mpdf->SetXY(115, $Y1);
        $mpdf->Cell(60, 30, number_format($row['exenta'], 2), '', '', 'R');
    }

//GRAVADAS
    if ($row['gravada'] != 0.00) {
        $mpdf->SetXY(127, $Y1);
        $mpdf->Cell(60, 30, '$', '', '', 'R');
        $mpdf->SetXY(141, $Y1);
        $mpdf->Cell(60, 30, number_format($row['gravada'], 2), '', '', 'R');
    }

    $Y = $Y + 5;
    $Y1 = $Y1 + 5;
} // /while

$mpdf->Output();
exit;
