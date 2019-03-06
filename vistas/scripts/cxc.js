var tabla;

function init() {
    listar();
    mostrarPendiente();
    mostrarNoVencido()
    mostrarVencido()
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
            url: '../ajax/cxc.php?op=listar',
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



function mostrarPendiente() {
    $.post("../ajax/cxc.php?op=mostrarPendiente", function (data, status) {
        data = JSON.parse(data);
        if(data.saldo_pendiente)
        {
            $('#pendiente').text('$ '+data.saldo_pendiente);
        }
        else
        {
            $('#pendiente').text('$ 0.00');
        }
    })
}

function mostrarNoVencido() {
    $.post("../ajax/cxc.php?op=mostrarNoVencido", function (data, status) {
        data = JSON.parse(data);
        if(data.saldo_pendiente)
        {
            $('#no_vencido').text('$ '+data.saldo_pendiente);
        }
        else
        {
            $('#no_vencido').text('$ 0.00');
        }
    })
}

function mostrarVencido() {
    $.post("../ajax/cxc.php?op=mostrarVencido", function (data, status) {
        data = JSON.parse(data);
        if(data.saldo_pendiente)
        {
            $('#vencido').text('$ '+data.saldo_pendiente);

        }
        else
        {
            $('#vencido').text('$ 0.00');
        }
    })
}

init();
