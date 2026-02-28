<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{


require 'header.php';

if ($_SESSION['consultac']==1) {

 ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
<div class="box-header with-border">
  <h1 class="box-title">Consulta de costos</h1>
  <div class="box-tools pull-right">
    <button class="btn btn-success" onclick="listar()">
      Mostrar</button>
  </div>
</div>
<!--box-header-->
<!--centro-->
<div class="panel-body table-responsive" id="listadoregistros">

  <table id="tablacostos" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
      <th>Id</th>
      <th>Producto</th>
      <th>Existencia</th>
      <th>Costo</th>
      <th>Venta</th>
    </thead>
    <tbody>
    </tbody>  
    <tfoot>
            <tr>
                <th colspan="4" style="text-align:right">Total:</th>
                <th></th>
            </tr>
        </tfoot>
  </table>
</div>

<!--fin centro-->
      </div>
      </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
<?php 
}else{
 require 'noacceso.php'; 
}

require 'footer.php';
 ?>
 <script src="scripts/costos.js"></script>
 <?php 
}

ob_end_flush();
  ?>

