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
      include 'funcionesEmpfecha.php';
    ?>

    <a href='./empinicio.html'>Volver</a>
    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <div>
        <b>EMPLEADOS EN FECHA</b>
      </div>
      <br><br>
      <div>
        <b>Fecha: </b><input type='date' name='fecha'>
        <br><br>
        <input type='submit' value='Ver'>
      </div>
    </form>
    
    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fecha = $_POST['fecha'];

        validarFecha($fecha);

        verTrabajadoresEnFecha($fecha);
      }
    ?>
  </body>
</html>