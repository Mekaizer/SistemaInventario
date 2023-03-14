
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<?php
#Muestra los productos que se han pedido,
include_once "./funciones/Comprobar.php";
require 'conexion.php';
?>
<link href="./css/FondoEditar.css?v=<?php echo time(); ?>"  rel="stylesheet" type="text/css">
<!DOCTYPE html>
<html>
<head>

</head>
<body>

<br>
<?php
$txt="./txt/pdfe.txt";
$pass=Pedido($txt);

$Extra="Extra";
if($pass){
  ?> <div ><center>
<h2><center>Productos de la boleta de Entrada</center></h2>
    
  <input class="form-control" id="myInput" type="text"  style="width: 450px" placeholder="Escriba aqui codigo, nombre o numero del producto a buscar">
  <br>

  
<br>

  <div class="container">
    <div class="table-responsive">
  <table  style="width:100%" border="1">
<tr>

  <th>Productos</th>
  <th>Codigo</th>
  <th><center>Cantidad</center></th>
  <th></th>
  </tr>


<?php
  $sql="SELECT * FROM pedido ";
$resultado = mysqli_query($conexion, $sql);
$cont = 0;    
while($mostrar=mysqli_fetch_array($resultado)){
  ?>
  <tbody id="myTable">
<?php
  $rutt = $mostrar["Rut"];
  if($cont==0){
    //Mostrar datos del usuario
    $query="SELECT * FROM usuario WHERE Rut='$rutt'";
    $consulta=mysqli_query($conexion,$query);
    $row = mysqli_fetch_assoc($consulta);
    $cont = 1;
    $rut= $row["Rut"];
    $tipo=$row["Tipo"];
    ?>


    <?php
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
    <form  method="post" action="Regresar.php">
            <td><center><button type="submit" name="code" value="<?= isset($cod)?htmlspecialchars($cod ):'' ?> "> Regresar Producto</button></center></td>
            <input type="hidden" name="rut" value="<?= isset($rut)?htmlspecialchars($rut):'' ?>">
            <input type="hidden" name="stock" value="<?= isset($cant)?htmlspecialchars($cant):'' ?>">
            <input type="hidden" name="code" value="<?= isset($cod)?htmlspecialchars($cod):'' ?>">
            <?php
            $accion = "Res";

            ?>
            <input type="hidden" name="accion" value="<?= isset($accion)?htmlspecialchars($accion):'' ?>">
            <input type="hidden" name="txt" value="<?= isset($txt)?htmlspecialchars($txt):'' ?>">
            <input type="hidden" name="Extra" value="<?= isset($Extra)?htmlspecialchars($Extra):'' ?>">
            </form>
  </tr>
 
  </tbody>
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
    <form  method="post" action="Regresar.php">
    <td><center><button type="submit" name="code" value="<?= isset($cod)?htmlspecialchars($cod ):'' ?> "> Regresar Producto</button></center></td>
            <input type="hidden" name="rut" value="<?= isset($rut)?htmlspecialchars($rut):'' ?>">
            <input type="hidden" name="stock" value="<?= isset($cant)?htmlspecialchars($cant):'' ?>">
            <input type="hidden" name="code" value="<?= isset($cod)?htmlspecialchars($cod):'' ?>">
            <?php
            $accion = "Res";
            ?>
            <input type="hidden" name="accion" value="<?= isset($accion)?htmlspecialchars($accion):'' ?>">
            <input type="hidden" name="txt" value="<?= isset($txt)?htmlspecialchars($txt):'' ?>">
            <input type="hidden" name="Extra" value="<?= isset($Extra)?htmlspecialchars($Extra):'' ?>">
            </form>

    <?php
    
    }   
  }   
?>
</tr>


    <?php

?>

</tr>

</table>
</div>
</div>
</div>
</div>
<?php
} 
else{
  echo "¡NO HAY DATOS PARA UNA BOLETA!";
  $fp =fopen("./txt/pdfe.txt","r");
  $linea = fgets($fp);
  $separada = explode(" ", $linea, 2);
  $codigo = $separada[0];
  $query = "SELECT * FROM usuario WHERE Rut ='$codigo'";
  $consulta = mysqli_query($conexion, $query);
  $row = mysqli_fetch_assoc($consulta);
  $tipo=$row["Tipo"];
}
?>
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
<div class="topnav">
 
<center>
<?php

transformatxt($txt); 
$insertando = " DELETE from pedido"; $query = mysqli_query($conexion, $insertando);
    if($tipo=="Usuario"){
        ?>
        
   <a href="ingresoUsuario.php">Regresar al inventario</a>
    <?php
    }
    else{
        
    if($tipo=="Bodeguero"){
       
        ?>
   <a href="ingresoBodega.php">Regresar al inventario</a>
    <?php
    }else{
       
        ?>
   <a href="ingresoAdmin.php">Regresar al inventario </a>
        <?php
    }
    }
    ?></center>
                     
 </div>
