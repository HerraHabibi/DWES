<?php
  include '../conexionBd.php';
  include 'fComprocli.php';
  include 'fComlogincli.php';
  session_start();

  if (!isset($_SESSION['usuario'])) {
    logout();
    header("Location: comlogincli.php");
    exit();
  }
  include '../handlerErrores.php';
?>

<!DOCTYPE html>
<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Compra productos - Web Compras</title>
    <link rel='stylesheet' href='../css/comun.css'>
  </head>
  <body>
    <nav>
      <a href='menu.php'>Atrás</a>
      <a href='comprocli.php'>Compra de productos</a>
      <a href='comconscli.php'>Consulta de compras</a>
      <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
        <button type='submit' name='logout' value='true'>Cerrar sesión</button>
      </form>
    </nav>

    <div>
      <b>Comprar productos</b>
      <br><br>
    </div>

    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <b>Producto: </b><?php selectProds(); ?>
      <br><br>
      <b>Unidades: </b><input type='number' name='unidades' step='1' min='1'>
      <br><br>
      <input type='submit' value='Comprar'>
    </form>
    
    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nif = isset($_POST['nif']) ? $_POST['nif'] : null;
        $codProd = isset($_POST['id_producto']) ? $_POST['id_producto'] : null;
        $unidades = $_POST['unidades'];

        limpiar($unidades);

        validarProd($codProd);
        validarUnidades($unidades);

        $valido = disponibilidadStock($codProd, $unidades);

        if ($valido) {
          $nif = buscarNif($_SESSION['usuario']);
          realizarCompra($nif, $codProd, $unidades);
          actualizarStock($codProd, $unidades);
        }
      }
    ?>
  </body>
</html>