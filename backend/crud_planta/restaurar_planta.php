<?php
require_once(dirname(__DIR__, 2) . '/includes/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_planta'] ?? null;

    if (!$id) {
        header('Location: ../../admin/pages/lixeira_plantas.php?erro=id_invalido');
        exit;
    }

    $sql = "UPDATE plantas SET deletado = 0 WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header('Location: ../../admin/pages/lixeira_plantas.php?sucesso=restaurada');
}
