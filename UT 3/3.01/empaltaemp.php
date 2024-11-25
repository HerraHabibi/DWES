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
      include 'funcionesEmpaltaemp.php';
    ?>

    <a href='./empinicio.html'>Volver</a>
    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <div>
        <b>NUEVO EMPLEADO</b>
      </div>
      <br><br>
      <div>
        <b>DNI: </b><input type='text' name='dni'>
        <br><br>
        <b>Nombre: </b><input type='text' name='nombre'>
        <br><br> 
        <b>Salario: </b><input type='number' name='salario'>
        <br><br>  
        <b>Fecha de nacimiento: </b><input type='date' name='nacimiento'>
        <br><br>
        <b>Departamento: </b><?php selectDptos(); ?>
        <br><br>
        <input type='submit' value='Crear'>
      </div>
    </form>
    
    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $dni = $_REQUEST['dni'];
        $nombre = $_REQUEST['nombre'];
        $salario = $_REQUEST['salario'];
        $nacimiento = $_REQUEST['nacimiento'];
        $codDpto = isset($_POST['cod_dpto']) ? $_POST['cod_dpto'] : null;

        limpiar($dni);
        limpiar($nombre);
        limpiar($salario);
        limpiar($nacimiento);

        validarDpto($codDpto);
        formatearFechaNac($nacimiento);

        insertarEmple($dni, $nombre, $salario, $nacimiento);
        insertarEmpleDpto($dni, $codDpto, $nombre);
      }
    ?>
  </body>
</html>