<link href="./css/coloresLogin.css" rel="stylesheet" type="text/css">
	
<?php
require 'conexion.php';

include "./funciones/Comprobar.php";
session_start();
/** $usuario y $clave son variables que almacenan datos ingresados por pantalla en index.html, $rutto es el rut arreglado en caso de que se ingresara sin punto ni guion  */
setlocale(LC_ALL,"es_ES");    
date_default_timezone_set('America/Santiago');
$script_tz = date_default_timezone_get();
$time = date('_d-m-Y_h_s_m');
$usuario=$_POST['user'];
$clave=$_POST['pass'];
$rutto = rut($usuario);
/*Se hace el filtro para buscar el usuario con su contraseña, ademas comparamos que #usuario y $rutto sean iguales en caso de que el usuario haya escrito con punto y guion */
if(strcmp($rutto,$usuario)>=0){
	$query=("SELECT * FROM usuario WHERE Rut='$usuario' AND Contraseña='$clave'");
	$rutto = $usuario;
}else{
	$query=("SELECT * FROM usuario WHERE Rut='$rutto' AND Contraseña='$clave'");
}

$consulta=mysqli_query($conexion,$query);
$cantidad=mysqli_num_rows($consulta);
if($cantidad>0){

	$codP=$rutto.$time;
	/*$row es una lista que guarda los datos del filtro hecho en $query*/
	$row = mysqli_fetch_assoc($consulta);
	/*Se guarda el nombre del usuario */
	$_SESSION['Nombre'] = $row["Nombre"];
	$_SESSION["Rut"] = $row["Rut"];
	$_SESSION['Tipo'] = $row["Tipo"];
	$_SESSION["Area"]=$row["Area"];
	if($_SESSION['Tipo']=="ADMIN"){
		header('Location:ingresoAdmin.php');
	}
	if($_SESSION['Tipo']=="Bodeguero"){
		$productos = "Select * from  producto"; 
		$cambios = fopen("./txt/pdfe.txt", "w");
		fwrite($cambios,"$rutto $codP" . PHP_EOL);
	  	fclose($cambios);
		$productos2 = "Select * from  producto"; 
		$cambios2 = fopen("./txt/pdf.txt", "w");
		fwrite($cambios2,"$rutto $codP" . PHP_EOL);
		fclose($cambios2);
		header('Location:ingresoBodega.php');
	}
	if($_SESSION['Tipo']=="Usuario"){
		$productos = "Select * from  producto"; 
		$cambios = fopen("./txt/pdf.txt", "w");
		fwrite($cambios,"$rutto $codP" . PHP_EOL);
	  	fclose($cambios);
		header('Location:ingresoUsuario.php');
	}
	if($_SESSION["Tipo"]=="SADMIN"){
		header('Location:ingresoSuperAdmin.php');
	}
	
}
else{
	echo "<script> alert('Contraseña o usuario incorrecto');location.assign('index.php')</script>";
}
?>