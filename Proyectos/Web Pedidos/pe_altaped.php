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

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'anadirCarrito') {
      $prod = isset($_POST['productCode']) ? $_POST['productCode'] : '';
      $cantidad = $_POST['cantidad'];
      $hayStock = false;
      
      limpiar($prod);
      limpiar($cantidad);

      $productoSeleccionado = verificarProd($prod);
      $cantidad = verificarCant($cantidad);

      if ($productoSeleccionado && is_int($cantidad)) {
        $hayStock = comprobarStock($prod, $cantidad);
        if ($hayStock)
          crearCarrito($prod, $cantidad);
      }
    }

    if (isset($_POST['action']) && $_POST['action'] === 'hacerPedido') {
      $tarjeta = $_POST['tarjeta'];
      $carrito = isset($_COOKIE['carrito']) ? unserialize($_COOKIE['carrito']) : array();
      $carrito = isset($carrito[$_SESSION['usuario']]) ? $carrito[$_SESSION['usuario']] : array();

      limpiar($tarjeta);

      $tarjetaValida = comprobarTarjeta($tarjeta);

      if ($tarjetaValida) {
        if (!empty($carrito)) {
          $productosNoDisponibles = array();

          foreach ($carrito as $numProd => $cantProd) {
            $valido = comprobarStock($numProd, $cantProd);

            if (!$valido)
              array_push($productosNoDisponibles, $numProd);
          }

          if (empty($productosNoDisponibles)) {
            $precioTotal = calcularPrecioTotal($carrito);

            $_SESSION['precioTotal'] = $precioTotal;
            $_SESSION['tarjeta'] = $tarjeta;

            pasarelaPago($precioTotal);
          }
        }
      }
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
      <b>Tarjeta: </b><input type='text' name='tarjeta' min='1' step='1'>
      <br><br>
      <button type='submit' name='action' value='anadirCarrito'>Añadir al carrito</button>
      <button type='submit' name='action' value='verCarrito'>Ver carrito</button>
      <button type='submit' name='action' value='hacerPedido'>Hacer pedido</button>
      <button type='submit' name='action' value='borrarCarrito'>Borrar carrito</button>
    </form>

    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['action']) && $_POST['action'] === 'anadirCarrito') {
          if (!$productoSeleccionado)
            trigger_error('Debes seleccionar un producto', E_USER_WARNING);

          if (!is_int($cantidad))
            trigger_error($cantidad, E_USER_WARNING);

          if (!$hayStock)
            trigger_error('No hay stock suficiente', E_USER_WARNING);

          $producto = obtenerNombreProducto($prod);
          echo "Se agregaron $producto <b>($cantidad)</b> al carrito";
        }

        if (isset($_POST['action']) && $_POST['action'] === 'verCarrito') {
          mostrarCarrito();
        }

        if (isset($_POST['action']) && $_POST['action'] === 'hacerPedido') {
          if (!$tarjetaValida)
            trigger_error('La tarjeta es inválida', E_USER_WARNING);

          if (empty($carrito))
            trigger_error('No tienes productos en el carrito', E_USER_WARNING);

          if (!empty($productosNoDisponibles))
            trigger_error('Productos sin stock: ' . implode(', ', $productosNoDisponibles), E_USER_WARNING);
        }

        if (isset($_POST['action']) && $_POST['action'] === 'borrarCarrito') {
          echo "Se eliminó tu carrito";
        }
      }
    ?>

  </body>
</html>