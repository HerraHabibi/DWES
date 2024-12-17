<?php
  session_start();
?>

<!DOCTYPE html>
<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Consultar pedidos cliente - Web Pedidos</title>
  </head>
  <body>
    <?php
      include 'utils/handlerErrores.php';
      include 'utils/conexionBd.php';
      include 'fPe_consped.php';
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

    <h1>Consultar información de los pedidos de un cliente</h1>

    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <b>Cliente: </b><?php selectCustomers(); ?>
      <br><br>
      <button type='submit' name='action' value='consultarPedidos'>Consultar pedidos</button>
    </form>

    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['action']) && $_POST['action'] === 'consultarPedidos') {
          $cliente = isset($_POST['customerNumber']) ? $_POST['customerNumber'] : null;
          
          limpiar($cliente);
          verificarCliente($cliente);
          verPedidos($cliente);
        }
      }
    ?>
  </body>
</html>