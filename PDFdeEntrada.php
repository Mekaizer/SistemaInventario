<?php

include_once "./funciones/Comprobar.php";
require 'conexion.php';
setlocale(LC_ALL,"es_ES");
date_default_timezone_set('America/Santiago');
$dia =date('d-m-Y');
$script_tz = date_default_timezone_get();
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <h1><center>Entrada de Materiales</center></h1>
    <div><h2>Datos del Responsable</h2></div>
<?php
$txt="./txt/pdfe.txt";
Pedido($txt);
$sql="SELECT * FROM pedido ";
$resultado = mysqli_query($conexion, $sql);
$cont = 0;    
while($mostrar=mysqli_fetch_array($resultado)){
  $rutt = $mostrar["Rut"];
  if($cont==0){
    //Mostrar datos del usuario
    $query="SELECT * FROM usuario WHERE Rut='$rutt'";
    $consulta=mysqli_query($conexion,$query);
    $row = mysqli_fetch_assoc($consulta);
    $cont = 1;
    ?>
    
    <table style="width:100%" border="1">
    <tr>
    <th>Nombre: <?php echo $row["Nombre"] ?></th>
    <th>Rut: <?php echo $row["Rut"]?></th>
    <th>Fecha: <?php echo $dia ?> </th>
  </tr>
    </table>
    <br>
    <table style="width:100%" border="1">
  <tr>
    <th>Productos</th>
    <th>Codigo</th>
    <th><center>Cantidad</center></th>
    </tr>
    <?php
        $cod =$mostrar['Codigo'];
        $cant=$mostrar['Cantidad'];
        $query="SELECT * FROM producto WHERE Codigo='$cod'";
        $consulta=mysqli_query($conexion,$query);
        $row = mysqli_fetch_assoc($consulta);
    ?>
    <td><center><?php echo $row["NombreObjeto"] ?></td>
    <td><center><?php echo $cod ?></td>
    <td><center><?php echo $cant ?></center></td>

  
    <?php
  }else{
    //Aqui van los datos de los productos
    $cod =$mostrar['Codigo'];
    $cant=$mostrar['Cantidad'];
    $query="SELECT * FROM producto WHERE Codigo='$cod'";
    $consulta=mysqli_query($conexion,$query);
    $row = mysqli_fetch_assoc($consulta);
    ?>      
  <tr>
    <td><center><?php echo $row["NombreObjeto"] ?></td>
    <td><center><?php echo $cod ?></td>
    <td><center><?php echo $cant ?></center></td>

    <?php
    }   

  }
  if($cont==0){
    $fp =fopen($txt,"r");
    $linea = fgets($fp);
    $separada = explode(" ", $linea, 3);
    $codigo = $separada[0];
    $query = "SELECT * FROM usuario WHERE Rut ='$codigo'";
    $consulta = mysqli_query($conexion, $query);
    $row = mysqli_fetch_assoc($consulta);
    ?>
    <table style="width:100%" border="1">
    <tr>
    <th>Nombre: <?php echo $row["Nombre"] ?></th>
    <th>Rut: <?php echo $row["Rut"]?></th>
    <th>Fecha: <?php echo $dia?> </th>
  </tr>
    </table>
    <?php
  }     
        

?>

</tr>

</table>
    <?php
?>

<br><br>
    <fieldset>
    <legend>Observaciones</legend>
    <br><br><br>
    </fieldset>

    <br><br>

    <table style="width:100%" border="0">
  <tr>
    <th>Firma Encargado:________________________              </th>
    <th>Firma Responsable:______________________              </th>
    </tr>

</table>
</body>
<?php
