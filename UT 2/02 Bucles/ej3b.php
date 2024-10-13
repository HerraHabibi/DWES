<html>
  <head>
    <title>EJ3B – Conversor Decimal a base 16</title>
  </head>
  <body>
  <?php
      $num='48';
      $base='16';

      $numero = $num;
      $baseCambiada = '';

      while ($numero > 0) {
        $numCalculado = $numero % $base;

        switch ($numCalculado) {
          case '10':
            $numCalculado = 'A';
            break;
            
          case '11':
            $numCalculado = 'B';
            break;
            
          case '12':
            $numCalculado = 'C';
            break;
            
          case '13':
            $numCalculado = 'D';
            break;
            
          case '14':
            $numCalculado = 'E';
            break;
            
          case '15':
            $numCalculado = 'F';
            break;

          default:
            break;
        }

        $baseCambiada = $numCalculado . $baseCambiada;
        $numero = (int)($numero / $base);
      }

      echo "Número $num en base $base es $baseCambiada";
    ?>
  </body>
</html>