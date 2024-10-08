<!DOCTYPE html>
<html lang='es'>
  <head>
    <title>EJ1-Calculadora simple</title>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  </head>
  <body>
    <h1>Calculadora</h1>
    <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='POST'>
      <label for='num1'>Operando1: </label>
      <input type='text' name='num1' id='num1'>
      <br><br>
      <label for='num2'>Operando2: </label>
      <input type='text' name='num2' id='num2'>
      <br><br>
      <label for='operacion'>Selecciona operación</label>
      <br>
      <input type='radio' name='operacion' value='suma' id='suma'>
      <label for='suma'>Suma</label>
      <br>
      <input type='radio' name='operacion' value='resta' id='resta'>
      <label for='resta'>Resta</label>
      <br>
      <input type='radio' name='operacion' value='producto' id='producto'>
      <label for='producto'>Producto</label>
      <br>
      <input type='radio' name='operacion' value='division' id='division'>
      <label for='division'>División</label>
      <br><br>
      <button type='submit'>Enviar</button>
      <button type='reset'>Borrar</button>
      <br><br>
    </form>

    <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $num1 = $_REQUEST['num1'];
        $num2 = $_REQUEST['num2'];
        $operacion = $_REQUEST['operacion'];
        $simboloOperacion = '';
        
        $resultado = hacerOperacion($num1, $num2, $operacion, $simboloOperacion);

        echo "Resultado operación: $num1 $simboloOperacion $num2 = $resultado";
      }

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
