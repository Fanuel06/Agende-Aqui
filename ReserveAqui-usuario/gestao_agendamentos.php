<?php
// Conexão com o banco de dados
require_once 'config.php';

// Função para formatar a data
function formatarData($data) {
    return date('d/m/Y', strtotime($data));
}

// Função para formatar a hora
function formatarHora($hora) {
    return date('H:i', strtotime($hora));
}

// Obter todos os agendamentos do banco de dados
$sql = "SELECT * FROM agendamentos";
$resultado = $conexao->query($sql);

// Verificar se há agendamentos
if ($resultado->num_rows > 0) {
    $agendamentos = $resultado->fetch_all(MYSQLI_ASSOC);
} else {
    $agendamentos = [];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Agendamentos</title>
    <link rel="stylesheet" href="gestao_agendamento.css">
</head>
<body>

    <!-- Barra de Navegação -->
    <nav>
        <ul>
            <li><a href="adicionar_agendamento.php">Agendar Horário</a></li>
            <li><a href="agendamentos.php">Agenda</a></li>
            <li><a href="suporte.html">Suporte</a></li>
        </ul>
    </nav>

    <!-- Conteúdo da Página -->
    <div class="container">
        <h1>Gestão de Agendamentos</h1>
        
        <!-- Listagem de Agendamentos -->
        <?php if (!empty($agendamentos)) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Serviço</th>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($agendamentos as $agendamento) : ?>
                        <tr>
                            <td><?= $agendamento['servico'] ?></td>
                            <td><?= formatarData($agendamento['data']) ?></td>
                            <td><?= formatarHora($agendamento['hora']) ?></td>
                            <td><?= $agendamento['nome'] ?></td>
                            <td><?= $agendamento['email'] ?></td>
                            <td>
                                <a href="editar_agendamento.php?id=<?= $agendamento['id'] ?>">Editar</a>
                                <a href="excluir_agendamento.php?id=<?= $agendamento['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este agendamento?')">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>Não há agendamentos registrados.</p>
        <?php endif; ?>

        <!-- Botão para adicionar novo agendamento -->
        <a href="adicionar_agendamento.php" class="button">Adicionar Novo Agendamento</a>
    </div>



</body>
</html>
