<?php
class Produto{
    private $pdo;

    public function __construct(){
        $dns    = "mysql:host=localhost;dbname=loja";
        $user   = "root";
        $pass   = "";
   
        try{
            $this->pdo = new PDO($dns, $user, $pass);
            //echo"<h1>Conexão realizada com Sucesso!</h1>";
        }catch(PDOException $e){
            echo "Erro: ".$e->getMessage();
            exit();
        }
    }
    
    public function enviarProduto( $nome, $descricao, $foto = array() ){
        //inserir Produto na tabela Produto
        $sql = "INSERT INTO produtos set nome_produto = :n, descricao = :d";
        $sql = $this->pdo->prepare($sql);

        $sql->bindValue(':n', $nome);
        $sql->bindValue(':d', $descricao);
        
        $isOk = $sql->execute();
        
        if($isOk){
            $id_produto = $this->pdo->lastInsertId();
        }

        //inserir Imagem na tabela imagem
        if( count( $foto ) > 0 ){
            for ( $i = 0; $i < count($foto); $i++ ) { 
                $nome_foto = $foto[$i];
                $sql = "INSERT INTO imagens SET nome_imagem = :n, fk_id_produto = :p";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(':n', $nome_foto);
                $sql->bindValue(':p', $id_produto);
                $sql->execute();
            }
        }
    }

    public function buscarProdutos(){
        $sql = "SELECT * FROM produtos WHERE id_produto = :id";
        $sql = $this ->pdo->prepare ($sql);
        $sql->bindValue(':id',@id);
        $sql ->execute();


        $sql= $this->pdo->query($sql);

        if( $sql -> rowCount()>0){
            $dados = $sql -> fetchAll (PDO : : FETCH_ASSOC);
            return $dados;
        }else{
            return array();
        }

        public function buascraImagens($id){

        }
    }
}