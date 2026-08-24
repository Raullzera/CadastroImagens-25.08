<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Produto {
    private $pdo;

    public function __construct(){
        $dns  = "mysql:host=localhost;dbname=loja";
        $user = "root";
        $pass = "";
   
        try{
            $this->pdo = new PDO($dns, $user, $pass);
        }catch(PDOException $e){
            echo "Erro na Conexão: ".$e->getMessage();
            exit();
        }
    }

    public function conecta(){
        return $this->pdo;
    }

    public function enviarProduto($nome, $descricao, $valor, $fotos = array()){
        // Trata o valor monetário (converte vírgula para ponto)
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
        $valor = (float) $valor;

        // 1. Inserir Produto na tabela produtos
        $sql = "INSERT INTO produtos (nome_produto, descricao, valor) VALUES (:n, :d, :v)";
        $sql = $this->pdo->prepare($sql);

        $sql->bindValue(':n', $nome);
        $sql->bindValue(':d', $descricao);
        $sql->bindValue(':v', $valor);
        
        $isOk = $sql->execute();
        
        if($isOk){
            $id_produto = $this->pdo->lastInsertId();

            // 2. Garante que a pasta imgs/ exista no projeto
            if (!file_exists("imgs")) {
                mkdir("imgs", 0777, true);
            }

            // 3. Processar e mover arquivos
            if(isset($fotos['name']) && is_array($fotos['name'])){
                for ($i = 0; $i < count($fotos['name']); $i++) { 
                    if ($fotos['error'][$i] === UPLOAD_ERR_OK) {
                        $nome_original = $fotos['name'][$i];
                        $tmp_name      = $fotos['tmp_name'][$i];

                        $ext = pathinfo($nome_original, PATHINFO_EXTENSION);
                        $nome_foto = md5($nome_original . time() . rand(0, 9999)) . '.' . $ext;

                        // Salva o arquivo fisicamente na pasta imgs/
                        if (move_uploaded_file($tmp_name, "imgs/" . $nome_foto)) {
                            // Insere o registro na tabela imagens
                            $sqlImg = "INSERT INTO imagens (nome_imagem, fk_id_produto) VALUES (:n, :p)";
                            $sqlImg = $this->pdo->prepare($sqlImg);
                            $sqlImg->bindValue(':n', $nome_foto);
                            $sqlImg->bindValue(':p', $id_produto);
                            $sqlImg->execute();
                        }
                    }
                }
            }
        }
    }

    public function buscarProdutos(){
        $sql = "SELECT p.*, 
                (SELECT nome_imagem FROM imagens WHERE fk_id_produto = p.id_produto LIMIT 1) AS foto_capa 
                FROM produtos p ORDER BY id_produto DESC";
        $sql = $this->pdo->query($sql);

        if($sql && $sql->rowCount() > 0){
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return array();
        }
    }

    public function buscarImagens($id){
        $sql = "SELECT * FROM imagens WHERE fk_id_produto = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return array();
        }
    }
}