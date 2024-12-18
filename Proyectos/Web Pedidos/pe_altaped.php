<?php
  session_start();

  include 'utils/handlerErrores.php';
  include 'utils/conexionBd.php';
  include 'fPe_altaped.php';

  if(!isset($_SESSION['usuario'])) {
    logout();
    redireccionar('pe_login.php');
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'anadirCarrito') {
      $prod = isset($_POST['productCode']) ? $_POST['productCode'] : '';
      $cantidad = $_POST['cantidad'];
      
      limpiar($prod);
      limpiar($cantidad);

      // Ejecución del código sin mostrar errores
      if ($prod != '' && $cantidad != '') {
        comprobarStock($prod, $cantidad);
        crearCarrito($prod, $cantidad);
      }
    }

    if (isset($_POST['action']) && $_POST['action'] === 'hacerPedido') {
      eliminarCarrito();
    }

    if (isset($_POST['action']) && $_POST['action'] === 'borrarCarrito') {
      eliminarCarrito();
    }
  }
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

    <h1>Hacer pedido como <?php echo obtenerNombreCliente(); ?></h1>

    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <b>Producto: </b><?php selectProdsConStock(); ?>
      <br><br>
      <b>Cantidad: </b><input type='number' name='cantidad' min='1' step='1'>
      <br><br>
      <button type='submit' name='action' value='anadirCarrito'>Añadir al carrito</button>
      <button type='submit' name='action' value='verCarrito'>Ver carrito</button>
      <button type='submit' name='action' value='hacerPedido'>Hacer pedido</button>
      <button type='submit' name='action' value='borrarCarrito'>Borrar carrito</button>
    </form>

    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['action']) && $_POST['action'] === 'anadirCarrito') {
          //Mostrar errores
          verificarProd($prod);
          $cantidad = verificarCant($cantidad);

          // Mostrar producto agregado
          $producto = obtenerNombreProducto($prod);
          echo "Se agregaron $producto <b>($cantidad)</b> al carrito";
        }

        if (isset($_POST['action']) && $_POST['action'] === 'verCarrito') {
          mostrarCarrito();
        }

        if (isset($_POST['action']) && $_POST['action'] === 'borrarCarrito') {
          echo "Se eliminó tu carrito";
        }
      }
    ?>

  </body>
</html>