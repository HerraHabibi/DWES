<!DOCTYPE html>
<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Portal compras - Web Compras</title>
    <link rel='stylesheet' href='../css/nav.css'>
  </head>
  <body>
    <?php
      include '../handlerErrores.php';
      include '../conexionBd.php';
      include 'fComlogincli.php';
    ?>

    <nav>
      <a href='index.html'>Atrás</a>
      <a href='comprocli.php'>Compra de productos</a>
      <a href='comconscli.php'>Consulta de compras</a>
      <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
        <input type='submit' value='Cerrar sesión'>
      </form>
    </nav>

    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST')
        logout($usuario, $clave);
    ?>
  </body>
</html>