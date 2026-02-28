<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{


require 'header.php';

if ($_SESSION['almacen']==1) {

 ?>
    <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
        <center>
        <div class="box-header with-border">
          <h3 class="box-title">
            Caja sumatoria de ventas del dia 
        </div>
        </center> 
        <center>
          <br>
          SUMA DE VENTAS DEL DIA: <input type="text" name="ventas" id="ventas" disabled="true">
          <hr>
        <div class="container">
          <div class="row-12">
            <div class="col-sm-3">
                <div class="form-group row">&nbsp;&nbsp;&nbsp;
                    <label for="example-email-input" class="col-sm-3 col-form-label">200:</label>
                        <div class="row col-sm-8">
                            <input type="text" name="docientos" id="docientos" autocomplete="false">
                        </div>
                </div>
                <div class="form-group row">&nbsp;&nbsp;&nbsp;
                    <label for="example-email-input" class="col-sm-3 col-form-label">100:</label>
                        <div class="row col-sm-8">
                            <input type="text" name="cien" id="cien" autocomplete="false">
                        </div>
                </div>
                <div class="form-group row">&nbsp;&nbsp;&nbsp;
                    <label for="example-email-input" class="col-sm-3 col-form-label">50:</label>
                        <div class="row col-sm-8">
                            <input type="text" name="cincuenta" id="cincuenta" autocomplete="false">
                        </div>
                </div>
                <div class="form-group row">&nbsp;&nbsp;&nbsp;
                    <label for="example-email-input" class="col-sm-3 col-form-label">20:</label>
                        <div class="row col-sm-8">
                            <input type="text" name="veinte" id="veinte" autocomplete="false">
                        </div>
                </div>
                <div class="form-group row">&nbsp;&nbsp;&nbsp;
                    <label for="example-email-input" class="col-sm-3 col-form-label">10:</label>
                        <div class="row col-sm-8">
                            <input type="text" name="diez" id="diez" autocomplete="false">
                        </div>
                </div>
                <div class="form-group row">&nbsp;&nbsp;&nbsp;
                    <label for="example-email-input" class="col-sm-3 col-form-label">5:</label>
                        <div class="row col-sm-8">
                            <input type="text" name="cinco" id="cinco" autocomplete="false">
                        </div>
                </div>
                <div class="form-group row">&nbsp;&nbsp;&nbsp;
                    <label for="example-email-input" class="col-sm-3 col-form-label">1:</label>
                        <div class="row col-sm-8">
                            <input type="text" name="unob" id="unob" autocomplete="false">
                        </div>
                </div>
            </div>

            <div class="col-sm-3">
              <div class="form-group row">&nbsp;&nbsp;&nbsp;
                  <label for="example-email-input" class="col-sm-3 col-form-label">1:</label>
                  <div class="row col-sm-8">
                      <input type="text" name="uno" id="uno" autocomplete="false">
                  </div>
              </div>
              <div class="form-group row">&nbsp;&nbsp;&nbsp;
                    <label for="example-email-input" class="col-sm-3 col-form-label">0.5:</label>
                        <div class="row col-sm-8">
                            <input type="text" name="cincuentalen" id="cincuentalen" autocomplete="false">
                        </div>
                </div>
                <div class="form-group row">&nbsp;&nbsp;&nbsp;
                    <label for="example-email-input" class="col-sm-3 col-form-label">0.25:</label>
                        <div class="row col-sm-8">
                            <input type="text" name="veinticincolen" id="veinticincolen" autocomplete="false">
                        </div>
                </div>
                <div class="form-group row">&nbsp;&nbsp;&nbsp;
                    <label for="example-email-input" class="col-sm-3 col-form-label">0.10:</label>
                        <div class="row col-sm-5">
                            <input type="text" name="cien" id="diezcentavos" autocomplete="diezcentavos">
                        </div>
                </div>
            </div>
          </div>
        </div>
        <input type="text" name="suma" id="suma" disabled="">
        <button type="button" onclick="Validarventas()" class="btn-success">CERRAR CAJA</button>
       <hr>
        FALTANTE:_ <input type="text" name="VENTASDIA" disabled="" id="VENTASDIA">
      </center>
    </section>


    <!-- /.content -->
  </div>
<?php 
}else{
 require 'noacceso.php'; 
}

require 'footer.php';
 ?>
    <script src="scripts/caja.js"></script> 
 <?php 
}

ob_end_flush();
  ?>

