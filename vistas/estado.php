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
    if($_SESSION['ESTADO']==1)
    {
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Estados/Departamentos
                    <!--<small>Optional description</small>-->
                </h1>
                <ol class="breadcrumb">
                    <a onClick="mostrarForm(true)" class="btn btn-primary btn-sm" id="btnAgregar">AGREGAR</a>
                    <!--<li class="active"><a href="#"><i class="fa fa-dashboard"></i> Usuarios</a></li>
                    <li class="active">Here</li>-->
                </ol>
            </section>

            <!-- Main content -->
            <section class="content container-fluid">
                <div class="box box-danger">
                    <div class="box-body">
                        <!--CONTENIDO -->
                        <div class="panel-body" id="listadoRegistros">
                            <table id="tbllistado" class="table table-bordered table-striped">
                                <thead>
                                <th>Estado/Departamento</th>
                                <th>País</th>
                                <th>Opciones</th>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <th>Estado/Departamento</th>
                                <th>País</th>
                                <th>Opciones</th>
                                </tfoot>
                            </table>
                        </div>
                        <div class="panel-body" id="formularioRegistros">
                            <form name="formulario" id="formulario" method="POST">
                                <input type="hidden" name="id" id="id">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Estado/Departamento</label>
                                            <input type="text" class="form-control" name="nombre_estado" id="nombre_estado" required>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>País</label>
                                            <select class="form-control selectpicker selectColor" data-live-search="true" name="id_pais" id="id_pais"></select>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <button type="submit" class="btn btn-primary" name="btnGuardar" id="btnGuardar">Guardar</button>&nbsp;&nbsp;&nbsp;
                                <a onclick="cancelarForm()">Regresar</a>
                            </form>
                        </div>
                    </div>
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
    <script type="text/javascript" src="scripts/estado.js"></script>

    <?php
}
ob_end_flush();
?>
