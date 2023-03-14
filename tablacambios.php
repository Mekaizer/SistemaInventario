<?php
setlocale(LC_ALL,"es_ES");
date_default_timezone_set('America/Santiago');
$script_tz = date_default_timezone_get();
$dia = time() + (7 * 24 * 60 * 60);
$dia =date('Y-m-d');
?>
<html>
<head>
    <body>
        
    <?php
    echo "<center><h2> Todos los Cambios realizados</h2>";
    $cant = 0;
	$fp = fopen("./txt/todocambios.txt", 'r') or die("Se produjo un error al abrir el archivo");
	while (!feof($fp)){
        $cant++;
		$linea = fgets($fp);
        echo nl2br($linea);
    }
?>

    </body>
</head>


</html>

