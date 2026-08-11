<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Cadastro</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <section>
        
        <a href="produtos.php" class="sombra">Ver Todos os Produtos</a>
        <h2>Cadastro de Produto</h2>
        <form method="POST" enctype = "multipart/form-data">
            <h1>ENVIO DE IMAGENS</h1>
            <input type="text" name  = "nome"      placeholder = "Nome do Produto" class="sombra" required>
            <textarea          name  = "descricao" placeholder = "Descrição do Produto" class="sombra"required></textarea>
            <input type="file" name  = "foto[]"    multiple class="sombra meuInput" required>
            <button type="submit" id = "botao" >Enviar</button>
        </form>
    </section>
</body>
</html>

<?php

#verifica se o usuario enviou os dados do formulario
if( isset($_POST['nome']) && isset($_POST['descricao']) ){
    $nome       = $_POST['nome'];
    $descricao  = $_POST['descricao'];

    #verifica se o usuario enviou alguma foto
    if( isset($_FILES['foto']) ){
        $foto = array();
        $tipo="";

        #percorrer o array de fotos mover essas fotos para a pasta de imagens
        for( $i = 0; $i < count($_FILES['foto']['name']); $i++ ){
            if( $_FILES['foto']['type'][$i] == 'image/jpeg' ){
                $tipo = "jpg";
            }else if( $_FILES['foto']['type'][$i] == 'image/png' ){
                $tipo = "png";
            }else{
                $tipo = "outros";
            }

            if($tipo == "outros"){
                echo "<h1>Tipo de arquivo não permitido!</h1>";
                exit();
            }else{

                $nome_arquivo = md5( $_FILES['foto']['name'][$i].time() ).$tipo;

                move_uploaded_file($_FILES['foto']['tmp_name'][$i], 'imagens/'.$nome_arquivo);
                
                #adiciona o nome da foto no array de fotos, para enviar para o banco de dados
                array_push($foto, $nome_arquivo);
            }
        }
    }
    require 'classes/Produto.class.php';
    $produto = new Produto();
    $produto->enviarProduto($nome, $descricao, $foto);
}