var tabla

function init() {
    mostrarForm(false);
    listar();
    $("#formulario").on("submit",function (e) {
        guardaryeditar(e);
    });
    
}

function limpiar() {
    $("#id").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
    
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
            url: '../ajax/perfil.php?op=listar',
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
        url: "../ajax/perfil.php?op=guardaryeditar",
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
    $.post("../ajax/perfil.php?op=mostrar",{id:id}, function(data,status){
        data = JSON.parse(data);
        mostrarForm(true);

        $("#nombre").val(data.nombre);
        $("#descripcion").val(data.descripcion);
        $("#id").val(data.id);
        $("#id_permiso").val(data.id_padre);
        $("#id_permiso").selectpicker('refresh');

    })
}

function eliminar(id) {
    alertify.confirm('Confirmación', '¿Seguro que desea eliminar?', function(){
        $.post("../ajax/perfil.php?op=eliminar",{id:id}, function (e) {
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

function cancelarModal() {
    $('#slc_permiso').val('default').selectpicker("refresh");
    $('#slc_dpermiso').val('default').selectpicker("refresh");
}

function mostrarPermisos(id){
    $.post("../ajax/perfil.php?op=mostrar",{id:id}, function(data,status){
        data = JSON.parse(data);
        
        $("#id_perfil").val(data.id);

    //Cargamos los items al select Permiso
        $.post("../ajax/perfil.php?op=selectPermiso", function(r){
            $("#slc_permiso").html(r);
            $('#slc_permiso').selectpicker('refresh');

        })

        //Cargamos los items al select Detalle Permiso
        $("#slc_permiso").on("change", function(){
            permiso = $(this).val();
            $.post("../ajax/perfil.php?op=detallePermiso&id="+id, {permiso : permiso}, function(r){
                $("#slc_dpermiso").removeAttr("disabled");
                $("#slc_dpermiso").html(r);
                $('#slc_dpermiso').selectpicker('refresh');
            })  
        })
        })
}

function insertarPP(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGModal").prop("disabled", true);
    var formData = new FormData($("#formModal")[0]);
    $.ajax({
        url: "../ajax/perfil.php?op=insertarPerfilPermiso",
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

init();
