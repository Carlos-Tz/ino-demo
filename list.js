$(document).ready(function () {
    cargar_tabla();
    
    $("#new").click(function() {
        window.location.href = "index.php?event=1001";
    });  
    $("#export").click(function() {
        window.location.href = "index.php?event=1010&fechaInicio=" + $("#fechaInicio").val() + "&fechaFin=" + $("#fechaFin").val();
    });
});

$(document).on("click","#btn-search",function () {
    cargar_tabla();
});


function cargar_tabla() {
   if($.fn.dataTable.isDataTable("#dataTables-monitoreos")){
        $("#dataTables-monitoreos").DataTable().clear().destroy();
    }
    $('#dataTables-monitoreos').DataTable({
        responsive: true,
        dom: 'T<"clear">lfrtip',
        order: [[1, "desc"]],
        "processing": true,
        "serverSide": false,
        "ajax": "index.php/?event=1000&fechaInicio=" + $("#fechaInicio").val() + "&fechaFin=" + $("#fechaFin").val(),
        "oLanguage": {
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
            "sButtonText": "Imprimir",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            }
        },
    });
}


$(document).on('click', '#guardarRespuesta', function () {
    $.ajax({
        type: "POST",
        data:{respuestaComentario:$('#respuestaComentario').val(), idLectura: $('#idLectura').val() },
        url: 'index.php/?event=1111',
        dataType: 'text',
        beforeSend: function () {
            console.log("Cargando..");
        },
        success: function (response) {
            window.location.href = "index.php?event=001";
            if(response=='XD11') {
                type_alert = 'success';
                swal({
                    title: 'RESPUESTA',
                    text: 'Guardada Correctamente !!',
                    type: type_alert,
                    icon: type_alert,
                    button: false
                });
            }else if(response=='XD21'){
                type_alert = 'warning';
                swal({
                    title: 'RESPUESTA',
                    text: 'No Guardada !!',
                    type: type_alert,
                    icon: type_alert,
                    button: false
                });
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
});

function loadId(id) {
    $("#idLectura").val(id);
}


function loadDetailMonitoreo(id) {
    $("#monitoreoModal").modal("show");
    $.ajax({
        type: "POST",
        url: 'index.php/?event=1011&id_monitoreo=' + id,
        dataType: 'json',
        beforeSend: function () {
            console.log("Cargando..");
        },
        success: function (response) {
            $("#fecha_monitoreo").val(response[0].fecha);
            $("#subrancho").val(response[0].subrancho);
            $("#sector").val(response[0].sector);
            $("#tunel").val(response[0].tunel);
            $("#plantas").val(response[0].plantas);
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
    load_monitoringList(id);
}

function load_monitoringList(id){
    var table = $('#dataTables-lecturasM').DataTable();
    table.destroy();
    $('#dataTables-lecturasM').DataTable({
        responsive: true,
        dom: 'T<"clear">lfrtip',
        order: [[0, "asc"]],
        diffCleanupMerge:'',
        scrollX: true,
        "processing": true,
        "serverSide": false,
        "ajax": "index.php/?event=1101&id_monitoreo=" + id,
        "oLanguage": {
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
            "sButtonText": "Imprimir",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            }
        }
    });

}

$(document).on('click', '.mostrar-fotos', function () {
   let id= $(this).attr('data-idmon');
    $.ajax({
        type: "POST",
        url: 'index.php/?event=10010&id_monitoreo=' + id,
        dataType: 'html',
        beforeSend: function () {
            console.log("Cargando..");
        },
        success: function (response) {
            $("#data_monitoreo_fotos").html(response);
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
});
