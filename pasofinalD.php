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

$dompdf1 = new Dompdf();
$dompdf1->set_paper("A4");
  include 'PDFdeRetiro.php';

  $html1 = ob_get_clean();
  $dompdf1->load_html($html1);
  $dompdf1->render();
$contenido1 = $dompdf1->output();
$nombreDelDocumento1 = "Reporte de Retiro backup ".$semanaSiguiente.".pdf";
$bytes1 = file_put_contents("./pdfrespaldo/$nombreDelDocumento1",$contenido1 );//Se usa la libreria dompdf
  include 'PDFdeEntrada.php';
$d=  "DELETE FROM `sistemainventario`.`pedido`";
 transformatxt("./txt/pdfe.txt");
   
$insertando = " DELETE from pedido"; $query = mysqli_query($conexion, $insertando);
  $html = ob_get_clean();
  $dompdf->load_html($html);
  $dompdf->render();
$contenido = $dompdf->output();
$nombreDelDocumento = "Reporte de Entrada backup ".$semanaSiguiente.".pdf";
$bytes = file_put_contents("./pdfrespaldo/$nombreDelDocumento",$contenido  );//Se usa la libreria dompdf
$d=  "DELETE FROM `sistemainventario`.`pedido`";
#transformatxt("./txt/pdf.txt");
 
$insertando = " DELETE from pedido"; $query = mysqli_query($conexion, $insertando);
header('Location:index.php');
	
?>
