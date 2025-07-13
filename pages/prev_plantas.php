<?php
require_once(__DIR__ . '/../includes/conexao.php');

$buscar = trim($_GET['buscar'] ?? '');
$filtro = trim($_GET['filtro'] ?? '');

$sql = "SELECT id, nome_cientifico, nomes_populares, usos_populares, capa FROM plantas WHERE deletado = 0";

$params = [];
$tipos = '';

if (!empty($buscar)) {
    $sql .= " AND (nome_cientifico LIKE ? OR nomes_populares LIKE ?)";
    $params[] = "%$buscar%";
    $params[] = "%$buscar%";
    $tipos .= 'ss';
}

if (!empty($filtro)) {
    $sql .= " AND acoes_farmacologicas LIKE ?";
    $params[] = "%$filtro%";
    $tipos .= 's';
}

$stmt = $conexao->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($tipos, ...$params);
}
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Plantas Medicinais</title>
  <link rel="stylesheet" href="../assets/css/filtro.css">
  <link rel="stylesheet" href="../assets/css/prev_noticias.css">
  <link rel="stylesheet" href="../assets/icons/fontawesome-free-6.5.2-web/css/all.css">
  <?php include '../includes/header.php'; ?>
</head>
<body>
<div class="container">
    <div class="mobile-buttons">
        <button onclick="openModal('modalSearch')"><i class="fa-solid fa-magnifying-glass"></i></button>
        <button onclick="openModal('modalFilter')"><i class="fa-solid fa-filter"></i></button>
    </div>

    <div class="container-left">
        <?php if ($resultado->num_rows === 0): ?>
            <p style="text-align:center; padding: 150px;">Nenhuma planta encontrada.</p>
        <?php endif; ?>

        <?php while ($planta = $resultado->fetch_assoc()): ?>
            <div class="container-noticias">
                <div class="container-img">
                    <img src="../<?= htmlspecialchars($planta['capa']) ?>" alt="Imagem da Planta">
                </div>
                <div class="container-text">
                    <h1 class="titulo">Nome Científico: <?= htmlspecialchars($planta['nome_cientifico']) ?></h1>
                    <h2 class="data">Nomes Populares: <?= htmlspecialchars($planta['nomes_populares']) ?></h2>
                    <p class="previa-conteudo">
                        <?= nl2br(htmlspecialchars(mb_strimwidth($planta['usos_populares'], 0, 300, '...'))) ?>
                    </p>
                    <a href="plantas.php?id=<?= $planta['id'] ?>" class="btn-ver-mais">Ver Mais</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="container-right">
        <div class="container-seach">
            <h1>Pesquisar</h1>
            <form method="GET" action="prev_plantas.php">
                <div class="input-seach">
                    <input type="search" name="buscar" placeholder="Nome popular ou científico" value="<?= htmlspecialchars($buscar) ?>">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
        </div>

        <div class="container-filter">
            <h1>Filtrar</h1>
            <div class="card-filter">
                <?php foreach ([
                    'CICATRIZANTE', 
                    'ANTI-INFLAMATÓRIA', 
                    'ANTIMICROBIANA', 
                    'ANTISSÉPTICA', 
                    'ANTIALÉRGICA'
                ] as $f): ?>
                    <form method="GET" action="prev_plantas.php">
                        <input type="hidden" name="filtro" value="<?= $f ?>">
                        <input type="hidden" name="buscar" value="<?= htmlspecialchars($buscar) ?>">
                        <h2 onclick="this.closest('form').submit()"><?= $f ?></h2>
                    </form>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pesquisa -->
<div id="modalSearch" class="modalPesquisa">
    <div class="modal-content-pesquisa">
        <span class="close" onclick="closeModal('modalSearch')">&times;</span>
        <div class="container-seach-modal">
            <h1>Pesquisar Planta</h1>
            <form method="GET" action="prev_plantas.php">
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
                <?php foreach ([
                    'CICATRIZANTE', 
                    'ANTI-INFLAMATÓRIA', 
                    'ANTIMICROBIANA', 
                    'ANTISSÉPTICA', 
                    'ANTIALÉRGICA'
                ] as $f): ?>
                    <form method="GET" action="prev_plantas.php">
                        <input type="hidden" name="filtro" value="<?= $f ?>">
                        <input type="hidden" name="buscar" value="<?= htmlspecialchars($buscar) ?>">
                        <h2 onclick="this.closest('form').submit()"><?= $f ?></h2>
                    </form>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script src="../assets/js/filtro.js"></script>
<?php include '../includes/footer.php'; ?>
</body>
</html>
