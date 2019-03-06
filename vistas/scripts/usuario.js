var tabla;

//Función que se ejecuta al inicio
function init()
{
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function(e)
    {
        guardaryeditar(e);
    })

    //Cargamos los items al select categoria
    $.post("../ajax/usuario.php?op=selectPerfil", function(r){
        $("#id_perfil").html(r);
        $('#id_perfil').selectpicker('refresh');
    })

}

//Función limpiar

function limpiar()
{
    $("#nombre").val("");
    $("#email").val("");
    $("#user").val("");
    $("#pass").val("");
    $("#id_perfil").val("");

}

//Función mostrar formulario
function mostrarform(flag)
{
    if(flag)
    {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

//Función cancelarfom
function cancelarform()
{
    limpiar();
    mostrarform(false);
}

//Función Listar
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
            url: '../ajax/usuario.php?op=listar',
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

//Función guardar y editar
function guardaryeditar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
            url: "../ajax/usuario.php?op=guardaryeditar",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function(datos)
            {
              if(datos == 1){
                  alertify.success("Guardado correctamente.");
              }
              else
              {
                  alertify.error("Error al guardar.");
              }
                mostrarform(false);
                tabla.ajax.reload();
            }
    });
    limpiar();
}

//Función mostrar
function mostrar(id)
{
    $.post("../ajax/usuario.php?op=mostrar",
            {id:id},
            function(data)
            {
                data = JSON.parse(data);
                mostrarform(true);

                $("#id").val(data.id);
                $("#nombre").val(data.nombre);
                $("#email").val(data.mail);
                $("#user").val(data.user);
                $("#id_perfil").val(data.id_perfil);
                $("#id_perfil").selectpicker('refresh');
            })
}

//Funcion eliminar registros
function eliminar(id)
{
    alertify.confirm('Confirmación', '¿Seguro que desea eliminar?', function(){
        $.post("../ajax/usuario.php?op=eliminar",{id:id}, function (e) {
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

//Funcion desactivar registros
function desactivar(id)
{
        alertify.confirm('Confirmación','¿Está seguro de desactivar el usuario?',function()
        {

                    $.post("../ajax/usuario.php?op=desactivar", {id:id}, function(e){
                      if(e==1){
                          alertify.success("Desactivado correctamente");
                      }
                      else{
                          alertify.error("Error al desactivar");
                      }
                      tabla.ajax.reload();
                    });

        }, function(){});

}

//Funcion activar registros
function activar(id)
{
    alertify.confirm("Confirmación","¿Está seguro de activar el usuario?", function()
    {
            $.post("../ajax/usuario.php?op=activar", {id:id}, function(e){
                if(e==1){
                    alertify.success("Activado correctamente");
                }
                else{
                    alertify.error("Error al activar");
                }
                tabla.ajax.reload();

            });

    }, function(){});
}

init();
