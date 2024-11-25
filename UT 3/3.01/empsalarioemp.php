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
      include 'funcionesEmpsalarioemp.php';
    ?>

    <a href='./empinicio.html'>Volver</a>
    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <div>
        <b>CAMBIO DE SALARIO</b>
      </div>
      <br><br>
      <div>
        <b>DNI empleado: </b><?php selectDnis(); ?>
        <br><br>
        <b>Porcentaje modificador de salario: </b><input type='number' name='porcentaje'>
        <br><br>
        <input type='submit' value='Modificar'>
      </div>
    </form>
    
    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $dni = isset($_POST['dni']) ? $_POST['dni'] : null;
        $porcentaje = $_POST['porcentaje'];

        limpiar($porcentaje);

        validarDni($dni);
        validarPorcentaje($porcentaje);

        modificarSalario($dni, $porcentaje);
      }
    ?>
  </body>
</html>