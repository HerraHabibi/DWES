<!DOCTYPE html>
<html lang='es'>
  <head>
    <title>EJ2-Formulario que recoja los datos de alumnos y se almacenen en un txt separado por el delimitador '##'</title>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  </head>
  <body>
    <h1>Datos alumnos</h1>
    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <label for='nombre'>Nombre: </label>
      <input type='text' name='nombre' id='nombre'>
      <br><br>
      <label for='apellido1'>Apellido 1: </label>
      <input type='text' name='apellido1' id='apellido1'>
      <br><br>
      <label for='apellido2'>Apellido 2: </label>
      <input type='text' name='apellido2' id='apellido2'>
      <br><br>
      <label for='nacimiento'>Fecha de nacimiento: </label>
      <input type='date' name='nacimiento' id='nacimiento'>
      <br><br>
      <label for='localidad'>Localidad: </label>
      <input type='text' name='localidad' id='localidad'>
      <br><br>
      <button type='submit'>Enviar</button>
      <button type='reset'>Borrar</button>
      <br><br>
    </form>

    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = $_REQUEST['nombre'];
        $apellido1 = $_REQUEST['apellido1'];
        $apellido2 = $_REQUEST['apellido2'];
        $nacimiento = $_REQUEST['nacimiento'];
        $localidad = $_REQUEST['localidad'];
        
        limpiar($nombre);
        limpiar($apellido1);
        limpiar($apellido2);
        limpiar($nacimiento);
        limpiar($localidad);

        $archivo = 'alumnos2.txt';
        $delimitador = '##';

        validar($nombre, 'El nombre');
        validar($apellido1, 'El primer apellido');
        validar($apellido2, 'El segundo apellido');
        validar($nacimiento, 'La fecha de nacimiento');
        validar($localidad, 'La localidad');

        guardarAlumno($archivo, $delimitador, $nombre, $apellido1, $apellido2, $nacimiento, $localidad);
        avisarAlumnoGuardado($nombre, $apellido1, $apellido2);
      }

      function limpiar(&$value) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
      }

      function validar($dato, $campo) {
        if ($dato == '')
          die("$campo no puede ser nulo");
      }

      function guardarAlumno($archivo, $delimitador, $nombre, $apellido1, $apellido2, $nacimiento, $localidad) {
        $datos = $nombre . $delimitador . $apellido1 . $delimitador . $apellido2 . $delimitador . $nacimiento . $delimitador . $localidad . "\n";
        file_put_contents($archivo, $datos,FILE_APPEND);
      }

      function avisarAlumnoGuardado($nombre, $apellido1, $apellido2) {
        echo "Se ha guardado el alumno $nombre $apellido1 $apellido2 correctamente";
      }
    ?>
  </body>
</html>