<html>
  <head> 
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Alta empleado</title>
  </head>
  <body>
    <?php
      include 'handlerErrores.php';
      include 'conexionBd.php';
      include 'funcionesEmplistadpto.php';
    ?>

    <a href='./empinicio.html'>Volver</a>
    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <div>
        <b>TRABAJADORES DEPARTAMENTO</b>
      </div>
      <br><br>
      <div>
        <b>Departamento: </b><?php selectDptos(); ?>
        <br><br>
        <input type='submit' value='Ver'>
      </div>
    </form>
    
    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $codDpto = isset($_POST['cod_dpto']) ? $_POST['cod_dpto'] : null;

        validarDpto($codDpto);

        visualizarTrabajadores($codDpto);
      }
    ?>
  </body>
</html>