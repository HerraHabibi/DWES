<?php
  session_start();
?>

<!DOCTYPE html>
<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Consultar compras - Web Pedidos</title>
  </head>
  <body>
    <?php
      include 'utils/handlerErrores.php';
      include 'utils/conexionBd.php';
      include 'fPe_topprod.php';
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

    <h1>Consultar unidades compradas por el usuario actual de cada producto entre dos fechas</h1>

    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <b>Desde: </b><input type='date' name='desde' id='desde' />
      <br><br>
      <b>Hasta: </b><input type='date' name='hasta' id='hasta' />
      <br><br>
      <button type='submit' name='action' value='consultarVentas'>Consultar compras</button>
    </form>

    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['action']) && $_POST['action'] === 'consultarVentas') {
          $desde = isset($_POST['desde']) ? $_POST['desde'] : null;
          $hasta = isset($_POST['hasta']) ? $_POST['hasta'] : null;
          
          limpiar($desde);
          limpiar($hasta);

          verificarFecha($desde);
          verificarFecha($hasta);

          verProdsCompradosEntre($desde, $hasta);
        }
      }
    ?>
  </body>
</html>