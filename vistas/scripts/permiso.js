var tabla

function init() {
    mostrarForm(false);
    listar();
    $("#formulario").on("submit",function (e) {
        guardaryeditar(e);
    });
    
    //Cargamos los items al select categoria
    $.post("../ajax/permiso.php?op=selectPermiso", function(r){
        $("#id_padre").html(r);
        $('#id_padre').selectpicker('refresh');

    })

   // iconos();
}

function limpiar() {
    $("#id").val("");
    $("#nombre").val("");
    $("#url").val("");
    $("#icono").val("");
    $('#id_padre').val('default').selectpicker("refresh");
}

function mostrarForm(flag) {
    limpiar();
    if (flag) {
        $("#listadoRegistros").hide();
        $("#formularioRegistros").show();
        $("#btnAgregar").hide();
        $("#btnGuardar").prop("disabled", false);
    } else {
        $("#btnAgregar").show();
        $("#listadoRegistros").show();
        $("#formularioRegistros").hide();
    }
}

function cancelarForm() {
    limpiar();
    mostrarForm(false);
}

function listar() {
    tabla = $('#tbllistado').dataTable({
        'autoWidth': true,
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
        },
        "aProcessing": true,
        "aServerSide": true,
        "ajax": {
            url: '../ajax/permiso.php?op=listar',
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]]
    }).DataTable();
}

function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/permiso.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            if(datos == 1){
                alertify.success("Guardado correctamente.");
            }
            else
            {
                alertify.error("Error al guardar.");
            }
            mostrarForm(false);
            tabla.ajax.reload();
        }
    });
    limpiar();
}

function mostrar(id){
    $.post("../ajax/permiso.php?op=mostrar",{id:id}, function(data,status){
        data = JSON.parse(data);
        mostrarForm(true);

        $("#nombre").val(data.nombre);
        $("#url").val(data.url);
        $("#icono").val(data.icono);
        $("#id").val(data.id);
        $("#id_padre").val(data.id_padre);
        $("#id_padre").selectpicker('refresh');

    })
}

function eliminar(id) {
    alertify.confirm('Confirmación', '¿Seguro que desea eliminar?', function(){
        $.post("../ajax/permiso.php?op=eliminar",{id:id}, function (e) {
            if(e==1){
                alertify.success("Eliminado correctamente");
            }
            else{
                alertify.error("Error al eliminar");
            }
            tabla.ajax.reload();
        } );
        }
        , function(){});
}

function iconos()
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
}

init();
