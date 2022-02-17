$(document).ready(function () {
    $('#dataTables').DataTable({
        responsive: true,
        stateSave: true,
        dom: 'T<"clear">lfrtip',
        order: [[0, "asc"]],
        aoColumns: [
            {sClass: "text-left"},
            {sClass: "text-left"},
            {sClass: "text-left"},
            {sClass: "text-left"},
            {sClass: "text-left"},
            {sClass: "text-left"},
            {sClass: "text-left"},
            {sClass: "text-left"},
            {sClass: "text-left"},
            {sClass: "text-left"},
            {sClass: "td-actions text-right"}
        ],
        scrollX: true,
        "processing": true,
        "serverSide": true,
        "ajax": "index.php/?event=100",
        "deferRender": true,
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
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            }
        }
    });
});