<?php
require_once 'config.php';

// Verificar se o ID do agendamento foi fornecido via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consultar o banco de dados para obter os detalhes do agendamento
    $sql = "SELECT * FROM agendamentos WHERE id = $id";
    $resultado = $conexao->query($sql);

    // Verificar se o agendamento existe
    if ($resultado->num_rows == 1) {
        $agendamento = $resultado->fetch_assoc();
    } else {
        // Redirecionar de volta à página de gestão de agendamentos se o agendamento não for encontrado
        header("Location: agendamentos.php");
        exit();
    }
} else {
    // Redirecionar de volta à página de gestão de agendamentos se o ID do agendamento não foi fornecido
    header("Location: agendamentos.php");
    exit();
}

// Verificar se o formulário foi enviado via método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar os novos dados do agendamento do formulário
    $novoServico = $_POST['servico'];
    $novaData = $_POST['data'];
    $novaHora = $_POST['hora'];
    $novoNome = $_POST['nome'];
    $novoEmail = $_POST['email'];

    // Atualizar o agendamento no banco de dados
    $sql = "UPDATE agendamentos SET servico = '$novoServico', data = '$novaData', hora = '$novaHora', nome = '$novoNome', email = '$novoEmail' WHERE id = $id";

    if ($conexao->query($sql) === TRUE) {
        // Redirecionar de volta à página de gestão de agendamentos após a edição
        header("Location: agendamentos.php");
        exit();
    } else {
        echo "Erro ao editar o agendamento: " . $conexao->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Agendamento</title>
    <link rel="stylesheet" href="editar.css">
</head>
<body>

    <!-- Barra de Navegação -->
    <nav>
        <ul>
            <li><a href="adicionar_agendamento.php">Agendar Horário</a></li>
            <li><a href="gestao_agendamentos.php">Gestao de Agendamento</a></li>
            <li><a href="agendamentos.php">Agenda</a></li>
            <li><a href="suporte.html">Suporte</a></li>
        </ul>
    </nav>

    <!-- Conteúdo da Página -->
    <div class="container">
        <h1>Editar Agendamento</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id); ?>" method="post">
            <label for="servico">Serviço:</label>
            <input type="text" id="servico" name="servico" value="<?= $agendamento['servico'] ?>" required>

            <label for="data">Data:</label>
            <input type="date" id="data" name="data" value="<?= $agendamento['data'] ?>" required>

            <label for="hora">Hora:</label>
            <input type="time" id="hora" name="hora" value="<?= $agendamento['hora'] ?>" required>

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?= $agendamento['nome'] ?>" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" value="<?= $agendamento['email'] ?>" required>

            <input type="submit" value="Salvar Alterações">
        </form>
    </div>




</body>
</html>
