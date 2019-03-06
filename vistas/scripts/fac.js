var tabla;
var tabla_detalle;
var tabla_historial;

function init() {
    mostrarForm(false);
    listar();
    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    })

    $("#formularioDetalle").on("submit", function (e) {
        guardaryeditarDetalle(e);
    })

    $("#formularioAnular").on("submit", function (e) {
        anularFAC(e);
    })

    //Date picker fecha
    $('#fecha').datepicker({
        autoclose: true,
        dateFormat: 'dd.mm.yy',
        defaultDate: new Date()
    })

    //Cargamos los items al select cliente
    $.post("../ajax/fac.php?op=selectCliente", function (r) {
        $("#id_cliente").html(r);
        $('#id_cliente').selectpicker('refresh');
    })

    //Cargamos los items al select condición pago
    $.post("../ajax/fac.php?op=selectCondicionPago", function (r) {
        $("#id_condicion_pago").html(r);
        $('#id_condicion_pago').selectpicker('refresh');
    })

    //Cargamos los items al select servicio
    $.post("../ajax/fac.php?op=selectServicio", function (r) {
        $("#id_servicio").html(r);
        $('#id_servicio').selectpicker('refresh');
    })

    //Cargamos los items al select anulacion
    $.post("../ajax/fac.php?op=selectAnulacion", function (r) {
        $("#id_anulacion").html(r);
        $('#id_anulacion').selectpicker('refresh');
    })

    //Multiplica cantidad x precio
    $( "#unitario" ).change(function() {
        totalDetalle();
    });
    $( "#cantidad" ).change(function() {
        totalDetalle();
    });

}

function limpiar() {
    $('#formulario').trigger("reset");
    $("#id_cliente").val("default").selectpicker("refresh");
    $("#id_condicion_pago").val("default").selectpicker("refresh");
}

function mostrarForm(flag) {
    //limpiar();
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

function mostrarFormNuevo(flag) {
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
            url: '../ajax/fac.php?op=listar',
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

function listarDetalle(id) {
    tabla_detalle = $('#tbllistado_detalle').dataTable({
        'autoWidth': true,
        "aProcessing": true,
        "aServerSide": true,
        "ajax": {
            url: '../ajax/fac.php?op=listarDetalle',
            type: "post",
            data: {id: id},
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "bFilter": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bInfo": false,
        "bAutoWidth": false,
        "bDestroy": true,
        "ordering": false
    }).DataTable();
}

function guardaryeditar(e) {
    var id = $("#id").val();
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/fac.php?op=guardaryeditar",
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
            //$("#divAgregarDetalle").hide();
            //$("#btnGuardar").hide();
            $("#btnImpreso").show();
            mostrarForm(true);
            tabla.ajax.reload();
            //window.open('../ajax/printFAC.php?id='+id,'_blank');
            window.open('../ajax/printProformaFAC.php?id='+id,'_blank');
        }
    });
    //limpiar();
}

function guardaryeditarDetalle(e) {

    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#formularioDetalle")[0]);
    $.ajax({
        url: "../ajax/detalleFAC.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            if (datos == 1) {
                alertify.success("Agregado correctamente.");
            } else {
                alertify.error("Error al agregar.");
            }
            mostrarFormNuevo(true);
            cerrarModal();
        }
    });
}

function eliminarDetalle(id) {
    alertify.confirm('Confirmación', '¿Seguro que desea eliminar?', function () {
            $.post("../ajax/detalleFAC.php?op=eliminar", {id: id}, function (e) {
                if (e == 1) {
                    alertify.success("Eliminado correctamente");
                } else {
                    alertify.error("Error al eliminar");
                }
                cerrarModal();
            });
        }
        , function () {
        });
}

function mostrarDetalle(id) {
    $.post("../ajax/detalleFAC.php?op=mostrar", {id: id}, function (data, status) {
        data = JSON.parse(data);
        var gravada = data.gravada;
        var exenta = data.exenta;
        var ajena = data.ajena;
        var no_sujeta = data.no_sujeta;
        $("#descripcion").val(data.descripcion);
        $("#cantidad").val(data.cantidad);
        $("#id_detalle").val(data.id);
        $("#unitario").val(data.unitario);
        $("#costo").val(data.costo);
        $("#id_fac").val(data.id_fac);
        $("#id").val(data.id_fac);
        $("#id_detalle").val(data.id);
        $("#id_servicio").val(data.id_servicio);
        $("#id_servicio").selectpicker('refresh');
        if(gravada > 0){
            $("#total").val(data.gravada);
            $("#tipo").val("1");
        }
        if(ajena>0){
            $("#total").val(data.ajena);
            $("#tipo").val("2");
        }
        if(exenta>0){
            $("#total").val(data.exenta);
            $("#tipo").val("3");
        }
        if(no_sujeta>0){
            $("#total").val(data.no_sujeta);
            $("#tipo").val("4");
        }
        $("#tipo").selectpicker('refresh');
        $("#myModal").modal('show');

    })
}

