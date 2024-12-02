<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Alta productos - Web Compras</title>
  </head>
  <body>
    <?php
      include 'handlerErrores.php';
      include 'conexionBd.php';
      include 'fComaltapro.php';
    ?>

    <div>
      <b>Crear nuevo producto</b>
      <br><br>
    </div>

    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <b>Nombre: </b><input type='text' name='nomProd'>
      <br><br> 
      <b>Precio: </b><input type='number' name='precioProd' min='0' step='0.01'>
      <br><br>
      <b>Categoría: </b><?php selectCats(); ?>
      <br><br>
      <input type='submit' value='Crear'>
    </form>
    
    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nomProd = $_REQUEST['nomProd'];
        $precioProd = $_REQUEST['precioProd'];
        $codCat = isset($_POST['id_categoria']) ? $_POST['id_categoria'] : null;

        limpiar($nomProd);
        limpiar($precioProd);

        validarNombre($nomProd);
        validarPrecio($precioProd);
        validarCat($codCat);

        $ultProd = buscarUltimoProd();
        $codProd = calcularCodNuevoProd($ultProd);

        insertarProd($codProd, $nomProd, $precioProd, $codCat);
      }
    ?>
  </body>
</html>