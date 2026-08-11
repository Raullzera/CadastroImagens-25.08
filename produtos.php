<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
</head>
<body>
    <section>
        <?php
        require 'classes/Produto.class.php';
        $produto = new produto();
        $dadosProduto = $produto ->buascarProdutos();
        if(empty($dadosProduto)){
            echo "Ainda não há produtos cadastrados aqui!";
        }else{
            foreach($dadosProduto as $Value){
                ?>
                <a href="exibir_produto.php?id=<?php echo $value['id_produto'];?>">
                    <div>
                        <img src ="imagens/<?php echo $Value [ 'foto_capa'];?>">
                        <h2><?php echo $Value ['nome_produto'];?></h2>
                    </div>
            }

        }
    
</body>
</html>