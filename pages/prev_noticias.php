<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prévia das Notícias</title>
    <link rel="stylesheet" href="../assets/css/filtro.css">
    <link rel="stylesheet" href="../assets/css/prev_noticias.css">
    <link rel="stylesheet" href="../assets/icons/fontawesome-free-6.5.2-web/css/all.css">
    <?php include '../includes/header.php'; ?>
</head>

<body>
<?php
require_once(__DIR__ . '/../includes/conexao.php');

$buscar = trim($_GET['buscar'] ?? '');
$ordem = strtolower($_GET['ordem'] ?? 'desc'); // padrão: recentes
$ordem = ($ordem === 'asc') ? 'ASC' : 'DESC';

$sql = "SELECT id, titulo, capa, data_publicacao, conteudo 
        FROM noticias 
        WHERE deletado = 0";

if (!empty($buscar)) {
    $sql .= " AND titulo LIKE ?";
    $sql .= " ORDER BY data_publicacao $ordem";
    $stmt = $conexao->prepare($sql);
    $param = '%' . $buscar . '%';
    $stmt->bind_param('s', $param);
} else {
    $sql .= " ORDER BY data_publicacao $ordem";
    $stmt = $conexao->prepare($sql);
}

$stmt->execute();
$resultado = $stmt->get_result();
?>

<div class="container">
    <div class="mobile-buttons">
        <button onclick="openModal('modalSearch')"><i class="fa-solid fa-magnifying-glass"></i></button>
        <button onclick="openModal('modalFilter')"><i class="fa-solid fa-compass"></i></button>
    </div>

    <div class="container-left">
        <?php if ($resultado->num_rows === 0): ?>
            <p style="text-align:center; padding: 150px;">Nenhuma notícia encontrada.</p>
        <?php endif; ?>

        <?php while ($noticia = $resultado->fetch_assoc()): ?>
            <div class="container-noticias">
                <div class="container-img">
                    <img src="../<?= htmlspecialchars($noticia['capa']) ?>" alt="Capa da Notícia">
                </div>
                <div class="container-text">
                    <h1 class="titulo"><?= htmlspecialchars($noticia['titulo']) ?></h1>
                    <h2 class="data">
                        <i class="fa-solid fa-calendar-days"></i>
                        <?= date('d/m/Y', strtotime($noticia['data_publicacao'])) ?>
                    </h2>
                    <p class="previa-conteudo">
                        <?= nl2br(htmlspecialchars(mb_strimwidth($noticia['conteudo'], 0, 300, '...'))) ?>
                    </p>
                    <a href="noticia.php?id=<?= $noticia['id'] ?>" class="btn-ver-mais">Ver Mais</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="container-right">
        <div class="container-seach">
            <h1>Pesquisar</h1>
            <form method="GET" action="prev_noticias.php">
                <div class="input-seach">
                    <input type="search" name="buscar" placeholder="Pesquisa por título" value="<?= htmlspecialchars($buscar) ?>">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
        </div>

        <div class="container-filter">
            <h1>Filtrar</h1>
            <div class="card-filter">
                <form method="GET" action="prev_noticias.php">
                    <input type="hidden" name="ordem" value="desc">
                    <input type="hidden" name="buscar" value="<?= htmlspecialchars($buscar) ?>">
                    <h2 onclick="this.closest('form').submit()">Recentes</h2>
                </form>

                <form method="GET" action="prev_noticias.php">
                    <input type="hidden" name="ordem" value="asc">
                    <input type="hidden" name="buscar" value="<?= htmlspecialchars($buscar) ?>">
                    <h2 onclick="this.closest('form').submit()">Antigas</h2>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pesquisa -->
<div id="modalSearch" class="modalPesquisa">
    <div class="modal-content-pesquisa">
        <span class="close" onclick="closeModal('modalSearch')">&times;</span>
        <div class="container-seach-modal">
            <h1>Pesquisar Notícia</h1>
            <form method="GET" action="prev_noticias.php">
                <div class="input-seach-modal">
                    <input type="text" name="buscar" placeholder="Digite para buscar...">
                    <button type="submit">Pesquisar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Filtros -->
<div id="modalFilter" class="modalFiltro">
    <div class="modal-content-filtro">
        <span class="close" onclick="closeModal('modalFilter')">&times;</span>
        <div class="container-filter-modal">
            <h1>Filtros</h1>
            <div class="card-filter-modal">
                <form method="GET" action="prev_noticias.php">
                    <input type="hidden" name="ordem" value="desc">
                    <input type="hidden" name="buscar" value="<?= htmlspecialchars($buscar) ?>">
                    <h2 onclick="this.closest('form').submit()">Recentes</h2>
                </form>

                <form method="GET" action="prev_noticias.php">
                    <input type="hidden" name="ordem" value="asc">
                    <input type="hidden" name="buscar" value="<?= htmlspecialchars($buscar) ?>">
                    <h2 onclick="this.closest('form').submit()">Antigas</h2>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../assets/js/filtro.js"></script>
<?php include '../includes/footer.php'; ?>
</body>
</html>
