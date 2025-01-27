<html>
 <head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
		<title>Bienvenido a MovilMAD</title>
    <link rel='stylesheet' href='./css/bootstrap.min.css'>
 </head>
   
 <body>
    <h1>Servicio de ALQUILER DE E-CARS</h1> 
    <div class='container '>
			<div class='card border-success mb-3' style='max-width: 30rem;'>
				<div class='card-header'>Menú Usuario - ALQUILAR VEHÍCULOS</div>
					<div class='card-body'>
						<form action='' method='post'>
							<b>Bienvenido/a:</b> <?php mostrarNombre(); ?>
							<br>
							<b>Identificador Cliente:</b> <?php echo $_SESSION['usuario']; ?>

							<br><br>

							<b>¡¡¡PAGO REALIZADO CON EXITO!!!</b>

							<br><br>

							<b>Vehículo alquilado:</b> <?php mostrarMarcaVehiculo($devolucion['vehiculo']); ?> - <?php mostrarModeloVehiculo($devolucion['vehiculo']); ?>
							<br>
							<b>Coste base:</b> <?php mostrarPrecioBase($devolucion['vehiculo']); ?>
							<br>
							<b>Tiempo de alquiler:</b> <?php mostrarTiempoAlquiler($devolucion['tiempoAlquiler']); ?>
							<br>
							<b>Coste total:</b> <?php mostrarPrecioTotal($total); ?>

							<br><br>

							<div>
								<input type='submit' value='Volver' name='volver' class='btn btn-warning disabled'>
							</div>		
						</form>

						<a href='controllers/logout_controller.php'>Cerrar Sesión</a>
					</div>
				</div>
			</div>
		</div>
  </body>
</html>

