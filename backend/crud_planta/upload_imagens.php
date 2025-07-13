<?php
require_once(dirname(__DIR__, 2) . '/includes/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $planta_id = $_POST['plantas_id'] ?? null;

    if (!$planta_id || empty($_FILES['imagens']['tmp_name'][0])) {
        header('Location: ../../admin/pages/gerenciador_plantas.php?erro=upload_vazio');
        exit;
    }

    $pastaDestino = dirname(__DIR__, 2) . "/assets/uploads/plantas/";
    if (!is_dir($pastaDestino)) {
        mkdir($pastaDestino, 0755, true);
    }

    foreach ($_FILES['imagens']['tmp_name'] as $index => $tmpName) {
        $nomeOriginal = $_FILES['imagens']['name'][$index];
        $extensao = pathinfo($nomeOriginal, PATHINFO_EXTENSION);
        $nomeArquivo = uniqid('planta_', true) . '.' . $extensao;
        $caminho = "assets/uploads/plantas/" . $nomeArquivo;

        if (move_uploaded_file($tmpName, $pastaDestino . $nomeArquivo)) {
            $stmt = $conexao->prepare("INSERT INTO fotos_plantas (planta_id, caminho) VALUES (?, ?)");

            if (!$stmt) {
                die("Erro ao preparar statement: " . $conexao->error);
            }

            $stmt->bind_param("is", $planta_id, $caminho);
            $stmt->execute();
            $stmt->close();
        }
    }

    $conexao->close();
    header("Location: ../../admin/pages/gerenciador_plantas.php?sucesso=imagens_enviadas");
}
?>
