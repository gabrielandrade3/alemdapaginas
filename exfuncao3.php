<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="" method="POST">
        OPIUM_$HIRT (R$250,00): <input type="number" name="camiseta" value="0" min="0" required><br></br>
        HARD_PANT$ (R$500,00) <input type="number" name="calca" value="0" min="0" required><br></br>
        E$$TREME_HAT (R$159,99) <input type="number" name="bone" value="0" min="0" required><br></br>
        <input type="submit" value= "Calcular Total" name= "acao">
    </form>
    
    <?php
    $produtos = [
        "camiseta" => 250,
        "calca" => 500,
        "bone" => 160
    ];

    function calcularTotal($quantidades, $produtos) {
        $total = 0;
        foreach($produtos as $item => $preco){
            $quantidade = $quantidades[$item];
            $total += $quantidade * $preco;
        }
        return $total;
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao'])){
        $quantidades = [
            'camiseta' => $_POST['camiseta'],
            'calca' => $_POST['calca'],
            'bone' => $_POST['bone']
        ];
        $total = calcularTotal($quantidades, $produtos);
        echo '<br><br>';
        echo "Total = R$".number_format($total, 2, ",",".");
    }
?>
</body>
</html>
