<!DOCTYPE html>
<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Alta categorías - Web Compras</title>
    <link rel='stylesheet' href='../css/comun.css'>
    </head>
  <body>
    <?php
      include '../handlerErrores.php';
      include '../conexionBd.php';
      include 'fComaltacat.php';
    ?>

    <nav>
      <a href='../gestionInternaGeneral.html'>Atrás</a>
      <a href='comaltacat.php'>Alta categorías</a>
      <a href='comaltapro.php'>Alta productos</a>
      <a href='comaltaalm.php'>Alta almacenes</a>
      <a href='comaprpro.php'>Aprovisionar productos</a>
    </nav>

    <div>
      <b>Crear nueva categoría</b>
      <br><br>
    </div>

    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <b>Nombre categoría: </b><input type='text' name='nomCat'>
      <br><br>
      <input type='submit' value='Crear'>
    </form>
    
    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nomCat = $_POST['nomCat'];

        limpiar($nomCat);

        $ultCat = buscarUltimaCat();
        $codCat = calcularCodNuevaCat($ultCat);

        insertarCat($codCat, $nomCat);
      }
    ?>
  </body>
</html>