console.log('ok');
$(document).ready(function () {
    /* alert("ready"); */
    /* cargar_tabla();
    $("#new").click(function () {
        window.location.href = "index.php?event=1001";
    });

    $("#export").click(function () {
        window.location.href = "index.php?event=1010&fechaInicio=" + $("#fechaInicio").val() + "&fechaFin=" + $("#fechaFin").val();
    }); */
});
/* $( "#entradas_c" ).click(function() { */
$(document).on("click", "#entradas_c", function () {
    /* alert('entradas'); */
    if ($.fn.dataTable.isDataTable("#dataTable-entradas")) {
        $("#dataTable-entradas").DataTable().clear().destroy();
    }
    $('#dataTable-entradas').DataTable({
        /* responsive: true,
        dom: 'T<"clear">lfrtip',
        order: [[1, "desc"]],*/
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'ajax': {
            "url" :"table.php",
            /* "dataSrc": "data", */
            "type": "post",
            /* headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, */
            data: function (data) {
                data.meth = 'intros';
                /* data.id = $('#_id').val(); */
                // data.fromValues = $("#filterUserType").serialize();
            },
            success: function(data, textStatus) {
                if (data) {
                    alert(data);
                    /* updateTotalKit(); */
                    /* dataTable2.ajax.reload(); */
                }
            }
            /* error: function(){
                $(".lookup-error").html("");
                $("#lookup").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#lookup_processing").css("display","none");                
            } */
        },
        'columns': [
            { data: 'id_prod' },
            { data: 'cantidad' },
            { data: 'nom_prod' },
            { data: 'clasificacion' }
            /* {data: 'id_prod', name: 'id_prod'},
            {data: 'cantidad', name: 'cantidad'}, */
        ]
        /* "ajax": "index.php/?meth=intros&fechaInicio=" + $("#fechaInicio").val() + "&fechaFin=" + $("#fechaFin").val(),
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
        }, */
    });
});
