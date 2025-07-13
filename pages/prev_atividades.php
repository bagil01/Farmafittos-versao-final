<?php
require_once(__DIR__ . '/../includes/conexao.php');

$sql = "SELECT id, titulo, capa, data_publicacao, conteudo 
        FROM atividades 
        WHERE deletado = 0 
        ORDER BY data_publicacao DESC";

$stmt = $conexao->prepare($sql);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atividades</title>
    <link rel="stylesheet" href="../assets/css/prev_atividades.css">
    <link rel="stylesheet" href="../assets/icons/fontawesome-free-6.5.2-web/css/all.css">
    <?php include '../includes/header.php'; ?>
</head>

<body>
    <div class="container">
        <?php if ($resultado->num_rows === 0): ?>
            <p style="text-align: center; padding: 150px;">Nenhuma atividade encontrada.</p>
        <?php endif; ?>

        <?php while ($atividade = $resultado->fetch_assoc()): ?>
            <div class="card-atividades">
                <div class="card-img">
                    <img src="../<?= htmlspecialchars($atividade['capa']) ?>" alt="Capa da Atividade">
                </div>
                <div class="card-text">
                    <h1><?= htmlspecialchars($atividade['titulo']) ?></h1>
                    <h2>
                        <i class="fa-solid fa-calendar-days"></i>
                        Data: <?= date('d/m/Y', strtotime($atividade['data_publicacao'])) ?>
                    </h2>
                    <p><?= nl2br(htmlspecialchars(mb_strimwidth($atividade['conteudo'], 0, 300, '...'))) ?></p>
                    <div class="link">
                        <a href="atividade.php?id=<?= $atividade['id'] ?>">--------- ver mais ---------</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>

</html>
