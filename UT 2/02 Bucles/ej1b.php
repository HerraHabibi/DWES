<html>
  <head>
    <title>EJ1B – Conversor decimal a binario</title>
  </head>
  <body>
    <?php
      $num='48';
      $base='16';

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