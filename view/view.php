<?php include 'cabecera.php';  ?>

<div class="card-header-actions">
    <h2 class="card-header bg-cyan-soft text-black">
        Módulo Ejecutivo

    </h2>
</div>
<div class="card-body">
    <div class="container-fluid">
        <H1>AQUI VA TU CODIGO</H1>
        <?php
        foreach ($rubros as $k => $va) :
            echo  $k . '===>' . $va . '<br>';
            $rub[$k] = array_filter($data[0], function ($key) use ($va) {
                return strtolower($key['clasificacion']) == $va;
            });
            $tot[$k] = 0;
            foreach ($rub[$k] as $j => $v) :
                $tot[$k] += $v['precio_compra'];
            /*print_r($v['precio_compra']); echo '<br>';*/
            endforeach;
        endforeach;
        print_r($rub['inocuidad']);
        echo '<br><br>';
        print_r($tot['inocuidad']);

        /* foreach ($rubros as $k => $va ): 
                echo  $k .'===>'.$va . '<br>';
	        endforeach; */

        /* print_r($rubros); */

        /* print_r($data[0]); */
        /* foreach ($data[0] as $key => $value)
    			foreach ($value as $va ): 
                    print_r($value);
			    endforeach; */

        /* var_dump(array_filter($data[0], function ($key) {
                return strtolower($key['clasificacion']) == 'vehiculos';
            })); */

        /* $name = "DISPOSICIONES DE EFECTIVO";
            var_dump(array_filter($data[0], function($v) use ($name) {
                return ($v['nom_prod'] == $name);
            })); */

        /* var_dump($rubros); */
        ?>

        <div class="dataTable_wrapper table-responsive custom-scrollbar">
            <div id="message"></div>
            <table class="table table-striped table-bordered table-hover" id="dataTables-monitoreos" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Responsable</th>
                        <th>Subrancho</th>
                        <th>Sector</th>
                        <th>Túnel</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>
</div> <!-- card-body -->

<?php /* include "piePagina.php"; */ ?>
<!--- ZONA PARA INCLUIR TUS JS -->

<script src="./js/app.js"></script>