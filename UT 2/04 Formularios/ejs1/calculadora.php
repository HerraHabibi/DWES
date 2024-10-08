<!DOCTYPE html>
<html lang='es'>
  <head>
    <title>EJ1-Calculadora simple</title>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  </head>
  <body>
    <h1>Calculadora</h1>
    <?php
      $num1 = $_REQUEST['num1'];
      $num2 = $_REQUEST['num2'];
      $operacion = $_REQUEST['operacion'];
      $simboloOperacion = '';
      
      $resultado = hacerOperacion($num1, $num2, $operacion, $simboloOperacion);

      echo "Resultado operación: $num1 $simboloOperacion $num2 = $resultado";

      function hacerOperacion($num1, $num2, $operacion, &$simboloOperacion) {
        switch ($operacion) {
          case 'suma':
            $resultado = $num1 + $num2;
            $simboloOperacion = '+';
            break;
      
          case 'resta':
            $resultado = $num1 - $num2;
            $simboloOperacion = '-';
            break;
      
          case 'producto':
            $resultado = $num1 * $num2;
            $simboloOperacion = '*';
            break;
      
          case 'division':
            $resultado = $num1 / $num2;
            $simboloOperacion = '/';
            break;
        }

        return $resultado;
      }
    ?>
  </body>
</html>