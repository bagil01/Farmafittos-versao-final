<?php
require_once('../includes/conexao.php'); // garantir conexão funcionando

$id = intval($_GET['id'] ?? 0);

// Buscar dados da notícia
$stmt = $conexao->prepare("SELECT * FROM noticias WHERE id = ? AND deletado = 0");
if (!$stmt) {
    die("Erro na preparação da consulta de notícia: " . $conexao->error);
}
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$noticia = $resultado->fetch_assoc();

if (!$noticia) {
    die("Notícia não encontrada.");
}

// Buscar mídias da notícia
$query = "SELECT caminho, descricao FROM fotos_noticias WHERE noticia_id = ?";
$stmt_midias = $conexao->prepare($query);
if (!$stmt_midias) {
    die("Erro na preparação da consulta de mídias: " . $conexao->error);
}
$stmt_midias->bind_param("i", $id);
$stmt_midias->execute();
$resultado_midias = $stmt_midias->get_result();


// Buscar duas notícias recomendadas diferentes da atual
$stmt_recomendadas = $conexao->prepare("SELECT id, titulo, capa FROM noticias WHERE id != ? AND deletado = 0 ORDER BY RAND() LIMIT 2");
$stmt_recomendadas->bind_param("i", $id);
$stmt_recomendadas->execute();
$recomendadas = $stmt_recomendadas->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($noticia['titulo']) ?></title>
    <link rel="icon" type="image/png"  href="../assets/favicons/favicon.png">
    <link rel="stylesheet" href="../assets/icons/fontawesome-free-6.5.2-web/css/all.css" />
    <link rel="stylesheet" href="../assets/css/noticias.css">
</head>

<body>
    <div class="voltar">
        <div class="anterior">
            <a href="javascript:history.back()">
                <i class="fa-solid fa-circle-arrow-left"></i> VOLTAR
            </a>
        </div>
        <div class="inicio">
            <a href="../">
                <i class="fas fa-home"></i> INICIO
            </a>
        </div>
    </div>

    <div class="container">
        <!-- Página 1 -->
        <div class="pagina pagina-1">
            <div class="container-noticia">
                <div class="container-conteudo">
                    <h1><?= htmlspecialchars($noticia['titulo']) ?></h1>
                    <h3>Publicado em <?= date('d/m/Y', strtotime($noticia['data_publicacao'])) ?></h3>
                    <section><?= nl2br(htmlspecialchars($noticia['conteudo'])) ?></section>
                </div>

                <!-- Notícias recomendadas -->
                <div class="container-proxima">
                    <h2>Proximas noticias</h2>
                    <div class="cards-noticias">
                        <?php while ($rec = $recomendadas->fetch_assoc()): ?>
                            <div class="card-proxima-noticia">
                                <a href="noticia.php?id=<?= $rec['id'] ?>">
                                    <img src="../<?= htmlspecialchars($rec['capa']) ?>"
                                        alt="Capa da notícia">
                                    <p><?= htmlspecialchars($rec['titulo']) ?></p>
                                </a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Página 2 - Mídias -->
        <div class="pagina pagina-2" style="display: none;">
            <div class="container-midias">
                <section>
                    <div class="midias">
                        <?php if ($resultado_midias->num_rows > 0): ?>
                            <?php while ($midia = $resultado_midias->fetch_assoc()): ?>
                                <img src="../<?= htmlspecialchars($midia['caminho']) ?>"
                                    alt="<?= htmlspecialchars($midia['descricao'] ?? '') ?>">
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p style="text-align:center;">Nenhuma mídia encontrada para esta notícia.</p>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </div>
        
        <!-- Paginação -->
        <div class="paginacao">
            <button class="pagina-btn" data-pagina="1">Página 1</button>
            <button class="pagina-btn" data-pagina="2">Mídias</button>
        </div>
    </div>

    <!-- Modal de Imagem -->
    <div id="modal-foto" style="display:none;">
        <div id="overlay"></div>
        <span id="fechar">&times;</span>
        <img id="imagem-modal" src="" alt="">
        <div id="anterior">&#10094;</div>
        <div id="proximo">&#10095;</div>
    </div>

    <script src="../assets/js/noticia/paginacao.js"></script>
    <script src="../assets/js/noticia/tela_cheia.js"></script>
</body>

</html>