<?php
require_once('../../includes/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_cientifico = trim($_POST['nome_cientifico'] ?? '');
    $nomes_populares = trim($_POST['nomes_populares'] ?? '');
    $usos_populares = trim($_POST['usos_populares'] ?? '');
    $modo_uso = trim($_POST['modo_uso'] ?? '');
    $contraindicacoes = trim($_POST['contraindicacoes'] ?? '');
    $acoes_farmacologicas = trim($_POST['acoes_farmacologicas'] ?? '');
    $destaque = $_POST['destaque'] === 'sim' ? 'sim' : 'nao';

    // Verifica se a imagem foi enviada
    if (isset($_FILES['capa']) && $_FILES['capa']['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION);
        $nome_arquivo = 'uploads/plantas/' . uniqid() . '.' . $extensao;
        $caminho_completo = '../../' . $nome_arquivo;

        // Cria o diretório, se não existir
        if (!is_dir('../../uploads/plantas')) {
            mkdir('../../uploads/plantas', 0777, true);
        }

        if (move_uploaded_file($_FILES['capa']['tmp_name'], $caminho_completo)) {
            // Inserir no banco
            $stmt = $conexao->prepare("INSERT INTO plantas (
                nome_cientifico, nomes_populares, usos_populares, modo_uso, contraindicacoes, acoes_farmacologicas, destaque, capa
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->bind_param(
                'ssssssss',
                $nome_cientifico,
                $nomes_populares,
                $usos_populares,
                $modo_uso,
                $contraindicacoes,
                $acoes_farmacologicas,
                $destaque,
                $nome_arquivo
            );

            if ($stmt->execute()) {
                header('Location: ../../admin/pages/gerenciador_plantas.php?sucesso=1');
                exit;
            } else {
                echo "Erro ao salvar no banco de dados: " . $stmt->error;
            }

        } else {
            echo "Erro ao mover o arquivo de imagem.";
        }
    } else {
        echo "Imagem não enviada ou ocorreu um erro no upload.";
    }

} else {
    echo "Requisição inválida.";
}
