var tabla;
var tabla_historial;


function init() {
    mostrarForm(false);
    listar();
    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    })

     //Cargamos los items al select forma de pago
     $.post("../ajax/pagoccf.php?op=selectFormaPago", function (r) {
        $("#id_forma_pago").html(r);
        $('#id_forma_pago').selectpicker('refresh');
    })

     //Cargamos los items al select banco
     $.post("../ajax/pagoccf.php?op=selectBanco", function (r) {
        $("#id_banco").html(r);
        $('#id_banco').selectpicker('refresh');
    })

    //Date picker fecha
    $('#fecha').datepicker({
        autoclose: true,
        dateFormat: 'dd.mm.yy',
        defaultDate: new Date()
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
    $("#abono").val("");
    $("#comentario").val("");
    $("#id_banco").val("default").selectpicker("refresh")
    $("#id_forma_pago").val("default").selectpicker("refresh")
}


function mostrarForm(flag) {
    mostrarTotalPendiente();
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
    tabla.ajax.reload();
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
            url: '../ajax/pagoccf.php?op=listar',
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

function listarHistorial(id) {
    tabla_historial = $('#tblhistorial').dataTable({
        'autoWidth': true,
        "aProcessing": true,
        "aServerSide": true,
        "ajax": {
            url: '../ajax/pagoccf.php?op=mostrarPago',
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

function mostrar(id){
    $.post("../ajax/pagoccf.php?op=mostrar", {id: id}, function (data, status) {
        data = JSON.parse(data);
        mostrarForm(true);
        $("#id_ccf").val(data.id);
        $("#codigo").val(data.codigo);
        $("#cliente").val(data.cliente);
        $("#total_factura").val(data.total_general);
        $("#saldo_pendiente").val(data.saldo_pendiente);
       
        listarHistorial(data.id)
    })
}

$("#abono").keyup(function () {
        var value = $(this).val();
        var saldo_p = $("#saldo_pendiente").val();
        var nuevo_saldo = saldo_p - value;
        $("#abono_h").val(value);
        $("#nuevo_saldo").val(nuevo_saldo.toFixed(2));

        
    }); 

function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/pagoccf.php?op=guardaryeditar",
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
            
            tabla_historial.ajax.reload();
            var saldo =  $("#saldo_pendiente").val();
            var abono =  $("#abono_h").val();
            var nuevo_saldo_pendiente = saldo-abono; 
            var id_ccf =  $("#id_ccf").val();
            $("#saldo_pendiente").val(nuevo_saldo_pendiente.toFixed(2));
            if (nuevo_saldo_pendiente == 0)
            {
               $.ajax({
                    url: '../ajax/pagoccf.php?op=actualizarEstado',
                    type: "post",
                    data: {id:id_ccf},
                    dataType: "json",
                    error: function (e) {
                        console.log(e.responseText);
                    }
                })
            }
            mostrarForm(false);
            tabla.ajax.reload();


        }
    });
    limpiar();
}

function mostrarTotalPendiente() {
    $.post("../ajax/pagoccf.php?op=mostrarTotalPendiente", function (data, status) {
        data = JSON.parse(data);
        $('#label_total_pendiente').text(data.saldo_pendiente);
    })
}

init();
