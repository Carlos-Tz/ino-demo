
<?php
include 'view/cabecera.php';
date_default_timezone_set('America/Mexico_City');
?>

<div class="card-body">
    <div class="container-fluid">
        <H1>AQUI VA TU CODIGO</H1>
        <div class="row py-2  px-2" style="background-color: #e3e6ec">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="sub">Fecha Inicio :</label>
                    <input type="date" class="form-control" required name="fechaInicio" id="fechaInicio" value="<?= (empty($_SESSION['concentradoFechaInicio'])) ? date("Y-m-d", strtotime(date('Y-m-d') . "- 28 days")) : $_SESSION['ViajeFechaInicio'] ?>">
                </div>
            </div>
            <div class="col-md-4 ">
                <div class="form-group ">
                    <label for="sub">Fecha Fin:</label>
                    <input type="date" class="form-control" required name="fechaFin" id="fechaFin" value="<?= (empty($_SESSION['concentradoFechaFin'])) ? date("Y-m-d") : $_SESSION['monitoreoFechaFin'] ?>">
                </div>
            </div>
            <div class="col-md-4">
                <button class="btn btn-outline-success btn-block" id="entradas_c">ENTRADAS</button>
                <button class="btn btn-outline-primary btn-block" id="salidas" name="salidas">SALIDAS</button>
            </div>
        </div>

        <?php /* include 'table1.php' */ ?>
        <div class="container mt-5">
            <h2 style="margin-bottom: 30px;">Entradas</h2>
            <table class="table table-striped table-bordered table-hover" id="table1" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>rubro</th>
                        <th>total</th>
                        <!-- <th>productos</th>   -->                      
                    </tr>
                </thead>
            </table>
        </div>
        <div class="container mt-5">
            <h2 style="margin-bottom: 30px;">Modulo Ejecutivo</h2>
            <table class="table table-striped table-bordered table-hover" id="dataTable-entradas" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>cantidad</th>
                        <th>nombre</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div> <!-- card-body -->

<?php include "view/piePagina.php";
/* define('DIR_J','http://inomac.test/'); */
define('DIR_J', 'http://localhost:8080/local/dev/adm/in/');
/*  define('DIR_J','https://pruebas.inomac.mx/ejecutivo'); */
?>
<script type="text/javascript">
    function format ( d ) {
        var tr = '';
        for(const p in d){
            tr += '<tr><td>'+d[p].p+'</td><td>'+d[p].cantidad+'</td><td>$ '+d[p].subtotal+'</td></tr>';
        }
        // `d` is the original data object for the row
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
                    '<tr><td>Producto</td><td>Cantidad</td><td>Subtotal</td></tr>'+
                    tr+
                '</table>';
    }
    $(document).ready(function() {
        /* $('#dataTable-entradas').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'info': false,
            'dom': 'Bfrtip',
            'buttons':[
                'excel'
            ],
            'searching': false,
            'ajax': {
                'url': 'table.php'
            },
            'columns': [
                { data: 'id_prod' },
                { data: 'cantidad' },
                { data: 'nom_prod' },
                { data: 'clasificacion' }
            ]
        }); */
        var table = $('#table1').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'info': false,
            'dom': 'Bfrti',
            /* 'paging': false, */
            /* 'ordering': false, */
            'buttons':[
                'excel'
            ],
            'searching': false,
            'ajax': {
                'url': 'table1.php'
            },
            'columns': [
                {
                    className:      'dt-control',
                    orderable:      false,
                    data:           null,
                    defaultContent: ''
                },
                { data: 'rubro' },
                { data: 'total' },
                /* { data: 'productos' }, */
                /*{ data: 'nom_prod' },
                { data: 'clasificacion' } */
            ]
        });

        $('#table1 tbody').on('click', 'td.dt-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );
    
            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(row.data().productos) ).show();
                tr.addClass('shown');
            }
        });

    });
</script>


<!-- </body>
</html> -->