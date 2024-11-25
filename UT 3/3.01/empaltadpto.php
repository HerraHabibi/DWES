<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Alta departamentos</title>
  </head>
  <body>
    <?php
      include 'handlerErrores.php';
      include 'conexionBd.php';
      include 'funcionesEmpaltadpto.php';
    ?>

    <a href='./empinicio.html'>Volver</a>
    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <div>
        <b>NUEVO DEPARTAMENTO</b>
      </div>
      <br><br>
      <div>
        <b>Nombre del departamento: </b><input type='text' name='nomDpto'>
        <br><br> 
        <input type='submit' value='Crear'>
      </div>
    </form>

    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nomDpto = $_REQUEST['nomDpto'];

        limpiar($nomDpto);

        $ultDpto = buscarUltimoDpto();
        $codDpto = calcularCodNuevoDpto($ultDpto);
        
        insertarDpto($codDpto, $nomDpto);
      }
    ?>
  </body>
</html>