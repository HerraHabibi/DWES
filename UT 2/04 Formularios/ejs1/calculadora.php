<!DOCTYPE html>
<html lang='es'>
  <head>
    <title>EJ1-Calculadora simple</title>
    <meta charset='UTF-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
  <body>
    <h1>Calculadora</h1>
    <?php
      require 'fcalculadora.php';
      
      echo "Resultado operación: $num1 $simboloOperacion $num2 = $resultado";
    ?>
  </body>
</html>