<?php
// Dados de conexão com o banco de dados
$DB_SERVER = 'localhost'; // Endereço do servidor MySQL
$DB_USERNAME = 'root'; // Nome de usuário do MySQL
$DB_PASSWORD = '84209889'; // Senha do MySQL
$DB_NAME = 'reserveaqui'; // Nome do banco de dados

// Conectar ao banco de dados
$conexao = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// Verificar a conexão
if ($conexao->connect_error) {
    die("Erro de conexão: " . $conexao->connect_error);
}
?>
