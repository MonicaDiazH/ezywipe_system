<?php
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: login.php");
} else {
    require 'header.php';
    if ($_SESSION['CLIENTE'] == 1) {
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Clientes
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

                <div class="box box-danger" id="listadoRegistros">
                    <div class="box-body">
                        <!--CONTENIDO -->
                        <table id="tbllistado" class="table table-bordered table-striped">

                            <thead>
                            <th>Cliente</th>
                            <th>Registro</th>
                            <th>NIT</th>
                            <th>Condición de Pago</th>
                            <th>Contacto</th>
                            <th>Teléfono</th>
                            <th>Opciones</th>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <th>Cliente</th>
                            <th>Registro</th>
                            <th>NIT</th>
                            <th>Condición de Pago</th>
                            <th>Contacto</th>
                            <th>Teléfono</th>
                            <th>Opciones</th>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
                <div id="formularioRegistros">
                    <form name="formulario" id="formulario" method="POST">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">1 - General</h3>
                        </div>
                        <div class="box-body">
                            <!--CONTENIDO -->
                                <input type="hidden" name="id" id="id">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Cliente</label>
                                            <input type="text" class="form-control" name="cliente" id="cliente"
                                                   required>
                                        </div>

                                        <div class="form-group">
                                            <label>Registro</label>
                                            <input type="text" class="form-control" name="registro" id="registro"
                                                   required>
                                        </div>

                                        <div class="form-group">
                                            <label>Tipo Cliente</label>
                                            <select class="form-control selectpicker selectColor"
                                                    data-live-search="true" name="id_tipo_cliente" id="id_tipo_cliente"
                                                    title="Seleccione Tipo Cliente"></select>
                                        </div>

                                        <div class="form-group">
                                            <label>Fecha Ingreso</label>
                                            <input  type="text" class="form-control" name="fecha_ingreso"
                                                   id="fecha_ingreso" value="<?php echo date('m/d/Y')?>" required>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>Giro</label>
                                            <input type="text" class="form-control" name="giro" id="giro" required>
                                        </div>

                                        <div class="form-group">
                                            <label>NIT</label>
                                            <input type="text" class="form-control" name="nit" id="nit" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Condición de Pago</label>
                                            <select class="form-control selectpicker selectColor"
                                                    data-live-search="true" name="id_condicion_pago"
                                                    id="id_condicion_pago"
                                                    title="Seleccione condición de pago"></select>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                    <div class="row">
                        <div class="col-md-6">

                            <!--Contacto Principal-->
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title">2 - Contacto</h3>
                                </div>
                                <div class="box-body">
                                    <!--CONTENIDO -->
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="form-group">
                                                <label>País</label>
                                                <select class="form-control selectpicker selectColor"
                                                        data-live-search="true" name="id_pais" id="id_pais"
                                                        title="Seleccione País"></select>
                                            </div>

                                            <div class="form-group">
                                                <label>Estado/Departamento</label>
                                                <select  class="form-control selectpicker selectColor"
                                                         data-live-search="true" name="id_estado" id="id_estado"
                                                         title="Seleccione Estado"></select>
                                            </div>

                                            <div class="form-group">
                                                <label>Ciudad</label>
                                                <select class="form-control selectpicker selectColor"
                                                        data-live-search="true" name="id_ciudad" id="id_ciudad"
                                                        title="Seleccione Ciudad"></select>
                                            </div>


                                            <div class="form-group">
                                                <label>Dirección</label>
                                                <input type="text" class="form-control" name="direccion"
                                                       id="direccion" required>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>

                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                            <!--/Contacto Principal-->
                        </div>
                        <!-- /.col (left) -->
                        <div class="col-md-6">

                            <!--Ubicación-->
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title">3 - Ubicación</h3>
                                </div>
                                <div class="box-body">
                                    <!--CONTENIDO -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Contacto</label>
                                                <input type="text" class="form-control" name="contacto1" id="contacto1"
                                                       required>
                                            </div>

                                            <div class="form-group">
                                                <label>Correo</label>
                                                <input type="email" class="form-control" name="mail1" id="mail1"
                                                       required>
                                            </div>

                                            <div class="form-group">
                                                <label>Teléfono</label>
                                                <input type="text" class="form-control" name="telefono1"
                                                       id="telefono1" required>
                                            </div>
                                        </div>
                                        <!-- /.col -->

                                        <!-- /.col -->
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary" name="btnGuardar"
                                                    id="btnGuardar">
                                                Guardar
                                            </button>&nbsp;&nbsp;&nbsp;
                                            <a onclick="cancelarForm()">Regresar</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                            <!--/Ubicación-->

                        </div>
                        <!-- /.col (right) -->

                    </div>
                    <!-- /.row -->
                </form>
            </div   >
            <!-- /.id formularioregistro-->


            <div id="detalleRegistros">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">Detalle Cliente</h3>
                        </div>
                        <div class="box-body">
                            <!--CONTENIDO -->
                            <input type="hidden" name="id" id="id">
                            <table id="tbldetalle" class="table ">
                            <tbody>
                            </tbody>
                            </table>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
            </div>
            <!-- /.id detalleregistro-->

            </section>
            <!-- /.content -->

        </div>
        <!-- /.content-wrapper -->

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Documento</h4>
                    </div>
                    <div class="modal-body">
                        <object id="pdfdoc" type="application/pdf" width="100%" height="500px">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div><!--Fin Modal-->

        <?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
    ?>
    <script type="text/javascript" src="scripts/cliente.js"></script>

    <?php
}
ob_end_flush();
?>
