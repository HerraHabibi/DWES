<?php
  session_start();

  include 'utils/handlerErrores.php';
  include 'fPe_altaped.php';

  if(!isset($_SESSION['usuario'])) {
    logout();
    redireccionar('pe_login.php');
  }

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
      <li><a href='pe_altaped.php'>Volver al portal de compras</a></li>
    </ul>
    <p>Error al realizar el pago.</p>
  </body>
</html>