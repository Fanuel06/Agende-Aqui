<?php
require_once 'config.php';

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar os dados do formulário
    $servico = $_POST['servico'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    // Verificar se o horário selecionado está dentro do intervalo permitido (8h às 18h)
    $hora_inicio = strtotime("08:00");
    $hora_fim = strtotime("18:00");
    $hora_selecionada = strtotime($hora);
    if ($hora_selecionada < $hora_inicio || $hora_selecionada > $hora_fim) {
        // Horário selecionado está fora do intervalo permitido, exibir uma mensagem de erro
        $mensagem = "Os agendamentos só podem ser feitos entre 8h e 18h.";
    } else {
        // Verificar se já existe um agendamento para o mesmo serviço, data e hora
        $sql_verificacao = "SELECT * FROM agendamentos WHERE servico = '$servico' AND data = '$data' AND hora = '$hora'";
        $resultado_verificacao = $conexao->query($sql_verificacao);

        if ($resultado_verificacao->num_rows > 0) {
            // Já existe um agendamento para este horário, exibir uma mensagem de erro
            $mensagem = "Já existe um agendamento para este horário.";
        } else {
            // Inserir os dados no banco de dados
            $sql_insercao = "INSERT INTO agendamentos (servico, data, hora, nome, email) VALUES ('$servico', '$data', '$hora', '$nome', '$email')";
            if ($conexao->query($sql_insercao) === TRUE) {
                // Redirecionar para a página de sucesso
                header("Location: sucesso.php");
                exit();
            } else {
                // Se houver algum erro, exibir uma mensagem
                $mensagem = "Erro ao realizar o agendamento: " . $conexao->error;
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
    <title>Adicionar Agendamento</title>
    <link rel="stylesheet" href="adc_agendamento.css">
</head>
<body>

    <!-- Barra de Navegação -->
    <nav>
        <ul>
            <li><a href="gestao_agendamentos.php">Gestao de Agendamento</a></li>
            <li><a href="agendamentos.php">Agenda</a></li>
            <li><a href="suporte.html">Suporte</a></li>
        </ul>
    </nav>

    <!-- Conteúdo da Página -->
    <div class="container">
        <h1>Adicionar Agendamento</h1>
        <?php if (isset($mensagem)) : ?>
            <p class="error-message"><?= $mensagem ?></p>
        <?php endif; ?>
        <!-- Formulário de Adicionar Agendamento -->
        <form id="reservaForm" action="processa_agendamento.php" method="post">
            <label for="servico">Serviço:</label>
            <select id="servico" name="servico" required>
                <option value="corte">Corte de Cabelo</option>
                <option value="manicure">Manicure</option>
                <option value="massagem">Massagem</option>
                <!-- Adicione mais opções de serviços conforme necessário -->
            </select>
        
            <label for="data">Data:</label>
            <input type="date" id="data" name="data" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
        
            <label for="hora">Hora:</label>
            <select id="hora" name="hora" required>
                <!-- Adicione opções de hora em hora -->
                <?php
                for ($hour = 8; $hour <= 18; $hour++) {
                    echo "<option value='$hour:00'>$hour:00</option>";
                }
                ?>
            </select>
        
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
        
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
        
            <input type="submit" value="Agendar">
        </form>
        
    </div>


    <script>
        // Verificar data atual e ajustar opções de hora
        var dataInput = document.getElementById('data');
        var horaSelect = document.getElementById('hora');
        var dataAtual = new Date();

        dataInput.addEventListener('change', function() {
            var dataSelecionada = new Date(this.value);
            var horaAtual = dataAtual.getHours();

            // Restrição: Não reservar datas passadas
            if (dataSelecionada < dataAtual) {
                alert('Por favor, selecione uma data futura.');
                this.value = '';
            }

            // Restrição: Não reservar aos domingos
            if (dataSelecionada.getDay() === 0 || dataSelecionada.getDay() === 6) {
                alert('Desculpe, não aceitamos reservas aos domingos.');
                this.value = '';
            }

            // Se a data selecionada for igual à data atual
            if (dataSelecionada.getDate() === dataAtual.getDate() && dataSelecionada.getMonth() === dataAtual.getMonth() && dataSelecionada.getFullYear() === dataAtual.getFullYear()) {
                // Ajustar opções de hora para começar a partir da próxima hora
                while (horaSelect.firstChild) {
                    horaSelect.removeChild(horaSelect.firstChild);
                }
                for (var hour = horaAtual + 1; hour <= 18; hour++) {
                    var option = document.createElement('option');
                    option.value = hour + ':00';
                    option.textContent = hour + ':00';
                    horaSelect.appendChild(option);
                }
            } else {
                // Reseta opções de hora para o horário padrão (8h às 18h)
                while (horaSelect.firstChild) {
                    horaSelect.removeChild(horaSelect.firstChild);
                }
                for (var hour = 8; hour <= 18; hour++) {
                    var option = document.createElement('option');
                    option.value = hour + ':00';
                    option.textContent = hour + ':00';
                    horaSelect.appendChild(option);
                }
            }
        });
    </script>

</body>
</html>