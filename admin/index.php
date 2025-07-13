<?php
session_start();
require_once(__DIR__ . '/../includes/conexao.php');

// Redireciona se já estiver logado
if (isset($_SESSION['admin_id'])) {
    header("Location: ../admin/pages/gerenciador.php");
    exit();
}

// Limite de tentativas (proteção contra brute-force)
if (!isset($_SESSION['tentativas'])) {
    $_SESSION['tentativas'] = 0;
}

if ($_SESSION['tentativas'] >= 5) {
    die("Muitas tentativas de login. Tente novamente mais tarde.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = filter_var(trim($_POST['login'] ?? ''), FILTER_SANITIZE_STRING);
    $senha = trim($_POST['senha'] ?? '');

    if (empty($login) || empty($senha)) {
        $erro = "Preencha todos os campos.";
    } else {
        $stmt = $conexao->prepare("SELECT id, nome, senha FROM admins WHERE login = ?");
        if ($stmt) {
            $stmt->bind_param('s', $login);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows === 1) {
                $admin = $resultado->fetch_assoc();
                if (password_verify($senha, $admin['senha'])) {
                    // Login bem-sucedido
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_nome'] = $admin['nome'];
                    $_SESSION['tentativas'] = 0;
                    header("Location: ../admin/pages/gerenciador.php");
                    exit();
                } else {
                    $_SESSION['tentativas']++;
                    $erro = "Senha incorreta.";
                }
            } else {
                $_SESSION['tentativas']++;
                $erro = "Usuário não encontrado.";
            }
        } else {
            $erro = "Erro ao preparar a consulta: " . $conexao->error;
        }
    }
}
// Suponha que o login foi validado corretamente...
$_SESSION['usuario_logado'] = true;

$erro = '';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Admin</title>
    <link rel="stylesheet" href="./css/index.css">
    <style>
        .mostrar-senha {
            margin-top: 5px;
            font-size: 14px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login Administrativo</h2>
        <?php if ($erro): ?>
            <p class="erro"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>

        <form class="formulario" method="POST">
            <div class="login">
                <label for="login">Login:</label>
                <input type="text" name="login" id="login" placeholder="Login" required>
            </div>

            <div class="senha">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" placeholder="Senha" required>
                <div class="mostrar-senha">
                    <input type="checkbox" id="verSenha" onclick="mostrarSenha()"> Mostrar senha
                </div>
            </div>

            <button type="submit">Entrar</button>
        </form>
    </div>

    <script>
        function mostrarSenha() {
            const inputSenha = document.getElementById('senha');
            inputSenha.type = inputSenha.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>

</html>