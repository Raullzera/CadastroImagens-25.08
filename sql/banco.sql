create database IF not exists imagem_db;
use imagem_db;
create table produtos(
    id_produto int AUTO_INCREMENT PRIMARY KEY,
    nome_produto varchar(100),
    preco_produto decimal(5,2),
    descricao text
);

create table imagens(
    id_imagem int AUTO_INCREMENT PRIMARY KEY,
    nome_imagem varchar(100),
    fk_id_produto int,
    FOREIGN KEY (fk_id_produto) REFERENCES produtos(id_produto)
    ); 