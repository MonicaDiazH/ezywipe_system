<?php
ob_start();
session_start();
if(!isset($_SESSION['nombre']))
{
    header("Location: login.php");
}
else
{
    require 'header.php';
    if($_SESSION['Servicios']==1)
    {
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Cuentas por Cobrar
                    <!--<small>Optional description</small>-->
                </h1>
                <ol class="breadcrumb">
                </ol>
            </section>

            <!-- Main content -->
            <section class="content container-fluid">
                <div class="box box-danger">
                    <div class="box-body">
                        <!--CONTENIDO -->
                        <!--Cajas-->
                        <div class="row">
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h3 id="pendiente"></h3>

                                        <p>Cuentas por Cobrar</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-ios-book"></i>
                                    </div>
                                    <a href="../ajax/printReporteCxCGeneral.php" target="_blank" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-green">
                                    <div class="inner">
                                        <h3 id="no_vencido"></h3>

                                        <p>No Vencido</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-checkmark-circled"></i>
                                    </div>
                                    <a href="../ajax/printReporteCxCGeneralNoVencido.php" target="_blank" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-yellow">
                                    <div class="inner">
                                        <h3 id="vencido"></h3>

                                        <p>Vencido</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-close-circled"></i>
                                    </div>
                                    <a href="../ajax/printReporteCxCGeneralVencido.php" target="_blank" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- /.row -->
                        <!--/Cajas-->
                            <table id="tbllistado" class="table table-bordered table-striped">
                                <thead>
                                <th>Cliente</th>
                                <th>Pendiente</th>
                                <th>No Vencido</th>
                                <th>Vencido</th>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <th>Cliente</th>
                                <th>Pendiente</th>
                                <th>No Vencido</th>
                                <th>Vencido</th>
                                </tfoot>
                            </table>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </section>
            <!-- /.content -->

        </div>
        <!-- /.content-wrapper -->

        <?php
    }
    else
    {
        require 'noacceso.php';
    }
    require 'footer.php';
    ?>
    <script type="text/javascript" src="scripts/cxc.js"></script>

    <?php
}
ob_end_flush();
?>
