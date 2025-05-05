<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercíciofunção</title>
</head>
<body>
    <?php
    //com return (nosso)
    echo"<h1>Calcular área</h1>";
    function calcularArea($b, $a){
        return round($b * $a);

    }
    $area = calcularArea (5,7);
    echo $area;

    // Maneira do Prof.Alex

    // com return

    function areaRet($base, $altura) {

        return $base * $altura;
    }

    function perimetroRet($base, $altura) {
        return 2 * ($base + $altura);

    }
    echo "<h2>Com return</h2>";
    echo "Área = ". areaRet(2, 4);
    echo "<br>Perímetro = ".perimetroRet(2, 4);


    // sem return

    function areaRetangulo($base, $altura){
        echo "Área =".($base * $altura);
    }

    function retPerimetro($base, $altura){
        echo "Perímetro =".(2 *($base + $altura));
    }
    echo "<h3>Sem return</h3>";
    areaRetangulo(2, 4);
    echo "<br>";
    retPerimetro(2, 4);
    echo "<br>";
    ?>
</body>
</html>
