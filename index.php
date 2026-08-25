<?php
require_once 'classes/Produto.class.php';
$produto = new Produto();


if (isset($_POST['nome'])) {
    $nome      = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $valor     = $_POST['valor'];
    $fotos     = isset($_FILES['foto']) ? $_FILES['foto'] : array();

    $produto->enviarProduto($nome, $descricao, $valor, $fotos);

    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f4f6f8;
            color: #333;
            padding: 2rem 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1, h2 {
            margin-bottom: 1.5rem;
            color: #1a1a1a;
            text-align: center;
        }

        form {
            background: #ffffff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 500px;
            margin-bottom: 3rem;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.4rem;
            font-size: 0.9rem;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus {
            border-color: #0066cc;
            outline: none;
        }

        textarea {
            resize: vertical;
        }

        button[type="submit"] {
            width: 100%;
            background-color: #7F00FF;
            color: #fff;
            padding: 0.8rem;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        button[type="submit"]:hover {
            background-color: #7F00FF;
        }

        hr {
            width: 100%;
            max-width: 900px;
            border: 0;
            height: 1px;
            background: #e0e0e0;
            margin-bottom: 2rem;
        }

        .produtos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.5rem;
            width: 100%;
            max-width: 900px;
        }

        .produto-card-link {
            text-decoration: none;
            color: inherit;
        }

        .produto-card {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s, box-shadow 0.2s;
            text-align: center;
        }

        .produto-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        .produto-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-bottom: 1px solid #f0f0f0;
        }

        .produto-card h2 {
            font-size: 1.1rem;
            padding: 1rem;
            margin: 0;
            color: #2c3e50;
        }

        .empty-msg {
            text-align: center;
            color: #777;
            font-style: italic;
        }
    </style>
</head>
<body>

    <h1>Cadastrar Produto</h1>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nome">Nome do Produto</label>
            <input type="text" id="nome" name="nome" required placeholder="Ex: Sofá Retrátil">
        </div>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" rows="4" required placeholder="Informe os detalhes do produto..."></textarea>
        </div>

        <div class="form-group">
            <label for="valor">Valor (R$)</label>
            <input type="number" id="valor" name="valor" step="0.01" min="0" required placeholder="0.00">
        </div>

        <div class="form-group">
            <label for="foto">Imagens do Produto</label>
            <input type="file" id="foto" name="foto[]" multiple required>
        </div>

        <button type="submit">Cadastrar Produto</button>
    </form>

    <hr>

    <h2>Produtos Cadastrados</h2>

    <section class="produtos-grid">
        <?php
        $dadosProduto = $produto->buscarProdutos();

        if (empty($dadosProduto)) {
            echo "<p class='empty-msg'>Ainda não há produtos cadastrados aqui!</p>";
        } else {
            foreach ($dadosProduto as $Value) {
                ?>
                <a href="exibir_produto.php?id=<?php echo $Value['id_produto']; ?>" class="produto-card-link">
                    <div class="produto-card">
                        <?php if (!empty($Value['foto_capa'])): ?>
                            <img src="imgs/<?php echo $Value['foto_capa']; ?>" alt="<?php echo $Value['nome_produto']; ?>">
                        <?php endif; ?>
                        <h2><?php echo $Value['nome_produto']; ?></h2>
                    </div>
                </a>
                <?php
            }
        }
        ?>
    </section>

</body>
</html>