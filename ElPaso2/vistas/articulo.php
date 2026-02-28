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
<!-- Google Fonts: Roboto -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

<style>
  /* ===== MATERIAL DESIGN – ARTÍCULOS ===== */
  .content-wrapper { background: #f0f4f8 !important; font-family: 'Roboto', sans-serif; }

  /* --- Toolbar superior --- */
  .md-toolbar {
    background: linear-gradient(90deg, #1976d2 0%, #42a5f5 100%);
    border-radius: 10px;
    padding: 16px 24px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    box-shadow: 0 4px 12px rgba(25,118,210,.35);
  }
  .md-toolbar h1 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 500;
    color: #fff;
    letter-spacing: .02em;
  }
  .md-toolbar-actions { display: flex; gap: 10px; flex-wrap: wrap; }

  /* --- Botones Material --- */
  .md-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    border: none;
    border-radius: 6px;
    padding: 9px 20px;
    font-family: 'Roboto', sans-serif;
    font-size: .92rem;
    font-weight: 500;
    letter-spacing: .04em;
    cursor: pointer;
    text-decoration: none;
    transition: box-shadow .2s, transform .15s, background .2s;
    box-shadow: 0 2px 6px rgba(0,0,0,.18);
  }
  .md-btn:hover { transform: translateY(-1px); box-shadow: 0 5px 14px rgba(0,0,0,.22); text-decoration: none; }
  .md-btn:active { transform: translateY(0); box-shadow: 0 1px 4px rgba(0,0,0,.18); }
  .md-btn-primary   { background: #1976d2; color: #fff; }
  .md-btn-primary:hover { background: #1565c0; color: #fff; }
  .md-btn-success   { background: #43a047; color: #fff; }
  .md-btn-success:hover { background: #388e3c; color: #fff; }
  .md-btn-info      { background: #0288d1; color: #fff; }
  .md-btn-info:hover { background: #0277bd; color: #fff; }
  .md-btn-danger    { background: #e53935; color: #fff; }
  .md-btn-danger:hover { background: #c62828; color: #fff; }
  .md-btn-teal      { background: #00897b; color: #fff; }
  .md-btn-teal:hover { background: #00695c; color: #fff; }
  .md-btn-outlined  { background: #fff; color: #1976d2; border: 1.5px solid #1976d2; box-shadow: none; }
  .md-btn-outlined:hover { background: #e3f0ff; color: #1565c0; }

  /* --- Card contenedora --- */
  .md-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,.09), 0 1px 2px rgba(0,0,0,.06);
    overflow: hidden;
    margin-bottom: 24px;
  }
  .md-card-content { padding: 20px 24px 24px; }

  /* --- Tabla --- */
  #tbllistado thead th {
    background: #1976d2 !important;
    color: #fff !important;
    font-weight: 500;
    font-size: .93rem;
    border: none !important;
    padding: 12px 14px !important;
  }
  #tbllistado tbody tr { transition: background .15s; }
  #tbllistado tbody tr:hover { background: #e8f0fe !important; }
  #tbllistado tbody td { padding: 10px 14px !important; vertical-align: middle !important; font-size: .92rem; }
  #tbllistado { border-collapse: separate !important; border-spacing: 0 !important; }

  /* --- Sección formulario --- */
  .md-form-title {
    font-size: 1.1rem;
    font-weight: 500;
    color: #1976d2;
    padding: 18px 24px 0;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 10px;
    border-bottom: 2px solid #e3f0ff;
    padding-bottom: 14px;
  }

  /* --- Inputs estilo Material outlined --- */
  .md-field {
    position: relative;
    margin-bottom: 8px;
  }
  .md-field label {
    display: block;
    font-size: .8rem;
    font-weight: 500;
    color: #1976d2;
    text-transform: uppercase;
    letter-spacing: .06em;
    margin-bottom: 5px;
  }
  .md-field .form-control,
  .md-field select.form-control {
    border: none !important;
    border-bottom: 2px solid #b0bec5 !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    background: #f7f9ff !important;
    padding: 8px 10px !important;
    font-size: 1rem;
    color: #212121;
    transition: border-color .25s;
    height: auto !important;
  }
  .md-field .form-control:focus,
  .md-field select.form-control:focus {
    border-bottom-color: #1976d2 !important;
    background: #fff !important;
    outline: none;
    box-shadow: none !important;
  }

  /* --- Preview imagen --- */
  #imagenmuestra {
    display: block;
    margin-top: 10px;
    border-radius: 8px;
    border: 2px solid #e3f0ff;
    object-fit: cover;
  }

  /* --- Barcode area --- */
  #print {
    margin-top: 12px;
    padding: 10px;
    background: #f7f9ff;
    border-radius: 8px;
    display: inline-block;
  }

  /* --- Divider --- */
  .md-divider { height: 1px; background: #e8eaf6; margin: 20px 0; }

  /* --- Actions footer del form --- */
  .md-form-actions {
    display: flex;
    gap: 12px;
    padding: 16px 24px 24px;
    flex-wrap: wrap;
  }
</style>

    <div class="content-wrapper">
    <section class="content">
      <div class="row">
        <div class="col-md-12">

          <!-- Toolbar -->
          <div class="md-toolbar">
            <h1><i class="fa fa-tag" style="margin-right:10px;opacity:.85"></i>Artículos</h1>
            <div class="md-toolbar-actions">
              <button class="md-btn md-btn-success" onclick="mostrarform(true)" id="btnagregar">
                <i class="fa fa-plus-circle"></i> Agregar
              </button>
              <a target="_blank" href="../reportes/rptarticulos.php" style="text-decoration:none">
                <button class="md-btn md-btn-info" type="button">
                  <i class="fa fa-file-text-o"></i> Reporte
                </button>
              </a>
            </div>
          </div>

          <!-- Card listado -->
          <div class="md-card" id="listadoregistros">
            <div class="md-card-content table-responsive">
              <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                  <th width="50px">Opciones</th>
                  <th>Nombre</th>
                  <th>Categoria</th>
                  <th>Codigo</th>
                  <th width="50px">Existencia</th>
                  <th>Costo</th>
                  <th>Venta</th>
                  <th>Descripcion</th>
                  <th>Estado</th>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>

          <!-- Card formulario -->
          <div class="md-card" id="formularioregistros">
            <div class="md-form-title">
              <i class="fa fa-pencil-square-o"></i> Datos del Artículo
            </div>
            <div class="md-card-content">
              <form action="" name="formulario" id="formulario" method="POST">
                <input type="hidden" name="idarticulo" id="idarticulo">

                <div class="row">
                  <!-- Nombre -->
                  <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="md-field">
                      <label>Nombre (*)</label>
                      <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100" placeholder="Nombre del artículo" required>
                    </div>
                  </div>
                  <!-- Categoría -->
                  <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="md-field">
                      <label>Categoría (*)</label>
                      <select name="idcategoria" id="idcategoria" class="form-control selectpicker" data-Live-search="true" required></select>
                    </div>
                  </div>
                  <!-- Existencia -->
                  <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="md-field">
                      <label>Existencia</label>
                      <input class="form-control" type="number" name="stock" id="stock" required>
                    </div>
                  </div>
                  <!-- Precio Venta -->
                  <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="md-field">
                      <label>Precio Venta</label>
                      <input class="form-control" name="PrecioVenta" id="PrecioVenta" required>
                    </div>
                  </div>
                  <!-- Precio Costo -->
                  <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="md-field">
                      <label>Precio Costo</label>
                      <input class="form-control" type="text" name="PrecioCosto" id="PrecioCosto" required>
                    </div>
                  </div>
                  <!-- Descripción -->
                  <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="md-field">
                      <label>Descripción</label>
                      <input class="form-control" type="text" name="descripcion" id="descripcion" maxlength="256" placeholder="Descripción del artículo">
                    </div>
                  </div>
                  <!-- Imagen -->
                  <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="md-field">
                      <label>Imagen</label>
                      <input class="form-control" type="file" name="imagen" id="imagen">
                      <input type="hidden" name="imagenactual" id="imagenactual">
                      <img src="" alt="" width="150px" height="120" id="imagenmuestra">
                    </div>
                  </div>
                  <!-- Código de barras -->
                  <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="md-field">
                      <label>Código de Barras</label>
                      <input class="form-control" type="text" name="codigo" id="codigo" placeholder="Código del producto" required>
                      <div style="margin-top:10px; display:flex; gap:8px; flex-wrap:wrap;">
                        <button class="md-btn md-btn-teal" type="button" onclick="generarbarcode()">
                          <i class="fa fa-barcode"></i> Generar
                        </button>
                        <button class="md-btn md-btn-outlined" type="button" onclick="imprimir()">
                          <i class="fa fa-print"></i> Imprimir
                        </button>
                      </div>
                      <div id="print">
                        <svg id="barcode"></svg>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="md-divider"></div>

                <div class="md-form-actions">
                  <button class="md-btn md-btn-primary" type="submit" id="btnGuardar">
                    <i class="fa fa-save"></i> Guardar
                  </button>
                  <button class="md-btn md-btn-danger" onclick="cancelarform()" type="button">
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
<?php 
}else{
 require 'noacceso.php'; 
}
require 'footer.php'
 ?>
 <script src="../public/js/JsBarcode.all.min.js"></script>
 <script src="../public/js/jquery.PrintArea.js"></script>
 <script src="scripts/articulo.js"></script>

 <?php 
}

ob_end_flush();
  ?>