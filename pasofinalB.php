<?php
//Se genera el pdf 
setlocale(LC_ALL,"es_ES");
date_default_timezone_set('America/Santiago');
$semanaSiguiente =date('Y-m-d (H_i_s)');
include "./libreria/Dompdf/vendor/autoload.php";
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->set_paper("A4");

ob_start();
  // Operaciones para generar el HTML que pueden ser llamadas a Bases de Datos, while, etc...
  include 'PDFdeRetiro.php';
  
  $html = ob_get_clean();
  $dompdf->load_html($html);
  $dompdf->render();
$contenido = $dompdf->output();
$nombreDelDocumento = "Reporte de Retiro backup ".$semanaSiguiente.".pdf";
#transformatxt("./txt/pdf.txt");

$insertando = " DELETE from pedido"; $query = mysqli_query($conexion, $insertando);
$bytes = file_put_contents("./pdfrespaldo/$nombreDelDocumento",$contenido  );//Se usa la libreria dompdf

header('Location:index.php');
	
?>