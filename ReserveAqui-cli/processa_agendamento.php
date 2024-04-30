<?php
require_once 'config.php';

// Definir variáveis iniciais
$hora_inicio = strtotime("08:00");
$hora_fim = strtotime("18:00");

// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os dados do formulário
    $servico = $_POST['servico'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    // Verifique se o horário selecionado está dentro do intervalo permitido (8h às 18h)
    $hora_selecionada = strtotime($hora);
    if ($hora_selecionada < $hora_inicio || $hora_selecionada > $hora_fim) {
        // Horário selecionado está fora do intervalo permitido, exiba uma mensagem de erro
        echo "<p class='error-message'>Os agendamentos só podem ser feitos entre 8h e 18h.</p>";
    } else {
        // Verifique se já existe um agendamento para o mesmo serviço, data e hora
        $sql_verificacao = "SELECT * FROM agendamentos WHERE servico = '$servico' AND data = '$data' AND hora = '$hora'";
        $resultado_verificacao = $conexao->query($sql_verificacao);

        if ($resultado_verificacao->num_rows > 0) {
            // Já existe um agendamento para este horário, exiba uma mensagem de erro
            echo "<p class='error-message'>Já existe um agendamento para este horário.</p>";
        } else {
            // Insira os dados no banco de dados
            $sql_insercao = "INSERT INTO agendamentos (servico, data, hora, nome, email) VALUES ('$servico', '$data', '$hora', '$nome', '$email')";
            if ($conexao->query($sql_insercao) === TRUE) {
                // Agendamento realizado com sucesso
                // echo "<p class='success-message'>Agendamento realizado com sucesso!</p>";
            } else {
                // Erro ao realizar o agendamento
                // echo "<p class='error-message'>Erro ao realizar o agendamento: " . $conexao->error . "</p>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado do Agendamento</title>
    <link rel="stylesheet" href="processa.css">
    <!-- Adicione links para os estilos CSS aqui, se necessário -->
</head>
<body>

    <nav>
        <ul>
            <li><a href="index.html">Página Inicial</a></li>
            <li><a href="reserva.php">Agendar</a></li>
            <li><a href="horarios_agendados.php">Horários Agendados</a></li>
            <li><a href="sobre.html">Sobre</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Resultado do Agendamento</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Se o formulário foi enviado, exibir a mensagem de sucesso ou erro
            if ($hora_selecionada < $hora_inicio || $hora_selecionada > $hora_fim) {
                echo "<p class='error-message'>Os agendamentos só podem ser feitos entre 8h e 18h.</p>";
            } elseif ($resultado_verificacao->num_rows > 0) {
                echo "<p class='error-message'>Já existe um agendamento para este horário.</p>";
            } else {
                echo "<p class='success-message'>Agendamento realizado com sucesso!</p>";
            }
        }
        ?>
    </div>
</body>
</html>
