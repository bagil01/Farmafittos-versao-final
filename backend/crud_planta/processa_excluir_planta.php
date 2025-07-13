<?php
require_once(dirname(__DIR__, 2) . '/includes/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_planta = $_POST['id_planta'] ?? null;
    $login = trim($_POST['login'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (!$id_planta || empty($login) || empty($senha)) {
        header('Location: ../../admin/pages/gerenciador_plantas.php?erro=campos_obrigatorios');
        exit;
    }

    // Verifica o login e senha do administrador
    $query = "SELECT senha FROM admins WHERE login = ?";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        header('Location: ../../admin/pages/gerenciador_plantas.php?erro=login_invalido');
        exit;
    }

    $admin = $resultado->fetch_assoc();
    if (!password_verify($senha, $admin['senha'])) {
        header('Location: ../../admin/pages/gerenciador_plantas.php?erro=senha_incorreta');
        exit;
    }

    // Soft delete: marca a notícia como "deletada"
    $deleteQuery = "UPDATE plantas SET deletado = 1 WHERE id = ?";
    $stmtDelete = $conexao->prepare($deleteQuery);
    $stmtDelete->bind_param("i", $id_planta);

    if ($stmtDelete->execute()) {
        header('Location: ../../admin/pages/gerenciador_plantas.php?sucesso=excluida');
    } else {
        header('Location: ../../admin/pages/gerenciador_plantas.php?erro=bd');
    }

    $stmtDelete->close();
    $stmt->close();
    $conexao->close();
} else {
    header('Location: ../../admin/pages/gerenciador_plantas.php');
    exit;
}
?>
