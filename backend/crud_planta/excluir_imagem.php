
<?php
require_once(dirname(__DIR__, 2) . '/includes/conexao.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_imagem = $_POST['id_imagem'] ?? null;

    if (!$id_imagem) {
        header('Location: ../../admin/pages/gerenciador_plantas.php?erro=id_imagem');
        exit;
    }

    $consulta = $conexao->prepare("SELECT caminho FROM fotos_plantas WHERE id = ?");
    $consulta->bind_param("i", $id_imagem);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado->num_rows === 0) {
        header('Location: ../../admin/pages/gerenciador_plantas.php?erro=imagem_nao_encontrada');
        exit;
    }

    $imagem = $resultado->fetch_assoc();
    $caminho = dirname(__DIR__, 2) . '/' . $imagem['caminho'];

    $delete = $conexao->prepare("DELETE FROM fotos_plantas WHERE id = ?");
    $delete->bind_param("i", $id_imagem);

    if ($delete->execute()) {
        if (file_exists($caminho)) {
            unlink($caminho);
        }
        header('Location: ../../admin/pages/gerenciador_plantas.php?sucesso=imagem_excluida');
    } else {
        header('Location: ../../admin/pages/gerenciador_plantas.php?erro=erro_excluir_imagem');
    }

    $consulta->close();
    $delete->close();
    $conexao->close();
} else {
    header('Location: ../../admin/pages/gerenciador_plantas.php');
    exit;
}
