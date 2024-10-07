<?php
  $num1 = $_REQUEST['num1'];
  $num2 = $_REQUEST['num2'];
  $operacion = $_REQUEST['operacion'];

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
?>