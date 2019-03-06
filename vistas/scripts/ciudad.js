var tabla;

function init() {
    mostrarForm(false);
    listar();
    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    })

    //Cargamos los items al select país
    $.post("../ajax/ciudad.php?op=selectPais", function(r){
        $("#id_pais").html(r);
        $('#id_pais').selectpicker('refresh');
    })

    //Cargamos los itemes al select estado/departamento
    $("#id_pais").on("change", function () {
        pais = $("#id_pais").val();
        $.post("../ajax/cliente.php?op=selectEstado", {pais: pais}, function (r) {
            $("#id_estado").html(r);
            $('#id_estado').selectpicker('refresh');
        })
    })
}

function limpiar() {
    $("#id").val("");
    $("#ciudad").val("");
    $("#id_pais").val("default").selectpicker("refresh")
    $("#id_estado").val("default").selectpicker("refresh")
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
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
        },
        "aProcessing": true,
        "aServerSide": true,
        "ajax": {
            url: '../ajax/ciudad.php?op=listar',
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
        url: "../ajax/ciudad.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            if (datos == 1) {
                alertify.success("Guardado correctamente.");
            } else {
                alertify.error("Error al guardar.");
            }
            mostrarForm(false);
            tabla.ajax.reload();
        }
    });
    limpiar();
}

function mostrar(id) {
    $.post("../ajax/ciudad.php?op=mostrar", {id: id}, function (data, status) {
        data = JSON.parse(data);
        mostrarForm(true);
        $("#ciudad").val(data.ciudad);
        //$("#id_pais").val(data.id_pais).trigger('change');
        //$("#id_estado").val(data.id_estado).trigger('change');
        $("#id").val(data.id);

        llenarUbicacion(data.id_pais,data.id_estado);

    })
}

function eliminar(id) {

    alertify.confirm('Confirmación', '¿Seguro que desea eliminar?', function () {
            $.post("../ajax/ciudad.php?op=eliminar", {id: id}, function (e) {
                if (e == 1) {
                    alertify.success("Eliminado correctamente");
                } else {
                    alertify.error("Error al eliminar");
                }
                tabla.ajax.reload();
            });
        }
        , function () {
        });
}

function llenarUbicacion(id_pais,id_estado) {
    $("#id_pais").val(id_pais);
    $("#id_pais").selectpicker('refresh');
    pais = id_pais;
    $.post("../ajax/cliente.php?op=selectEstado", {pais: pais}, function (r) {
        $("#id_estado").html(r);
        $('#id_estado').selectpicker('refresh');
        $("#id_estado").val(id_estado);
        $("#id_estado").selectpicker('refresh');
    })
}

init();
