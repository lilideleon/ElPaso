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
<!-- Google Fonts: Roboto -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

<style>
  /* ===== MATERIAL DESIGN – VENTAS ===== */
  .content-wrapper { background: #f0f4f8 !important; font-family: 'Roboto', sans-serif; }

  /* --- Toolbar --- */
  .md-toolbar {
    background: linear-gradient(90deg, #5a89ee 0%, #26a69a 100%);
    border-radius: 10px;
    padding: 16px 24px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    box-shadow: 0 4px 12px rgba(0,150,136,.28);
  }
  .md-toolbar h1 { margin:0; font-size:1.4rem; font-weight:500; color:#fff; letter-spacing:.02em; }
  .md-toolbar-actions { display:flex; gap:10px; flex-wrap:wrap; }

  /* --- Botones Material --- */
  .md-btn {
    display: inline-flex; align-items: center; gap: 7px;
    border: none; border-radius: 6px; padding: 9px 20px;
    font-family: 'Roboto', sans-serif; font-size: .92rem; font-weight: 500;
    letter-spacing: .04em; cursor: pointer; text-decoration: none;
    transition: box-shadow .2s, transform .15s, background .2s;
    box-shadow: 0 2px 6px rgba(0,0,0,.18);
  }
  .md-btn:hover { transform:translateY(-1px); box-shadow:0 5px 14px rgba(0,0,0,.22); text-decoration:none; }
  .md-btn:active { transform:translateY(0); box-shadow:0 1px 4px rgba(0,0,0,.18); }
  .md-btn-primary  { background:#1976d2; color:#fff; }
  .md-btn-primary:hover  { background:#1565c0; color:#fff; }
  .md-btn-success  { background:#43a047; color:#fff; }
  .md-btn-success:hover  { background:#388e3c; color:#fff; }
  .md-btn-danger   { background:#e53935; color:#fff; }
  .md-btn-danger:hover   { background:#c62828; color:#fff; }
  .md-btn-outlined { background:#fff; color:#1976d2; border:1.5px solid #1976d2; box-shadow:none; }
  .md-btn-outlined:hover { background:#e3f0ff; color:#1565c0; }

  /* Variantes Material (teal / purple) */
  .md-btn-teal { background:#009688; color:#fff; }
  .md-btn-teal:hover { background:#00897b; color:#fff; }
  .md-btn-purple { background:#673ab7; color:#fff; }
  .md-btn-purple:hover { background:#5e35b1; color:#fff; }

  /* --- Cards --- */
  .md-card {
    background: #fff; border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,.09), 0 1px 2px rgba(0,0,0,.06);
    overflow: hidden; margin-bottom: 24px;
  }
  .md-card-content { padding: 20px 24px 24px; }

  /* --- Encabezado de sección dentro de card --- */
  .md-section-title {
    font-size: 1.05rem; font-weight: 500; color: #009688;
    padding: 16px 24px 14px; border-bottom: 2px solid #e0f2f1;
    display: flex; align-items: center; gap: 10px; margin-bottom: 4px;
  }
  .md-section-title i { color: #26a69a; }

  /* --- Sub-sección comprobante --- */
  .md-subsection {
    background: #f3e5f5; border-left: 4px solid #ffffff;
    border-radius: 0 8px 8px 0; padding: 14px 18px; margin-bottom: 20px;
  }
  .md-subsection-label {
    font-size: .75rem; font-weight: 700; color: #5e35b1;
    text-transform: uppercase; letter-spacing: .07em; margin-bottom: 10px;
  }

  /* --- Inputs Material outlined --- */
  .md-field { position: relative; margin-bottom: 8px; }
  .md-field label {
    display: block; font-size: .8rem; font-weight: 500;
    color: #009688; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 5px;
  }
  .md-field .form-control,
  .md-field select.form-control {
    border: none !important; border-bottom: 2px solid #b0bec5 !important;
    border-radius: 0 !important; box-shadow: none !important;
    background: #f7fdf7 !important; padding: 8px 10px !important;
    font-size: 1rem; color: #212121;
    transition: border-color .25s; height: auto !important;
  }
  .md-field .form-control:focus,
  .md-field select.form-control:focus {
    border-bottom-color: #009688 !important;
    background: #fff !important; outline: none; box-shadow: none !important;
  }

  /* --- Tabla listado principal --- */
  #tbllistado thead th {
    background: #5997f5 !important; color: #fff !important;
    font-weight: 500; font-size: .93rem;
    border: none !important; padding: 12px 14px !important;
  }
  #tbllistado tbody tr { transition: background .15s; }
  #tbllistado tbody tr:hover { background: #e0f2f1 !important; }
  #tbllistado tbody td { padding: 10px 14px !important; vertical-align: middle !important; font-size: .92rem; }

  /* --- Tabla de detalles de venta --- */
  #detalles thead th {
    background: #1976d2 !important; color: #fff !important;
    font-weight: 500; padding: 11px 12px !important;
    border: none !important; font-size: .9rem;
  }
  #detalles tfoot th {
    background: #e0f2f1; color: #009688;
    font-weight: 700; font-size: 1rem; padding: 10px 12px !important;
  }
  #detalles tbody tr:hover { background: #e3f0ff !important; }
  #detalles tbody td { padding: 9px 12px !important; vertical-align: middle !important; }
  #detalles { border-radius: 8px; overflow: hidden; }
  #total { color: #009688; font-weight: 700; margin: 0; }

  /* --- Divider --- */
  .md-divider { height:1px; background:#e8eaf6; margin:20px 0; }

  /* --- Form actions --- */
  .md-form-actions { display:flex; gap:12px; padding:0 0 8px; flex-wrap:wrap; }

  /* --- Modal Material --- */
  #myModal .modal-content { border-radius: 12px; border: none; box-shadow: 0 12px 40px rgba(0,0,0,.22); overflow: hidden; }
  #myModal .modal-header {
    background: linear-gradient(90deg, #673ab7 0%, #ffffff 100%);
    border: none; padding: 16px 24px;
  }
  #myModal .modal-title { color: #fff !important; font-size: 1.1rem; font-weight: 500; font-family: 'Roboto', sans-serif; }
  #myModal .modal-header .close { color: #fff; opacity: .8; font-size: 1.4rem; }
  #myModal .modal-header .close:hover { opacity: 1; }
  #myModal .modal-body { padding: 20px 24px; }
  #myModal .modal-footer { border-top: 1px solid #e8eaf6; padding: 12px 24px; }
  #tblarticulos thead th {
    background: #1976d2 !important; color: #fff !important;
    font-weight: 500; padding: 11px 12px !important; border: none !important;
  }
  #tblarticulos tbody tr:hover { background: #e3f0ff !important; }

  #modalDetalleVenta { z-index: 10500 !important; }
  #modalDetalleVenta .modal-content { border-radius: 12px; border: none; box-shadow: 0 12px 40px rgba(0,0,0,.22); overflow: hidden; }
  #modalDetalleVenta .modal-header {
    background: linear-gradient(90deg, #5a89ee 0%, #26a69a 100%);
    border: none; padding: 16px 24px;
  }
  #modalDetalleVenta .modal-title { color: #fff !important; font-size: 1.1rem; font-weight: 500; font-family: 'Roboto', sans-serif; }
  #modalDetalleVenta .modal-header .close { color: #fff; opacity: .8; font-size: 1.4rem; }
  #modalDetalleVenta .modal-header .close:hover { opacity: 1; }
  #modalDetalleVenta .modal-body { padding: 20px 24px; }
  #modalDetalleVenta .modal-footer { border-top: 1px solid #e8eaf6; padding: 12px 24px; }
  #modalDetalleVenta .modal-backdrop { z-index: 10499 !important; }

  #detalle_venta_modal thead th {
    background: #1976d2 !important; color: #fff !important;
    font-weight: 500; padding: 11px 12px !important; border: none !important; font-size: .9rem;
  }
  #detalle_venta_modal tfoot th {
    background: #e0f2f1; color: #009688;
    font-weight: 700; font-size: 1rem; padding: 10px 12px !important;
  }
</style>

  <div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-md-12">

        <!-- Toolbar -->
        <div class="md-toolbar">
          <h1><i class="fa fa-shopping-cart" style="margin-right:10px;opacity:.85"></i>Ventas</h1>
          <div class="md-toolbar-actions">
            <button class="md-btn md-btn-purple" onclick="mostrarform(true)">
              <i class="fa fa-plus-circle"></i> Nueva Venta
            </button>
          </div>
        </div>

        <!-- Card listado -->
        <div class="md-card" id="listadoregistros">
          <div class="md-card-content table-responsive">
            <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
              <thead>
                <th>Opciones</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>NO. Factura</th>
                <th>Documento</th>
                <th>Número</th>
                <th>Total Venta</th>
                <th>Estado</th>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>

        <!-- Card formulario -->
        <div class="md-card" id="formularioregistros">
          <div class="md-section-title">
            <i class="fa fa-file-text-o"></i> Registrar Venta
          </div>
          <div class="md-card-content">
            <form action="" name="formulario" id="formulario" method="POST">
              <input type="hidden" name="idventa" id="idventa">

              <!-- Fila 1: Cliente + Fecha -->
              <div class="row">
                <div class="col-lg-8 col-md-8 col-xs-12">
                  <div class="md-field">
                    <label>Cliente (*)</label>
                    <select name="idcliente" id="idcliente" class="form-control selectpicker" data-live-search="true" required></select>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 col-xs-12">
                  <div class="md-field">
                    <label>Fecha (*)</label>
                    <input class="form-control" type="date" name="fecha_hora" id="fecha_hora" required>
                  </div>
                </div>
              </div>

              <!-- Sub-sección comprobante -->
              <div class="md-subsection">
                <div class="md-subsection-label"><i class="fa fa-file-o"></i>&nbsp; Datos del Comprobante</div>
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="md-field">
                      <label>Tipo Comprobante (*)</label>
                      <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required>
                        <option></option>
                        <option value="Ticket">Ticket</option>
                        <option value="Boleta">Boleta</option>
                        <option value="Factura">Factura</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-2 col-md-2 col-xs-6">
                    <div class="md-field">
                      <label>Serie</label>
                      <input class="form-control" type="text" name="serie_comprobante" id="serie_comprobante" maxlength="7" placeholder="Serie">
                    </div>
                  </div>
                  <div class="col-lg-2 col-md-2 col-xs-6">
                    <div class="md-field">
                      <label>Número</label>
                      <input class="form-control" type="text" name="num_comprobante" id="num_comprobante" maxlength="10" placeholder="Número">
                    </div>
                  </div>
                  <div class="col-lg-2 col-md-2 col-xs-6">
                    <div class="md-field">
                      <label>Impuesto</label>
                      <input class="form-control" type="text" name="impuesto" id="impuesto">
                    </div>
                  </div>
                </div>
              </div>

              <!-- Botón agregar artículos -->
              <div style="margin-bottom:16px;">
                <a data-toggle="modal" href="#myModal" style="text-decoration:none;">
                  <button id="btnAgregarArt" type="button" class="md-btn md-btn-teal">
                    <i class="fa fa-plus"></i> Agregar Artículos
                  </button>
                </a>
              </div>

              <!-- Tabla de detalle -->
              <div class="table-responsive" style="margin-bottom:16px;">
                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Opciones</th>
                    <th>Artículo</th>
                    <th>Cantidad</th>
                    <th>P.Costo</th>
                    <th>Precio Venta</th>
                    <th>Descuento</th>
                    <th>Subtotal</th>
                  </thead>
                  <tfoot>
                    <th>TOTAL</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th><h4 id="total">Q. 0.00</h4><input type="hidden" name="total_venta" id="total_venta"></th>
                  </tfoot>
                  <tbody></tbody>
                </table>
              </div>

              <div class="md-divider"></div>

              <div class="md-form-actions">
                <button class="md-btn md-btn-primary" type="submit" id="btnGuardar">
                  <i class="fa fa-save"></i> Guardar
                </button>
                <button class="md-btn md-btn-danger" onclick="cancelarform()" type="button" id="btnCancelar">
                  <i class="fa fa-arrow-circle-left"></i> Cancelar
                </button>
              </div>

            </form>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>

<!-- Modal detalle de venta -->
<div class="modal fade" id="modalDetalleVenta" tabindex="-1" role="dialog" aria-labelledby="modalDetalleVentaLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 70% !important;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="modalDetalleVentaLabel"><i class="fa fa-eye" style="margin-right:8px;"></i>Detalle de Venta</h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table id="detalle_venta_modal" class="table table-striped table-bordered table-condensed table-hover"></table>
        </div>
      </div>
      <div class="modal-footer">
        <button class="md-btn md-btn-outlined" type="button" data-dismiss="modal">
          <i class="fa fa-times"></i> Cerrar
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal selección de artículos -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 65% !important;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-search" style="margin-right:8px;"></i>Seleccione un Artículo</h4>
      </div>
      <div class="modal-body">
        <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
          <thead>
            <th>Opciones</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Código</th>
            <th>Stock</th>
            <th>P.Costo</th>
            <th>Precio Venta</th>
            <th>Imagen</th>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button class="md-btn md-btn-outlined" type="button" data-dismiss="modal">
          <i class="fa fa-times"></i> Cerrar
        </button>
      </div>
    </div>
  </div>
</div>
<?php 
}else{
 require 'noacceso.php'; 
}

require 'footer.php';
 ?>
 <script src="scripts/venta.js?v=<?php echo time(); ?>"></script>
 <?php 
}

ob_end_flush();
  ?>

