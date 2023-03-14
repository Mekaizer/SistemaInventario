<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">  <link href="./css/FondoEditar.css?v=<?php echo time(); ?>"  rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script><?php
  
$rutto=$_POST["nombre"];
$origen=$_POST["area"];
include("conexion.php");
#se muestra todas las personas

$user = "SELECT * FROM usuario";
if(isset($_POST["enviar"])){
    date_default_timezone_set('America/Santiago');
    $script_tz = date_default_timezone_get();
    $time = time();
    $time =  date('d-m-Y (h:s:m)', $time);
    include("conexion.php");
    $nom=$_POST["name"];
    $rut=$_POST["rut"];
    $Rol=$_POST["Tipo"];
    $Ad=$_POST["nombre"];
    $area=$_POST["area"];
    $area=strtoupper($area);
    $cont=0;
    $sql = "SELECT * FROM usuario WHERE Rut = '$rut'";
    $res = mysqli_query($conexion, $sql);
    $muestra = mysqli_fetch_array($res);
    $file = fopen("./txt/todocambios.txt", "a");
    $nn=$muestra["Nombre"];
    if($Rol!=$muestra["Tipo"] AND $Rol!=Null){
      $ar=$muestra["Tipo"];
      fwrite($file, "Se cambio el rol de $nn (Rut:$rut). Quien era $ar a $Rol, fue cambiado por el Admin $Ad # $time " . PHP_EOL);
      $up="UPDATE usuario SET Tipo='$Rol' WHERE Rut='$rut'";
      $query = mysqli_query($conexion, $up);
      $cont++;
      
    }
    if($nom!=Null and $nom!=$muestra["Nombre"]){
      fwrite($file, "Se cambio el nombre de $nn (Rut:$rut).Ahora se llama $nom, fue cambiado por el Admin $Ad # $time " . PHP_EOL);
        $up="UPDATE usuario SET Nombre='$nom' WHERE Rut='$rut'";
        $query = mysqli_query($conexion, $up);
        $cont++;
      
    }
    if($area!=Null and $area!=$muestra["Area"]){
      fwrite($file, "Se cambio el area de $nn (Rut:$rut).Ahora esta en el area de $area, fue cambiado por el Admin $Ad # $time " . PHP_EOL);
      $up="UPDATE usuario SET Area='$area' WHERE Rut='$rut'";
        $query = mysqli_query($conexion, $up);
        $cont++;
    }

    fclose($file);
    if($cont!=0){
      if($cont==2){
        echo "<script> alert('Se han actualizado los datos');location.assign('ingresoAdmin.php')</script>";
      }else{
        echo "<script> alert('Se ha actualizado el datos');location.assign('ingresoAdmin.php')</script>";
      }
    }else{
      echo "<script> alert('No se han realizado cambios');location.assign('ingresoAdmin.php')</script>";
    }
    #vemos los casos, dependiendo de cual sea se implementará. El contador servira para ver si existe un cambio o no
    #buscar en base de datos y cambiar nombre, luego rol



}

echo "<center><h2>Escriba el nombre de la persona que quiera cambiar el nombre y/o elija el nuevo rol de esa persona</center></h2>";
?>
<!--Se muestra la tabla -->
<body>
  <br>

<div ><center>  
<input class="form-control" id="myInput" type="text"  style="width: 450px" placeholder="Escriba aqui codigo, nombre o numero del producto a buscar">
  <br>
  <table  class="table" border="1">

  <tr  bgcolor= "#3382B9" >
        <th>Rut</th>
        <th>Nombre</th>   
        <th>Cambiar de nombre</th>            
        <th>Rol de persona</th>
        <th>Cambiar de Rol</th>
        <th>Area</th>
        <th>Nueva Area</th>
        <th>Cambiar</th></tr>

        <?php  $muestra = mysqli_query($conexion,$user);
        
        while ($row2 = mysqli_fetch_assoc($muestra)) {
            $rutt=$row2["Rut"];
            $area=$row2["Area"];
            ?>
            <tbody id="myTable">
            <tr>
          <?php if($area==$origen and $rutt!=$rutto){
            ?>
            <tr>
           
           <div id="container">
           <?php if($row2["Tipo"]!="SADMIN"){
            ?>
            <td><?php echo $rutt  ?></td>
            
               <!--Se pide ingresar el cambio, luego presionas aceptar-->
               <td><?php echo $row2["Nombre"] ?></td>
               <th>   <br> <form  method="post" action="">
                   <div class="form-group">
                   <div class="col-md-6">
                   <label class="control-label" for="name">Nombre</label>
                   <input name="name" class="form-control" type="text" >
                   </div>
                   </div>
                   </th>
               <td><?php echo $row2["Tipo"] ?></td>
               <th> <select name="Tipo">
               <option value=""></option>
               <option value="ADMIN">Administrador</option>
               <option value="Bodeguero">Bodeguero</option>
               <option value="Usuario" >Usuario</option>
           </select> 
            <td><?php echo $row2["Area"]; ?></td>
            <!--Se escribe el nombre del area a cambiar -->
            <th>   <br> <form  method="post" action="">
                   <div class="form-group">
                   <div class="col-md-6">
                   <label class="control-label" for="area"></label>
                   <input name="area" class="form-control" type="text" >
                   </div>
                   </div>
                   </th>
              
           <th>           
             
             <div class="form-group">
             <div class="col-md-12">
             <button type="submit" class="btn btn-primary btn-lg btn-block info" name="enviar">Hacer Cambio</button>
             <input type="hidden" name="rut" value="<?= isset($rutt)?htmlspecialchars($rutt):'' ?>"/>
             <input type="hidden" name="nombre" value="<?= isset($rutto)?htmlspecialchars($rutto):'' ?>"/>
             </div>
             </div>     
             </th>
             <?php
           }
          ?>
       </form>
        </tr>
            <?php
          }
         ?>
           
         
   
       <?php 
         
        }  mysqli_free_result($muestra);?> 
      <br>
      </div>
      </table>
      </tbody>
  </div> 

<br>
  <th><center><a href="ingresoAdmin.php"> Regresar </center></a></th>
  </body>
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