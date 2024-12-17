<?php
  session_start();
?>

<!DOCTYPE html>
<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Consultar pagos cliente - Web Pedidos</title>
  </head>
  <body>
    <?php
      include 'utils/handlerErrores.php';
      include 'utils/conexionBd.php';
      include 'fPe_conspago.php';
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

    <h1>Consultar los pagos de un cliente entre dos fechas</h1>

    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <b>Cliente: </b><?php selectCustomers(); ?>
      <br><br>
      <b>Desde (opcional): </b><input type='date' name='desde' id='desde' />
      <br><br>
      <b>Hasta (opcional): </b><input type='date' name='hasta' id='hasta' />
      <br><br>
      <button type='submit' name='action' value='consultarPagos'>Consultar pagos</button>
    </form>

    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['action']) && $_POST['action'] === 'consultarPagos') {
          $cliente = isset($_POST['customerNumber']) ? $_POST['customerNumber'] : null;
          $desde = !empty($_POST['desde']) ? $_POST['desde'] : date('Y-m-d', 0);
          $hasta = !empty($_POST['hasta']) ? $_POST['hasta'] : date('Y-m-d');

          limpiar($cliente);
          limpiar($desde);
          limpiar($hasta);

          verificarCliente($cliente);

          verPagos($cliente, $desde, $hasta);
        }
      }
    ?>
  </body>
</html>