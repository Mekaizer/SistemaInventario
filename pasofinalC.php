<?php
//Se genera el pdf 
setlocale(LC_ALL,"es_ES");
date_default_timezone_set('America/Santiago');
$semanaSiguiente =date('Y-m-d h:s:m');
include_once "./libreria/Dompdf/vendor/autoload.php";
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->set_paper("A4");

ob_start();
  // Operaciones para generar el HTML que pueden ser llamadas a Bases de Datos, while, etc...
  include 'PDFdeEntrada.php';

  $html = ob_get_clean();
  $dompdf->load_html($html);
  $dompdf->set_paper("A4");
  $dompdf->render();
  transformatxt("./txt/pdfe.txt");

  $insertando = " DELETE from pedido"; $query = mysqli_query($conexion, $insertando);
  $dompdf->stream("Reporte de Entrada $semanaSiguiente .pdf");

  header('Location:index.php');

?>