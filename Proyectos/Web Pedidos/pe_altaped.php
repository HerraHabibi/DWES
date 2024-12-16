<?php
  session_start();
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
    <?php
      include 'utils/handlerErrores.php';
      include 'utils/conexionBd.php';
      include 'fPe_altaped.php';
    ?>

    <?php
      if(!isset($_SESSION['usuario'])) {
        logout();
        redireccionar('pe_login.php');

      } else {
        if (isset($_COOKIE['usuario']))
          setcookie('usuario', '', time() - 3600, '/');
        if (isset($_COOKIE['clave']))
          setcookie('clave', '', time() - 3600, '/');
    ?>
        <ul>
          <li><a href='pe_inicio.php'>Volver al inicio</a></li>
        </ul>

        <h1>Hacer pedido como <?php echo $_SESSION['usuario']; ?></h1>

        <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
          <b>Producto: </b><?php selectProds(); ?>
          <br><br>
          <b>Cantidad: </b><input type='number' name='cantidad' min='1' step='1'>
          <br><br>
          <button type='submit' name='action' value='hacerPedido'>Hacer pedido</button>
        </form>
    <?php
      }
    ?>

    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['action']) && $_POST['action'] === 'hacerPedido') {
          $prod = isset($_POST['productCode']) ? $_POST['productCode'] : null;
          $cantidad = $_POST['cantidad'];
          
          limpiar($prod);
          limpiar($cantidad);

          verificarProd($prod);
          verificarCant($cantidad);

          comprobarStock($prod, $cantidad);
          crearPedido($prod, $cantidad);
        }
      }
    ?>
  </body>
</html>