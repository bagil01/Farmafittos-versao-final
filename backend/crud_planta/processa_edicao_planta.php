<?php
require_once('../../includes/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id_planta']);
    $nome_cientifico = trim($_POST['nome_cientifico'] ?? '');
    $nomes_populares = trim($_POST['nomes_populares'] ?? '');
    $usos_populares = trim($_POST['usos_populares'] ?? '');
    $modo_uso = trim($_POST['modo_uso'] ?? '');
    $contraindicacoes = trim($_POST['contraindicacoes'] ?? '');
    $acoes_farmacologicas = trim($_POST['acoes_farmacologicas'] ?? '');
    $destaque = $_POST['destaque'] === 'sim' ? 'sim' : 'nao';

    // Verifica se o usuário enviou nova imagem
    $nova_capa = '';
    if (isset($_FILES['capa']) && $_FILES['capa']['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION);
        $nova_capa = 'uploads/plantas/' . uniqid() . '.' . $extensao;
        $caminho_completo = '../../' . $nova_capa;

        if (!is_dir('../../uploads/plantas')) {
            mkdir('../../uploads/plantas', 0777, true);
        }

        if (!move_uploaded_file($_FILES['capa']['tmp_name'], $caminho_completo)) {
            echo "Erro ao mover o novo arquivo de imagem.";
            exit;
        }
    }

    if ($nova_capa) {
        // Atualiza tudo, inclusive a nova capa
        $sql = "UPDATE plantas SET 
                    nome_cientifico = ?, 
                    nomes_populares = ?, 
                    usos_populares = ?, 
                    modo_uso = ?, 
                    contraindicacoes = ?, 
                    acoes_farmacologicas = ?, 
                    destaque = ?, 
                    capa = ?
                WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param(
            'ssssssssi',
            $nome_cientifico,
            $nomes_populares,
            $usos_populares,
            $modo_uso,
            $contraindicacoes,
            $acoes_farmacologicas,
            $destaque,
            $nova_capa,
            $id
        );
    } else {
        // Atualiza sem alterar a imagem
        $sql = "UPDATE plantas SET 
                    nome_cientifico = ?, 
                    nomes_populares = ?, 
                    usos_populares = ?, 
                    modo_uso = ?, 
                    contraindicacoes = ?, 
                    acoes_farmacologicas = ?, 
                    destaque = ?
                WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param(
            'sssssssi',
            $nome_cientifico,
            $nomes_populares,
            $usos_populares,
            $modo_uso,
            $contraindicacoes,
            $acoes_farmacologicas,
            $destaque,
            $id
        );
    }

    if ($stmt->execute()) {
        header('Location: ../../admin/pages/gerenciador_plantas.php?editado=1');
        exit;
    } else {
        echo "Erro ao atualizar no banco de dados: " . $stmt->error;
    }

} else {
    echo "Requisição inválida.";
}
