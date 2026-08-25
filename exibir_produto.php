<?php
require 'classes/Produto.class.php';
$produto = new Produto ();
if(isset ($_GET['id'])&& !empty($_GET['id'])){
    $id_produto = $_GET ['id'];
    $dadosProduto = $produto->buscarProduto($id_produto);
    $dadosImagens = $produto->buscarImagens($id_produto);
}else{
    echo "<script>alert('Faltou o id do produto')</script>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exibir todos os Produtos</title>
</head>
<body>
   <section>
    <div>
        <h1><?phpecho $dadosProduto['nome_produto'];?></h1>
        <p><span> Descrição: </span> <?php echo $dadosProduto['descrição'];?></p>  
    </div>
    <?php 
    foreach( $dadosProduto as $dado){
        <div id="imagens">  
        <img src="imagens/<?php echo $dado['nome_imagem'];?>">
        <button class = "compra verde">Comprar</button>
        </div>
        </php>
    }
    ?>

   </section>    

</body>
</html>