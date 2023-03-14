

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"  crossorigin="anonymous">
	<link href="./css/coloresLogin.css" rel="stylesheet" type="text/css">
	
	<title>Login de usuario</title>
</head>
	<div class="container">
		<div class="text-center caja-login">

		

			<div class="formulario-login">

				<form action="sesion.php" method="POST">

					<div class="formulario-login-cabecera">

						<p class="formulario-login-cabecera-fuente">Ingreso de usuario</p>


					</div>
					<div class="login-elements">

						<input type="text" name="user" placeholder="Rut" required/>

					</div>
					<div class="login-elements">

						<input type="password" name="pass" placeholder="Contraseña" required/>

					</div>
					<div class="login-elements">

						<input type="submit" name="entrar" class="btn btn-success">

					</div>


				</form>


			</div>


		</div>


	</div>

	

	</html>
