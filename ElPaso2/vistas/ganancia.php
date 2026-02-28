<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{


require 'header.php';

if ($_SESSION['ventas']==1) {

 ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
<div class="box-header with-border">
  <h1 class="box-title">REPORTE DE GANANCIA &nbsp;&nbsp;&nbsp;&nbsp;
    FECHA INICIO:
    <input type="date" name="FechaInicio" id="FechaInicio">
     FECHA FIN:
    <input type="date" name="FechaFin" id="FechaFin">
    &nbsp;&nbsp;
    <button class="btn btn-success" onclick="listar()"><i class="fa fa-eye"></i> Mostrar</button></h1>
  <div class="box-tools pull-right">
    
  </div>
</div>
<!--box-header-->
<!--centro-->
<div class="panel-body table-responsive" id="listadoregistros">
  <table id="tbllistado2" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
      <th>Factura</th>
      <th>Fecha</th>
	    <th>Cantidad</th>
      <th>nombre</th>
      <th>PrecioCosto</th>
      <th>PrecioVenta</th>
      <th>Ganancia</th>
    </thead>
    <tbody>
    </tbody> 
    <tfoot>
            <tr>
                <th colspan="6" style="text-align:right">Total:</th>
                <th></th>
            </tr>
        </tfoot>
  </table>
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

  <!-- fin Modal-->
<?php 
}else{
 require 'noacceso.php'; 
}

require 'footer.php';
 ?>
 <script src="scripts/ganancia.js"></script>
 <?php 
}

ob_end_flush();
  ?>

