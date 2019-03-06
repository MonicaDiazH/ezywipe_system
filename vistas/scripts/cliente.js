var tabla;

function init() {
    mostrarForm(false);
    listar();
    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    })

    //Cargamos los items al select condicion pago
    $.post("../ajax/cliente.php?op=selectCondicionPago", function (r) {
        $("#id_condicion_pago").html(r);
        $('#id_condicion_pago').selectpicker('refresh');
    })

    //Cargamos los items al select tipo cliente
    $.post("../ajax/cliente.php?op=selectTipoCliente", function (r) {
        $("#id_tipo_cliente").html(r);
        $('#id_tipo_cliente').selectpicker('refresh');
    })

    //Cargamos los items al select pais
    $.post("../ajax/cliente.php?op=selectPais", function (r) {
        $("#id_pais").html(r);
        $('#id_pais').selectpicker('refresh');
    })

    //Cargamos los items al select estado
    //$("#id_pais").trigger('change');
    $("#id_pais").on("change", function () {
        pais = $("#id_pais").val();
        $.post("../ajax/cliente.php?op=selectEstado", {pais: pais}, function (r) {
            $("#id_estado").html(r);
            $('#id_estado').selectpicker('refresh');
        })
    })

    //Cargamos los items al select ciudad
    $("#id_estado").on("change", function () {
        estado = $("#id_estado").val();
        $.post("../ajax/cliente.php?op=selectCiudad", {estado: estado}, function (r) {
            $("#id_ciudad").html(r);
            $('#id_ciudad').selectpicker('refresh');
        })
    })

    //Date picker fecha ingreso
    $('#fecha_ingreso').datepicker({
        autoclose: true,
    })

    //$("#nitmuestra").hide();
    //$("#registromuestra").hide();

}

function limpiar() {
    $("#id").val("");
    $("#cliente").val("");
    $("#registro").val("");
    $("#doc_registro").val("");
    $("#fecha_ingreso").val("");
    $("#giro").val("");
    $("#nit").val("");
    $("#doc_nit").val("");
    $("#contacto1").val("");
    $("#mail1").val("");
    $("#telefono1").val("");
    $("#direccion").val("");
    $("#id_condicion_pago").val("default").selectpicker("refresh");
    $("#id_pais").val("default").selectpicker("refresh");
    $("#id_ciudad").val("default").selectpicker("refresh");
    $("#id_estado").val("default").selectpicker("refresh");
    $("#id_tipo_cliente").val("default").selectpicker("refresh")

}

