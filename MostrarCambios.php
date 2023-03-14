<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<link href="./css/Mostrar.css" rel="stylesheet" type="text/css">
<?php
$tipo=$_POST['tipo'];
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <h1><center>Todos los cambios</center></h1>
    <br>
    <center><input class="form-control" id="myInput" type="text"  style="width: 450px" placeholder="Escriba algun caracter para buscar el cambio">
    <br><br>
    <table style="width:100%" border="1">
    <th><?php echo "Acción" ?></th>
    <th><?php echo "Fecha" ?></th>
<?php 
include("conexion.php");
if($tipo=="ADMIN" || $tipo =="SADMIN"){
    $texto="./txt/todocambios.txt";
}
else{
    $texto="./txt/cambios.txt";
}
$fp = fopen($texto, 'r') or die("Se produjo un error al abrir el archivo");
while (!feof($fp)){ 
    $linea = fgets($fp);   
    $separada = explode("#", $linea,2);
    if($separada[0]!=""){
    ?>
    <tbody id="myTable">
    
    <tr>
    <th><?php echo $separada[0] ?></th>
    <th><?php echo $separada[1] ?></th>
     </tr>

    <?php 
}}

?>
</tbody>
    <?php
?>

</table>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
</body>
<br>
<?php
if($tipo=="ADMIN"){
    ?>
    <th><center><a href="ingresoAdmin.php"> Regresar </center></a></th>
<?php
}

if($tipo=="SADMIN"){
    ?>
    <th><center><a href="ingresoSuperAdmin.php"> Regresar </center></a></th>
<?php
}
if($tipo=="Bodeguero"){
    ?>
    <th><center><a href="ingresoBodega.php"> Regresar </center></a></th>
<?php 
}
