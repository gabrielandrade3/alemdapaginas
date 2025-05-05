<!DOCTYPE html>     
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Função</title>
</head>
<body>
    <?php
    // funções com return
    function calcularMedia($n1, $n2, $n3, $n4) {

        return round(($n1 + $n2 + $n3 +$n4)/4, 2);

    }
    $media = calcularMedia (5, 6, 7, 8);
    echo $media;


    // Outra Maneira Sem Variável
    // echo '<br>';
    //echo "Média = ".calcularMedia(5, 6, 7, 8);

    //echo "Média = ".number_format($media,2, ",",".");

    function media($n1, $n2, $n3, $n4) {
        $media = round(($n1 + $n2 + $n3 + $n4) / 4, 2);
        echo "Média = $media";
    }
    echo '<br>';
    echo media(5,6,7,8);
    ?>
</body>
</html>
