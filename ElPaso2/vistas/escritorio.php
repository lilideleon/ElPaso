<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{

 
require 'header.php';

if ($_SESSION['escritorio']==1) {

  require_once "../modelos/Consultas.php";
  $consulta = new Consultas();
  $rsptac = $consulta->totalcomprahoy();
  $regc=$rsptac->fetch_object();
  $totalc=$regc->total_compra;

  $rsptav = $consulta->totalventahoy();
  $regv=$rsptav->fetch_object();
  $totalv=$regv->total_venta;

  //obtener valores para cargar al grafico de barras
  $compras10 = $consulta->comprasultimos_10dias();
  $fechasc='';
  $totalesc='';
  while ($regfechac=$compras10->fetch_object()) {
    $fechasc=$fechasc.'"'.$regfechac->fecha.'",';
    $totalesc=$totalesc.$regfechac->total.',';
  }


  //quitamos la ultima coma
  $fechasc=substr($fechasc, 0, -1);
  $totalesc=substr($totalesc, 0,-1);



    //obtener valores para cargar al grafico de barras
  $ventas12 = $consulta->ventasultimos_12meses ();
  $fechasv='';
  $totalesv='';
  while ($regfechav=$ventas12->fetch_object()) {
    $fechasv=$fechasv.'"'.$regfechav->fecha.'",';
    $totalesv=$totalesv.$regfechav->total.',';
  }


  //quitamos la ultima coma
  $fechasv=substr($fechasv, 0, -1);
  $totalesv=substr($totalesv, 0,-1);
 ?>
<style>
  /* ===== ESCRITORIO – PALETA CÁLIDA ===== */
  .content-wrapper { background: #f4f7fb !important; }

  .dsk-page-header {
    background: linear-gradient(90deg,#4e9af1 0%,#6ab8f7 100%);
    border-radius: 12px;
    padding: 18px 28px;
    margin-bottom: 28px;
    box-shadow: 0 6px 20px rgba(78,154,241,.30);
    display: flex;
    align-items: center;
    gap: 14px;
  }
  .dsk-page-header h1 {
    margin: 0;
    font-size: 1.55rem;
    font-weight: 700;
    color: #fff;
    letter-spacing: .03em;
  }
  .dsk-page-header i {
    font-size: 1.8rem;
    color: rgba(255,255,255,.85);
  }

  /* --- Tarjetas de totales --- */
  .dsk-stat {
    border-radius: 14px;
    padding: 22px 24px 0;
    margin-bottom: 24px;
    overflow: hidden;
    position: relative;
    box-shadow: 0 8px 28px rgba(0,0,0,.10);
    transition: transform .2s, box-shadow .2s;
  }
  .dsk-stat:hover { transform: translateY(-3px); box-shadow: 0 14px 36px rgba(0,0,0,.15); }
  .dsk-stat.compras { background: linear-gradient(135deg,#4e9af1 0%,#82c4f8 100%); }
  .dsk-stat.ventas  { background: linear-gradient(135deg,#3dba8e 0%,#72d9b5 100%); }
  .dsk-stat .dsk-stat-inner { padding-bottom: 16px; }
  .dsk-stat .dsk-stat-inner h3 {
    margin: 0 0 4px;
    font-size: 2rem;
    font-weight: 700;
    color: #fff;
  }
  .dsk-stat .dsk-stat-inner p {
    margin: 0;
    font-size: 1.05rem;
    color: rgba(255,255,255,.85);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: .06em;
  }
  .dsk-stat .dsk-stat-icon {
    position: absolute;
    right: 18px;
    top: 50%;
    transform: translateY(-60%);
    font-size: 4.5rem;
    color: rgba(255,255,255,.18);
    pointer-events: none;
  }
  .dsk-stat-footer {
    display: block;
    background: rgba(0,0,0,.12);
    color: rgba(255,255,255,.92);
    text-align: center;
    padding: 9px;
    font-size: .95rem;
    font-weight: 600;
    text-decoration: none;
    transition: background .2s;
  }
  .dsk-stat-footer:hover { background: rgba(0,0,0,.22); color: #fff; text-decoration: none; }
  .dsk-stat-footer i { margin-left: 6px; }

  /* --- Cajas de gráficas --- */
  .dsk-chart-box {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 6px 24px rgba(78,154,241,.12);
    overflow: hidden;
    margin-bottom: 24px;
  }
  .dsk-chart-box .dsk-chart-header {
    background: linear-gradient(90deg,#eef4fd,#dceefb);
    border-bottom: 2px solid #b3d4f5;
    padding: 14px 22px;
    font-size: 1.0rem;
    font-weight: 700;
    color: #2a6099;
    letter-spacing: .02em;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .dsk-chart-box .dsk-chart-header i { color: #4e9af1; font-size: 1.1rem; }
  .dsk-chart-box .dsk-chart-body { padding: 20px; }
</style>

    <div class="content-wrapper">
    <section class="content">

      <div class="row">
        <div class="col-md-12">

          <!-- Encabezado de página -->
          <div class="dsk-page-header">
            <i class="fa fa-tachometer"></i>
            <h1>Escritorio</h1>
          </div>

          <!-- Tarjetas de totales del día -->
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="dsk-stat compras">
                <div class="dsk-stat-inner">
                  <h3>Q. <?php echo $totalc; ?></h3>
                  <p><i class="fa fa-shopping-basket"></i>&nbsp; Compras del día</p>
                </div>
                <i class="fa fa-shopping-basket dsk-stat-icon"></i>
                <a href="ingreso.php" class="dsk-stat-footer">Ver Compras <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="dsk-stat ventas">
                <div class="dsk-stat-inner">
                  <h3>Q. <?php echo $totalv; ?></h3>
                  <p><i class="fa fa-line-chart"></i>&nbsp; Ventas del día</p>
                </div>
                <i class="fa fa-line-chart dsk-stat-icon"></i>
                <a href="venta.php" class="dsk-stat-footer">Ver Ventas <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>

          <!-- Gráficas -->
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="dsk-chart-box">
                <div class="dsk-chart-header"><i class="fa fa-bar-chart"></i> Compras de los últimos 10 días</div>
                <div class="dsk-chart-body">
                  <canvas id="compras" width="400" height="300"></canvas>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="dsk-chart-box">
                <div class="dsk-chart-header"><i class="fa fa-area-chart"></i> Ventas de los últimos 12 meses</div>
                <div class="dsk-chart-body">
                  <canvas id="ventas" width="400" height="300"></canvas>
                </div>
              </div>
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

require 'footer.php';
 ?>
 <script src="../public/js/Chart.bundle.min.js"></script>
 <script src="../public/js/Chart.min.js"></script>
 <script>
var ctx = document.getElementById("compras").getContext('2d');
var compras = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasc ?>],
        datasets: [{
            label: '# Compras en Q. de los últimos 10 dias',
            data: [<?php echo $totalesc ?>],
            backgroundColor: [
                'rgba( 78, 154, 241, 0.75)',
                'rgba( 61, 186, 142, 0.75)',
                'rgba(130, 177, 255, 0.75)',
                'rgba(100, 210, 180, 0.75)',
                'rgba(163, 120, 230, 0.75)',
                'rgba( 78, 195, 225, 0.75)',
                'rgba(120, 200, 130, 0.75)',
                'rgba(255, 168,  90, 0.75)',
                'rgba( 90, 170, 255, 0.75)',
                'rgba( 60, 200, 160, 0.75)'
            ],
            borderColor: [
                'rgba( 50, 120, 210, 1)',
                'rgba( 30, 155, 110, 1)',
                'rgba( 90, 140, 215, 1)',
                'rgba( 60, 175, 145, 1)',
                'rgba(120,  85, 195, 1)',
                'rgba( 45, 160, 195, 1)',
                'rgba( 75, 165,  90, 1)',
                'rgba(215, 130,  50, 1)',
                'rgba( 55, 135, 215, 1)',
                'rgba( 35, 165, 125, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
var ctx = document.getElementById("ventas").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasv ?>],
        datasets: [{
            label: '# Ventas en Q. de los últimos 12 meses',
            data: [<?php echo $totalesv ?>],
            backgroundColor: [
                'rgba( 61, 186, 142, 0.75)',
                'rgba( 78, 154, 241, 0.75)',
                'rgba(163, 120, 230, 0.75)',
                'rgba( 78, 195, 225, 0.75)',
                'rgba(130, 177, 255, 0.75)',
                'rgba(255, 168,  90, 0.75)',
                'rgba(100, 210, 180, 0.75)',
                'rgba(120, 200, 130, 0.75)',
                'rgba(205, 130, 240, 0.75)',
                'rgba( 90, 200, 215, 0.75)',
                'rgba(255, 195, 100, 0.75)',
                'rgba( 60, 185, 155, 0.75)'
            ],
            borderColor: [
                'rgba( 30, 155, 110, 1)',
                'rgba( 50, 120, 210, 1)',
                'rgba(120,  85, 195, 1)',
                'rgba( 45, 160, 195, 1)',
                'rgba( 90, 140, 215, 1)',
                'rgba(215, 130,  50, 1)',
                'rgba( 60, 175, 145, 1)',
                'rgba( 75, 165,  90, 1)',
                'rgba(165,  90, 205, 1)',
                'rgba( 50, 165, 180, 1)',
                'rgba(210, 150,  50, 1)',
                'rgba( 35, 150, 120, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
 <?php 
}

ob_end_flush();
  ?>

