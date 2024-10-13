<html>
  <head>
    <title>EJ2B – Conversor Decimal a base n</title>
  </head>
  <body>
    <?php
      $num='48';
      $base='8';

      $numero = $num;
      $baseCambiada = '';

      while ($numero > 0) {
        $baseCambiada = $numero % $base . $baseCambiada;
        $numero = (int)($numero / $base);
      }

      echo "Número $num en base $base es $baseCambiada";
    ?>
  </body>
</html>