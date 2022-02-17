$(document).ready(function () {
    cargar_tabla();
    $("#new").click(function () {
        window.location.href = "index.php?event=1001";
    });

    $("#export").click(function () {
        window.location.href = "index.php?event=1010&fechaInicio=" + $("#fechaInicio").val() + "&fechaFin=" + $("#fechaFin").val();
    });

    function cargar_tabla() {
        if ($.fn.dataTable.isDataTable("#dataTables-monitoreos")) {
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
});