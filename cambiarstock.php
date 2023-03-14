<link href="./css/Fondos.css" rel="stylesheet" type="text/css">
    <div class="text-center caja">
    <div class="text-center formulario-cabecera-fuente">
    <div class="elements">

<?php
    /*Este codigo permite hacer los cambios en los stocks de productos, dependiendo de quien sea el responsable se ingresara por pantalla la cantidad a
     añadir o retirar, luego son enviados a realizarcambio.php para guardar los cambios
    */
    require 'conexion.php';
    $user = $_POST['user'];
    $tipo = $_POST['tipo'];
    $Code = $_POST["code"];
    $Action = $_POST["accion"];

   
    //Comprobar si es bodeguero o usuario
    ?>
    <?PHP
    if($tipo=="Bodeguero"){
        //El bodeguero añade stock
     
        if($Action=="Add"){
            echo "<center><h2>Ingrese la cantidad a añadir </h2>";
            ?>   
            <form  method="post" action="realizarcambio.php">
            <td><input input name="cantidad" class="form-control" type="number"required min="1"></td>
            <input type="hidden" name="usuario" value="<?= isset($user)?htmlspecialchars($user):'' ?>">
            <input type="hidden" name="type" value="<?= isset($tipo)?htmlspecialchars($tipo):'' ?>"> 
            <input type="hidden" name="action" value="<?= isset($Action)?htmlspecialchars($Action):'' ?>"> 
            <td><button type="submit" name="codigo" value="<?= isset($Code)?htmlspecialchars($Code ):'' ?> "> Añadir Stock</button></td>
            <br>
            </form> <?php 
        
        }else{
            echo "<center><h2>Ingrese la cantidad a pedir </h2>";
            ?>   
            <form  method="post" action="realizarcambio.php">
            <td><input input name="cantidad" class="form-control" type="number"required min="1"></td>
            <input type="hidden" name="usuario" value="<?= isset($user)?htmlspecialchars($user):'' ?>">
            <input type="hidden" name="type" value="<?= isset($tipo)?htmlspecialchars($tipo):'' ?>"> 
            <input type="hidden" name="action" value="<?= isset($Action)?htmlspecialchars($Action):'' ?>"> 
            <td><button type="submit" name="codigo" value="<?= isset($Code)?htmlspecialchars($Code ):'' ?> "> Pedir</button></td>
            <br>
            </form>
            <?php
        }
        
        ?>

        <a href="ingresoBodega.php">Regresar al inventario</a>
        <?php

    } 
    else{
      
        echo "<center><h2>Ingrese la cantidad a pedir </h2>";
        ?>   
        <form  method="post" action="realizarcambio.php">
        <td><input input name="cantidad" class="form-control" type="number"required min="1"></td>
        <input type="hidden" name="usuario" value="<?= isset($user)?htmlspecialchars($user):'' ?>">
        <input type="hidden" name="type" value="<?= isset($tipo)?htmlspecialchars($tipo):'' ?>"> 
        <td><button type="submit" name="codigo" value="<?= isset($Code)?htmlspecialchars($Code ):'' ?> "> Pedir</button></td>
        <br>
        </form>
        <?php
        ?>
        <a href="ingresoUsuario.php">Regresar al inventario</a>
        <?php
    }
?>
</div>