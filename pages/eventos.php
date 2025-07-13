<?php
require_once(__DIR__ . '/../includes/conexao.php');
include '../includes/header.php';

$sql = "SELECT * FROM eventos ORDER BY data_evento DESC";
$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
    <link rel="stylesheet" href="../assets/icons/fontawesome-free-6.5.2-web/css/all.css">
    <link rel="stylesheet" href="../assets/css/eventos.css">
</head>

<body>

    <div class="container">
        <?php if ($resultado->num_rows > 0): ?>
            <?php while ($evento = $resultado->fetch_assoc()): ?>
                <?php
                // Formatando data e hora
                setlocale(LC_TIME, 'pt_BR.utf8', 'portuguese');
                $data = date('d', strtotime($evento['data_evento'])) . ' de ' .
                    strftime('%B', strtotime($evento['data_evento']));
                $hora = date('H:i', strtotime($evento['hora']));
                ?>
                <div class="item-container">
                    <div class="img-container">
                        <img src="../<?= htmlspecialchars($evento['capa']) ?>" alt="Imagem do Evento">
                    </div>
                    <div class="body-container">
                        <div class="overlay"></div>
                        <div class="event-info">
                            <p class="title"><?= htmlspecialchars($evento['titulo']) ?></p>
                            <div class="separator"></div>

                            <?php if (!empty($evento['formulario_inscricao'])): ?>
                                <a href="<?= htmlspecialchars($evento['formulario_inscricao']) ?>" target="_blank">
                                    <i class="fa-solid fa-caret-right"></i>
                                    Formulário de inscrição
                                    <i class="fa-solid fa-caret-left"></i>
                                </a>
                            <?php else: ?>
                                <p style="font-style: italic; color: #a43c2a; margin: 10px 0;">
                                    <i class="fa-regular fa-circle-xmark"></i>
                                    Não há formulário de inscrição
                                </p>
                            <?php endif; ?>


                            <p class="price">Entrada: <?= htmlspecialchars($evento['ingresso']) ?></p>

                            <div class="additional-info">
                                <?php if (!empty($evento['link_maps'])): ?>
                                    <a href="<?= htmlspecialchars($evento['link_maps']) ?>" target="_blank">
                                        <p class="info " id="local">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <?= htmlspecialchars($evento['localizacao']) ?>
                                        </p>
                                    </a>
                                <?php endif; ?>

                                <p class="info">
                                    <i class="far fa-calendar-alt"></i>
                                    <?= $data ?>, <?= $hora ?> Hr
                                </p>

                                <p class="info description"><?= nl2br(htmlspecialchars($evento['descricao'])) ?></p>

                                <p class="info description">Para mais informações entre em contato:</p>
                                <div class="contatos">
                                    <?php if (!empty($evento['instagram'])): ?>
                                        <a href="<?= htmlspecialchars($evento['instagram']) ?>" target="_blank">
                                            <i class="fa-brands fa-instagram"></i> Instagram
                                        </a>
                                    <?php endif; ?>

                                    <?php if (!empty($evento['whatsapp'])): ?>
                                        <a href="https://wa.me/<?= htmlspecialchars($evento['whatsapp']) ?>" target="_blank">
                                            <i class="fa-brands fa-whatsapp"></i> WhatsApp
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center;padding: 150px;">Nenhum evento encontrado.</p>
        <?php endif; ?>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>

</html>