<?php
require_once(__DIR__ . '/../includes/conexao.php');

// Busca colaboradores
$sqlColaboradores = "SELECT * FROM colaboradores ORDER BY nome ASC";
$resultColaboradores = $conexao->query($sqlColaboradores);

// Busca voluntários
$sqlVoluntarios = "SELECT * FROM voluntarios ORDER BY nome ASC";
$resultVoluntarios = $conexao->query($sqlVoluntarios);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colaboradores</title>
    <link rel="stylesheet" href="../assets/css/colaboradores.css">
    <link rel="stylesheet" href="../assets/css/voluntarios.css">
    <link rel="stylesheet" href="../assets/icons/fontawesome-free-6.5.2-web/css/all.css">

    <?php include '../includes/header.php'; ?>
</head>

<body>
    <div class="container">
        <div class="container-titulo">
            <h1>Colaboradores</h1>
        </div>

        <div class="container-colaborador">
            <?php if ($resultColaboradores->num_rows > 0): ?>
                <?php while ($colaborador = $resultColaboradores->fetch_assoc()): ?>
                    <div class="card-colaborador">
                        <img src="../<?= htmlspecialchars($colaborador['foto']) ?>"
                            alt="<?= htmlspecialchars($colaborador['nome']) ?>">
                        <h2 class="nome"><?= htmlspecialchars($colaborador['nome']) ?></h2>
                        <h3 class="Formação"><?= htmlspecialchars($colaborador['formacao']) ?></h3>

                        <a href="<?= htmlspecialchars($colaborador['curriculo_lattes']) ?>" target="_blank">
                            <i class="fa-solid fa-caret-right"></i>
                            Currículo Lattes
                            <i class="fa-solid fa-caret-left"></i>
                        </a>

                        <p id="resumo-<?= $colaborador['id'] ?>">
                            <?= nl2br(htmlspecialchars(mb_strimwidth($colaborador['descricao'], 0, 200, '...'))) ?>
                        </p>

                        <div id="completo-<?= $colaborador['id'] ?>" style="display: none;">
                            <p><?= nl2br(htmlspecialchars($colaborador['descricao'])) ?></p>
                        </div>

                        <button onclick="toggleTexto(<?= $colaborador['id'] ?>)">Ver mais</button>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="text-align: center; padding: 150px;">Nenhum colaborador cadastrado.</p>
            <?php endif; ?>
        </div>


        <div class="container-titulo">
            <h1>voluntarios</h1>
        </div>
        <div class="container-voluntarios">
            <i class="fa-solid fa-angle-left" id="prev"></i>
            <div class="carousel">
                <div class="cards-wrapper">
                    <?php if ($resultVoluntarios->num_rows > 0): ?>
                        <?php while ($voluntario = $resultVoluntarios->fetch_assoc()): ?>
                            <div class="card-voluntarios">
                                <img src="../<?= htmlspecialchars($voluntario['foto']) ?>"
                                    alt="<?= htmlspecialchars($voluntario['nome']) ?>">
                                <h1><?= htmlspecialchars($voluntario['nome']) ?></h1>
                                <a href="<?= htmlspecialchars($voluntario['curriculo_lattes']) ?>" target="_blank">Currículo
                                    Lattes</a>
                                <h3><?= htmlspecialchars($voluntario['curso']) ?></h3>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p style="text-align: center; width: 100%; padding: 100px;">Nenhum voluntário cadastrado.</p>
                    <?php endif; ?>
                </div>
            </div>
            <i class="fa-solid fa-chevron-right" id="next"></i>
        </div>

        <script src="../assets/js/colaboradores/voluntarios.js"></script>
        <script src="../assets/js/colaboradores/colaboradores.js"></script>

        <?php include '../includes/footer.php'; ?>
</body>

</html>