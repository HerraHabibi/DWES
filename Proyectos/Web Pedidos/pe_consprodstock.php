<?php
  session_start();
?>

<!DOCTYPE html>
<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Consultar stock - Web Pedidos</title>
  </head>
  <body>
    <?php
      include 'utils/handlerErrores.php';
      include 'utils/conexionBd.php';
      include 'fPe_consprodstock.php';
    ?>

    <?php
      if(!isset($_SESSION['usuario'])) {
        logout();
        redireccionar('pe_login.php');
      }
    ?>

    <ul>
      <li><a href='pe_inicio.php'>Volver al inicio</a></li>
    </ul>

    <h1>Consultar stock de un producto</h1>

    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <b>Producto: </b><?php selectProds(); ?>
      <br><br>
      <button type='submit' name='action' value='consultarStock'>Consultar stock</button>
    </form>

    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['action']) && $_POST['action'] === 'consultarStock') {
          $prod = isset($_POST['productCode']) ? $_POST['productCode'] : null;
          
          limpiar($prod);
          verificarProd($prod);
          verStock($prod);
        }
      }
    ?>
  </body>
</html>