function nuevo() {
    //$("#btnGuardar").show();
    $("#btnImpreso").hide();
    //$("#divAgregarDetalle").show();
    $.post("../ajax/fac.php?op=nuevo", function (data, status) {
        data = JSON.parse(data);
        $("#codigo").val(data.codigo);
        $("#id").val(data.id);
        $("#id_fac").val(data.id);
        listarDetalle(data.id);
    })
}

function cerrarModal() {
    $("#id_detalle").val("");
    tabla_detalle.ajax.reload();
    $("#myModal").modal('hide');
    $('#formularioDetalle').trigger("reset");
    $("#id_servicio").val("default").selectpicker("refresh")
    $("#tipo").val("default").selectpicker("refresh")
    totalesFAC($("#id").val());
}

function totalesFAC(id) {
    $.post("../ajax/fac.php?op=totalesFAC", {id: id}, function (data, status) {
        var data = JSON.parse(data);
        var gravada  = data.gravada;
        var costo  = data.costo;
        var exenta = data.exenta;
        var no_sujeta = data.no_sujeta;
        var ajena = data.ajena;
        //var iva = gravada * 0.13;
        var ventas = parseFloat(gravada) +parseFloat(exenta)+parseFloat(no_sujeta);
        var total = ventas+parseFloat(ajena);
        //$("#iva").val(iva.toFixed(2));
        $("#gravadas").val(gravada);
        $("#exentas").val(exenta);
        $("#no_sujetas").val(no_sujeta);
        $("#ajena").val(ajena);
        $("#venta_total").val(ventas.toFixed(2));
        $("#total_general").val(total.toFixed(2));
        $("#costo_total").val(costo);

    })
}

function totalDetalle(){
    var unitario = $("#unitario").val();
    var cantidad = $("#cantidad").val();
    var total = unitario * cantidad;
    $("#total").val(total.toFixed(2));
}

/*function imprimirFAC(id) {
    //NO FUNCA :(
    $.ajax({
        type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
        url:"../ajax/printFAC.php", //url guarda la ruta hacia donde se hace la peticion
        data:{id:id}, // data recive un objeto con la informacion que se enviara al servidor
        success:function(response){ //success es una funcion que se utiliza si el servidor retorna informacion
            var w = window.open();
            $(w.document.body).html(response);
        },
        dataType: 'html'
    })
}*/

function anular(id) {
    $("#comentario").prop("disabled", false);
    $("#id_anulacion").prop("disabled", false);
    $("#id_fac_anular").val(id);
    $("#comentario").val("");
    $("#id_anulacion").val("default").selectpicker("refresh")
    $("#div_btn_anular").show();
}

function anularFAC(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnAnular").prop("disabled", false);
    var formData = new FormData($("#formularioAnular")[0]);
    $.ajax({
        url: "../ajax/fac.php?op=anular",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            if (datos) {
                alertify.success("Anulado correctamente.");
            } else {
                alertify.error("Error al anular.");
            }
            $("#modalAnular").modal('hide');
            tabla.ajax.reload();
        }
    });
    //limpiar();
}

function  mostrarAnular(id) {
    $("#comentario").prop("disabled", true);
    $("#id_anulacion").prop("disabled", true);
    $("#div_btn_anular").hide();
    $.post("../ajax/fac.php?op=mostrarAnular", {id_mostrar_anular: id}, function (data, status) {
        var data = JSON.parse(data);
        $("#comentario").val(data.comentario_anulacion);
        $("#id_anulacion").val(data.id_anulacion);
        $("#id_anulacion").selectpicker('refresh');
        //$("#btnAnular").prop("disabled", true);
    })
}

function  facImpreso() {
    var id = $("#id").val();
    //alert(id);
    $.post("../ajax/fac.php?op=facImpreso", {id_fac_impreso: id}, function (e) {
        if (e) {
            alertify.success("Procesado correctamente");
            tabla.ajax.reload();
            mostrarForm(false);
        } else {
            alertify.error("Error al procesar");
        }
    });
}

function mostrarFAC(id) {
    $.post("../ajax/fac.php?op=mostrarFAC", {id: id}, function (data, status) {
        data = JSON.parse(data);
        mostrarForm(true);
        $("#codigo").val(data.codigo);
        $("#referencia").val(data.referencia);
        $("#correlativo").val(data.correlativo);
        $("#id_cliente").val(data.id_cliente);
        $("#id_cliente").selectpicker('refresh');
        $("#id_condicion_pago").val(data.id_condicion_pago);
        $("#id_condicion_pago").selectpicker('refresh');
        $("#id").val(data.id);
        $("#id_fac").val(data.id);
        listarDetalle(data.id);
        totalesFAC(data.id);
    })
}

function mostrarPago(id) {
    tabla_historial = $('#tblMostrarPago').dataTable({
        'autoWidth': true,
        "aProcessing": true,
        "aServerSide": true,
        "ajax": {
            url: '../ajax/pagofac.php?op=mostrarPago',
            type: "post",
            data: {id:id},
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "bFilter":false,
        "bPaginate":false,
        "bLengthChane":false,
        "bInfo":false,
        "ordering":false
    }).DataTable();
}
init();