function mostrarForm(flag) {
    limpiar();
    if (flag) {
        $("#listadoRegistros").hide();
        $("#formularioRegistros").show();
        $("#detalleRegistros").hide();
        $("#btnAgregar").hide();
        $("#btnGuardar").prop("disabled", false);
    } else {
        $("#btnAgregar").show();
        $("#listadoRegistros").show();
        $("#formularioRegistros").hide();
        $("#detalleRegistros").hide();
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
            url: '../ajax/cliente.php?op=listar',
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
        url: "../ajax/cliente.php?op=guardaryeditar",
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
    $.post("../ajax/cliente.php?op=mostrar", {id: id}, function (data, status) {
        data = JSON.parse(data);
        mostrarForm(true);
        $("#id").val(data.id);
        $("#cliente").val(data.cliente);
        $("#registro").val(data.registro);
        $("#fecha_ingreso").val(data.fecha_ingreso);
        $("#giro").val(data.giro);
        $("#nit").val(data.nit);
        $("#contacto1").val(data.contacto);
        $("#mail1").val(data.mail);
        $("#telefono1").val(data.telefono);
        $("#direccion").val(data.direccion);
        $("#id_condicion_pago").val(data.id_condicion_pago).selectpicker('refresh');
        $("#id_tipo_cliente").val(data.id_tipo_cliente).trigger('change');
        $("#id_tipo_cliente").val(data.id_tipo_cliente).selectpicker('refresh');
        $("#nitmuestra").text(data.doc_nit);
        $("#registromuestra").text(data.doc_registro);
        $("#registro_actual").val(data.doc_registro);
        $("#nit_actual").val(data.doc_nit);

        llenarUbicacion(data.id_estado, data.id_pais, data.id_ciudad);
    })
}

function mostrarDetalle(id) {
    $.post("../ajax/cliente.php?op=mostrar", {id: id}, function (data, status) {
        data = JSON.parse(data);
        //mostrarForm(true);
        $("#detalleRegistros").show();
        $("#listadoRegistros").hide();
        $("#formularioRegistros").hide();

        $("#id").val(data.id);
        $('#tbldetalle').append("<tr><td bgcolor='#F9F9F9' colspan='4' align='center'><h4>GENERAL</h4></td></tr>"
            + "<tr>"
            + "<th width='20%'>Cliente:</td>"
            + "<td width='30%'>" + data.cliente + "</td>"
            + "<th width='20%'>Giro:</td>"
            + "<td width='30%'>" + data.giro + "</td>"
            + "</tr>"
            + "<tr>"
            + "<th width='20%'>Registro:</td>"
            + "<td width='30%'>" + data.registro + "</td>"
            + "<th width='20%'>NIT:</td>"
            + "<td width='30%'>" + data.nit + "</td>"
            + "</tr>"
            + "<tr><td bgcolor='#F9F9F9' colspan='2' align='center'><h4>CONTACTO PRINCIPAL</h4></td><td bgcolor='#F9F9F9' colspan='2'align='center'><h4>UBICACIÓN</h4></td></tr>"
            + "<tr>"
            + "<th width='20%'>Contacto Principal:</td>"
            + "<td width='30%'>" + data.contacto + "</td>"
            + "<th width='20%'>País:</td>"
            + "<td width='30%'>" + data.pais + "</td>"
            + "</tr>"
            + "<tr>"
            + "<th width='20%'>Correo Principal:</td>"
            + "<td width='30%'>" + data.mail + "</td>"
            + "<th width='20%'>Estado/Departamento:</td>"
            + "<td width='30%'>" + data.nombre_estado + "</td>"
            + "</tr>"
            + "<tr>"
            + "<th width='20%'>Teléfono Principal:</td>"
            + "<td width='30%'>" + data.telefono + "</td>"
            + "<th width='20%'>Ciudad:</td>"
            + "<td width='30%'>" + data.ciudad + "</td>"
            + "</tr>"
            + "<tr>"
            + "<th width='20%'></td>"
            + "<td width='30%'></td>"
            + "<th width='20%'>Dirección:</td>"
            + "<td width='30%'>" + data.direccion + "</td>"
            + "</tr>"
            + "<tr>"
            + "<th width='20%'><a onclick=\"cancelarForm()\">Regresar</a></td>"
            + "<td width='30%'></td>"
            + "<th width='20%'></td>"
            + "<td width='30%'></td>"
            + "</tr>");
    })
}

function eliminar(id) {

    alertify.confirm('Confirmación', '¿Seguro que desea eliminar?', function () {
            $.post("../ajax/cliente.php?op=eliminar", {id: id}, function (e) {
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

function llenarUbicacion(id_estado, id_pais, id_ciudad) {
    $("#id_pais").val(id_pais);
    $("#id_pais").selectpicker('refresh');
    pais = id_pais;
    $.post("../ajax/cliente.php?op=selectEstado", {pais: pais}, function (r) {
        $("#id_estado").html(r);
        $('#id_estado').selectpicker('refresh');
        $("#id_estado").val(id_estado);
        $("#id_estado").selectpicker('refresh');
        estado = id_estado;
        $.post("../ajax/cliente.php?op=selectCiudad", {estado: estado}, function (r) {
            $("#id_ciudad").html(r);
            $('#id_ciudad').selectpicker('refresh');
            $("#id_ciudad").val(id_ciudad);
            $("#id_ciudad").selectpicker('refresh');
        })
    })
}

init();
