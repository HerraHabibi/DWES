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
      <button type='submit' name='action' value='anadirCarrito'>Añadir al carrito</button>
    </form>

    <br>

    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <button type='submit' name='action' value='pagarCarrito'>Pagar carrito</button>
    </form>
    
    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['action']) && $_POST['action'] === 'anadirCarrito') {
          $nif = isset($_POST['nif']) ? $_POST['nif'] : null;
          $codProd = isset($_POST['id_producto']) ? $_POST['id_producto'] : null;
          $unidades = $_POST['unidades'];

          limpiar($unidades);

          validarProd($codProd);
          validarUnidades($unidades);

          crearCookieCarrito($codProd, $unidades);
        }

        if (isset($_POST['action']) && $_POST['action'] === 'pagarCarrito') {
          $carrito = obtenerCarrito();

          if (empty($carrito))
            trigger_error('No tienes productos en el carrito', E_USER_WARNING);

          foreach($carrito as $producto) {
            $codProd = $producto[0];
            $unidades = $producto[1];
          
            $valido = disponibilidadStock($codProd, $unidades);

            if ($valido) {
              $nif = buscarNif($_SESSION['usuario']);
              realizarCompra($nif, $codProd, $unidades);
              actualizarStock($codProd, $unidades);
            }
          }
        }
      }
    ?>
  </body>
</html>