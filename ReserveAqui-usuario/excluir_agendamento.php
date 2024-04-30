<?php
require_once 'config.php';

// Verificar se o ID do agendamento foi fornecido via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Excluir o agendamento do banco de dados
    $sql = "DELETE FROM agendamentos WHERE id = $id";

    if ($conexao->query($sql) === TRUE) {
        // Redirecionar de volta à página de gestão de agendamentos após a exclusão
        header("Location: agendamentos.php");
        exit();
    } else {
        echo "Erro ao excluir o agendamento: " . $conexao->error;
    }
} else {
    // Redirecionar de volta à página de gestão de agendamentos se o ID do agendamento não foi fornecido
    header("Location: agendamentos.php");
    exit();
}
?>
