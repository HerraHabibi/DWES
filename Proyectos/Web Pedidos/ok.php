<?php
  session_start();

  include 'utils/handlerErrores.php';
  include 'utils/conexionBd.php';
  include 'utils/apiRedsys.php';
  include 'fPe_altaped.php';

  if(!isset($_SESSION['usuario'])) {
    logout();
    redireccionar('pe_login.php');
  }

  $carrito = isset($_COOKIE['carrito']) ? unserialize($_COOKIE['carrito']) : array();
  $carrito = isset($carrito[$_SESSION['usuario']]) ? $carrito[$_SESSION['usuario']] : array();

  foreach ($carrito as $numProd => $cantProd)
    actualizarStock($numProd, $cantProd);

  hacerPedido($carrito);
  eliminarCarrito();

  unset($_SESSION['precioTotal']);
  unset($_SESSION['tarjeta']);
?>

<!DOCTYPE html>
<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Hacer pedido - Web Pedidos</title>
  </head>
  <body>
    <ul>
      <li><a href='pe_inicio.php'>Volver al inicio</a></li>
    </ul>
    <p>Pago realizado con éxito.</p>
  </body>
</html>