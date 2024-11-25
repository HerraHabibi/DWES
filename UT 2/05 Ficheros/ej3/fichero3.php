<!DOCTYPE html>
<html lang='es'>
  <head>
    <title>EJ3-Recoger alumnos almacenados en un txt y crear una tabla</title>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  </head>
  <body>
    <h1>Alumnos</h1>

  <!-- MAIN -->
    <?php
      $archivo = '../ej1/alumnos1.txt';
      
      leerLineas($archivo);
    ?>

  <!-- FUNCIONES -->
    <?php
      function leerLineas($archivo) {
        $archivo = fopen($archivo, "r");

        if ($archivo) {
          while (($linea = fgets($archivo)) !== false) {
            $datosUsuarioLeido = explode($delimitador, $linea);
            $usuarioLeido = $datosUsuarioLeido[0];
          }

          fclose($archivo);
        }
      }
    ?>
  </body>
</html>