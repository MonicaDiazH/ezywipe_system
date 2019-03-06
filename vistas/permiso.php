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
if($_SESSION['PERMISOS']==1)
{
?>
<style>    
	    .picker {position:relative;width:100%;margin:0 auto}
	    .inputpicker {width:100%;padding:10px;background:#f2f2f2}
	    .oculto {width:100%;background:#f2f2f2;border-radius:0 0 10px 10px;padding:10px;overflow:auto;max-height:200px;display:none}
		.oculto ul {display:inline;float:left;width:100%;margin:0;padding:0}
		.oculto ul li {margin:0;padding:0;display:block;width:30px;height:30px;text-align:center;font-size:15px;font-family:"fontawesome";float:left;cursor:pointer;color:#666;line-height:30px;transition:0.2s all}
		.oculto ul li:hover {background:#FFF;color:#000}
		.oculto input[type=text] { font-size:13px;padding:5px;margin:0 0 10px 0;border:1px solid #ddd; }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 text-align="left">
            Menú
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
                        <th>Nombre</th>
                        <th>URL</th>
                        <th>Icono</th>
                        <th>Opciones</th>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <th>Nombre</th>
                        <th>URL</th>
                        <th>Icono</th>
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
                                    <label>Permiso</label>
                                    <input type="text" class="form-control" name="nombre" id="nombre" required>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>URL</label>
                                    <input type="text"class="form-control" name="url" id="url" required>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group picker">
                                    <label>Icono</label>
                                    <input id="icono" name="icono" type="text" readonly class="form-control inputpicker" placeholder="Haz click aqu&iacute; para elegir tu icono preferido...">
                                </div>
                            </div>
                            <!-- /.col -->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Dependencia</label>
                                    <select id="id_padre" name="id_padre" class="form-control selectpicker" data-size="10" data-width="100%" data-live-search="true" title="Seleccionar Dependencia"></select>
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
<script type="text/javascript" src="scripts/permiso.js"></script>
<script src="../public/dist/js/icos.js"></script>

<script type="text/javascript">
    $(document).ready(function()
    {
	$(".picker").each(function()
	{
		div=$(this);
		if (icos)
		{
			var iconos="<ul>";
			for (var i=0; i<icos.length; i++) { iconos+="<li><i data-valor='"+icos[i]+"' class='fa "+icos[i]+"'></i></li>"; }
			iconos+="</ul>";
		}
		div.append("<div class='oculto'>"+iconos+"</div>");
		$(".inputpicker").click(function()
		{
			$(".oculto").fadeToggle("fast");
		});
		$(document).on("click",".oculto ul li",function()
		{
			$(".inputpicker").val($(this).find("i").data("valor"));
			$(".oculto").fadeToggle("fast");
		});		
	});
});
</script>

<?php
}
ob_end_flush();
?>