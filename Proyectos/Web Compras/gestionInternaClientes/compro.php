<!DOCTYPE html>
<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Alta almacenes - Web Compras</title>
    <link rel='stylesheet' href='../css/comun.css'>
  </head>
  <body>
    <?php
      include '../handlerErrores.php';
      include '../conexionBd.php';
      include 'fCompro.php';
    ?>

    <nav>
      <a href='../gestionInternaClientes.html'>Atrás</a>
      <a href='comaltacli.php'>Alta de Clientes</a>
      <a href='compro.php'>Compra de Productos</a>
    </nav>

    <div>
      <b>Crear nuevo almacen</b>
      <br><br>
    </div>

    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <b>NIF Cliente: </b><?php selectNifs(); ?>
      <br><br>
      <b>Producto: </b><?php selectProds(); ?>
      <br><br>
      <b>Cantidad: </b><input type='number' name='unidades' step='1' min='1'>
      <br><br>
      <input type='submit' value='Comprar'>
    </form>
    
    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nif = isset($_POST['nif']) ? $_POST['nif'] : null;
        $codProd = isset($_POST['id_producto']) ? $_POST['id_producto'] : null;
        $unidades = $_POST['unidades'];

        limpiar($nif);
        limpiar($codProd);
        limpiar($unidades);

        validarNif($nif);
        validarProd($codProd);
        validarUnidades($unidades);

        $valido = disponibilidadStock($codProd, $unidades);

        if ($valido) {
          realizarCompra($nif, $codProd, $unidades);
          actualizarStock($codProd, $unidades);
        }
      }
    ?>
  </body>
</html>