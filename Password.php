<link href="./css/FondoCambiar.css" rel="stylesheet" type="text/css">
<?php
    require 'conexion.php';
    include "./funciones/Comprobar.php";
    $ruty = $_POST['rut'];
    $query="SELECT * FROM usuario WHERE Rut='$ruty'";
    $consulta=mysqli_query($conexion,$query);
    $row = mysqli_fetch_assoc($consulta);
    #Mostrar datos
    $rutt = $row["Rut"];
    $aux = $row["Contraseña"];
    $rol=$row["Tipo"];
    $nombre= $row["Nombre"];
    $area=$row["Area"];
    $return="";
    if($row["Tipo"]=="Usuario"){
        $return="U";
    }
    if($row["Tipo"]=="Bodeguero"){
    $return = "B";
    }
    if($row["Tipo"]=="ADMIN"){
    $return="A";
    }
    ?>
    <body>
        <?php
        #los datos de mas abajo se usaran aqui, para evitar hacer otro archivo php
        #el objetivo de este proceso es el de guardar la contraseña o avisar que es invalida y regresar de donde llego. 
        if(isset($_POST["enviar"])){
            $auxi = $_POST['npass'];
            if(validar($auxi)){
                $ruto = $_POST["rut"];
                $rol = $_POST["rol"];
                $nombre = $_POST["nombre"];
                $area=$_POST["area"];
                $drop = "DELETE from usuario Where Rut ='$ruto'";
                $res=mysqli_query($conexion, $drop);
                $sql = " INSERT INTO usuario VALUES('$ruto','$rol','$nombre','$auxi','$area')";
                $res = mysqli_query($conexion, $sql);
                $return = $_POST["tipo"];
                if($return=="U"){
                    echo "<script> alert('Contraseña cambiada');location.assign('ingresoUsuario.php')</script>";
                }
                if($return=="B"){
                    echo "<script> alert('Contraseña cambiada');location.assign('ingresoBodega.php')</script>";
                }
                if($return=="A"){
                    echo "<script> alert('Contraseña cambiada');location.assign('ingresoAdmin.php')</script>";
                }else{
                    echo "<script> alert('Contraseña cambiada')</script>";
                }
               
               
            }
           else{
            if($return=="U"){
                echo "<script> alert('Contraseña erronea');location.assign('ingresoUsuario.php')</script>";
            }
            if($return=="B"){
                echo "<script> alert('Contraseña erronea');location.assign('ingresoBodega.php')</script>";
            }
            if($return=="A"){
                echo "<script> alert('Contraseña erronea');location.assign('ingresoAdmin.php')</script>";
            }
     
           }
        }
        #Se muestra por pantalla lo siguiente
        ?>
    <br>
        <div><center><h2>Datos Usuario</h2>    
    <br>
    <table style="width:50%" class="table"  border="1" >
   
    <th>Nombre del Usuario: </th> 
    <th>Rut: </th>  
    <th>Contraseña: </th>  
    <th>Tipo: </th>  
    <th>Área: </th>  
    </tr>
    <tr>
    <th>  <?php echo $nombre?> </a> </th>               
    <th>  <?php echo  $ruty ?> </a> </th>  
    <th>  <?php echo  $aux ?> </a> </th>  
    <th>  <?php echo  $rol?> </a> </th>  
    <th>  <?php echo  $area?> </th>
</table>

<br>
    <!--Ingrese antigua contraseña -->
    <fieldset style="width:20%">
    <legend><h2>Cambio de contraseña</h2></legend><div>

    <form action ="" method="post">
    <label>Nueva contraseña</label>
    <br>
    <input type="text" name="npass" value="<?php echo $aux ;?>" required><br>
    <input type="hidden" name="rut" value=<?php echo $ruty ;?>>
    <input type="hidden" name="rol" value=<?php echo $rol ;?>>
    <input type="hidden" name="nombre" value=<?php echo $nombre ;?>>
    <input type="hidden" name="tipo" value=<?php echo $return ;?>>
    <input type="hidden" name="area" value=<?php echo $area ;?>>
      <!--Ingrese nueva contraseña -->

      </div>
    <input type="submit" name="enviar" value="ACTUALIZAR">
    
    </form>
 

      <!--verificar 
      listo se guardo si verificar true -->
    
    <br> <br>
    <?php
    if($row["Tipo"]=="Usuario"){
        ?>
   <a href="ingresoUsuario.php">Regresar al inventario</a>
    <?php
    }
    else{
        
    if($row["Tipo"]=="Bodeguero"){
        ?>
   <a href="ingresoBodega.php">Regresar al inventario</a>
    <?php
    }
    if($row["Tipo"]=="SADMIN"){
        ?>
        <th><center><a href="ingresoSuperAdmin.php"> Regresar </center></a></th>
    <?php
    }
    if($row["Tipo"]=="ADMIN"){
        ?>
   <a href="ingresoAdmin.php">Regresar al inventario </a>
        <?php
    }
    ?>
    
 
      <?php
}

  
?></body></fieldset>