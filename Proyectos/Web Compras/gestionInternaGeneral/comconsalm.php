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
      include 'fComconsalm.php';
    ?>

    <nav>
      <a href='../gestionInternaGeneral.html'>Atrás</a>
      <a href='comaltacat.php'>Alta categorías</a>
      <a href='comaltapro.php'>Alta productos</a>
      <a href='comaltaalm.php'>Alta almacenes</a>
      <a href='comaprpro.php'>Aprovisionar productos</a>
      <a href='comconstock.php'>Consulta stock</a>
      <a href='comconsalm.php'>Consulta almacenes</a>
      <a href='comconscom.php'>Consulta compras</a>
    </nav>

    <div>
      <b>Consulta de almacenes</b>
      <br><br>
    </div>

    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <b>Almacén: </b><?php selectAlms(); ?>
      <br><br>
      <input type='submit' value='Ver productos en almacén'>
    </form>
    
    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $codAlm = isset($_POST['num_almacen']) ? $_POST['num_almacen'] : null;

        validarAlm($codAlm);

        verProductos($codAlm);
      }
    ?>
  </body>
</html>