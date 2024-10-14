<!DOCTYPE html>
<html lang='es'>
  <head>
    <title>EJ1-Formulario que recoja los datos de alumnos y se almacenen en un txt</title>
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

        $archivo = 'alumnos1.txt';

        $caracteresNombre = 40;
        $caracteresApellido1 = 81 - 40;
        $caracteresApellido2 = 123 - 82;
        $caracteresNacimiento = 133 - 123;
        $caracteresLocalidad = 160 - 133;
        
        limpiar($nombre);
        limpiar($apellido1);
        limpiar($apellido2);
        limpiar($nacimiento);
        limpiar($localidad);

        validar($nombre, $caracteresNombre, 'El nombre');
        validar($apellido1, $caracteresApellido1, 'El primer apellido');
        validar($apellido2, $caracteresApellido2, 'El segundo apellido');
        validar($nacimiento, $caracteresNacimiento, 'La fecha de nacimiento');
        validar($localidad, $caracteresLocalidad, 'La localidad');

        $nombreFormateado = darFormato($nombre, $caracteresNombre);
        $apellido1Formateado = darFormato($apellido1, $caracteresApellido1);
        $apellido2Formateado = darFormato($apellido2, $caracteresApellido2);
        $nacimientoFormateado = darFormato($nacimiento, $caracteresNacimiento);
        $localidadFormateada = darFormato($localidad, $caracteresLocalidad);

        guardarAlumno($archivo, $nombreFormateado, $apellido1Formateado, $apellido2Formateado, $nacimientoFormateado, $localidadFormateada);
        avisarAlumnoGuardado($nombre, $apellido1, $apellido2);
      }

      function limpiar(&$value) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
      }

      function validar($dato, $caracteres, $campo) {
        if (mb_strlen($dato, 'UTF-8') > $caracteres) {
          die("$campo no puede superar los $caracteres caracteres");
        }
        
        else if ($dato == '') {
          die("$campo no puede ser nulo");
        }
      }

      function darFormato($dato, $caracteres) {
        $datoFormateado = $dato;

        while (mb_strlen($datoFormateado, 'UTF-8') < $caracteres)
          $datoFormateado .= ' ';

        return $datoFormateado;
      }

      function guardarAlumno($archivo, $nombre, $apellido1, $apellido2, $nacimiento, $localidad) {
        $datos = "$nombre$apellido1$apellido2$nacimiento$localidad\n";
        file_put_contents($archivo, $datos,FILE_APPEND);
      }

      function avisarAlumnoGuardado($nombre, $apellido1, $apellido2) {
        echo "Se ha guardado el alumno $nombre $apellido1 $apellido2 correctamente";
      }
    ?>
  </body>
</html>