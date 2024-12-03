<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Alta productos - Web Compras</title>
    <link rel='stylesheet' href='../css/comun.css'>
    </head>
  <body>
    <?php
      include '../handlerErrores.php';
      include '../conexionBd.php';
      include 'fComaprpro.php';
    ?>

    <nav>
      <a href='../gestionInternaGeneral.html'>Atrás</a>
      <a href='comaltacat.php'>Alta categorías</a>
      <a href='comaltapro.php'>Alta productos</a>
      <a href='comaltaalm.php'>Alta almacenes</a>
      <a href='comaprpro.php'>Aprovisionar productos</a>
      <a href='comconstock.php'>Consulta stock</a>
    </nav>

    <div>
      <b>Aprovisionar productos</b>
      <br><br>
    </div>

    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <b>Producto: </b><?php selectProds(); ?>
      <br><br>
      <b>Almacén: </b><?php selectAlms(); ?>
      <br><br> 
      <b>Cantidad: </b><input type='number' name='cantidad' min='1' step='1'>
      <br><br>
      <input type='submit' value='Aprovisionar'>
    </form>
    
    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $codProd = isset($_POST['id_producto']) ? $_POST['id_producto'] : null;
        $codAlm = isset($_POST['num_almacen']) ? $_POST['num_almacen'] : null;
        $cantidad = $_REQUEST['cantidad'];

        limpiar($cantidad);

        validarProd($codProd);
        validarAlm($codAlm);
        validarCantidad($cantidad);

        aprovisionarProducto($codProd, $codAlm, $cantidad);
      }
    ?>
  </body>
</html>