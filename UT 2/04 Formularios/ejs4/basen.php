<!DOCTYPE html>
<html lang='es'>
  <head>
    <title>EJ4-Cambio de base</title>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  </head>
  <body>
    <h1>Cambio de base</h1>
    <?php
      $numero = $_REQUEST['numero'];
      $nuevaBase = $_REQUEST['nuevaBase'];
      
      validar($numero);
      validar($base);

      $numBaseSeparados = separarBase($numero);
      $numero = $numBaseSeparados[0];
      $base = $numBaseSeparados[1];

      $numeroConvertido = cambiarBase($numero, $base, $nuevaBase);

      echo "El número $numero en base $base = $numeroConvertido en base $nuevaBase";

      function validar(&$value) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
      }

      function separarBase($numero) {
        return explode('/', $numero);
      }

      function cambiarBase($numero, $base, $nuevaBase) {
        return base_convert($numero, $base, $nuevaBase);
      }
    ?>
  </body>
</html>