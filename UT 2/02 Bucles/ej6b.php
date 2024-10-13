<html>
  <head>
    <title>EJ6B – Factorial</title>
  </head>
  <body>
    <?php
      $num="5";

      $resultado = 1;

      echo "$num! = ";
      for ($i = $num; $i >= 1; $i--) {
        if ($i > 1)
          echo "$i x ";
        else
          echo "$i = ";

        $resultado = $resultado * $i;
      }

      echo $resultado;
    ?>
  </body>
</html>