<?php
require_once(__DIR__ . '/../includes/conexao.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "ID da planta não informado.";
    exit;
}

$stmt = $conexao->prepare("SELECT * FROM plantas WHERE id = ? AND deletado = 0");
$stmt->bind_param("i", $id);
$stmt->execute();
$planta = $stmt->get_result()->fetch_assoc();

if (!$planta) {
    echo "Planta não encontrada.";
    exit;
}

// Fotos da planta
$stmtFotos = $conexao->prepare("SELECT caminho FROM fotos_plantas WHERE planta_id = ?");
$stmtFotos->bind_param("i", $id);
$stmtFotos->execute();
$fotos = $stmtFotos->get_result();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($planta['nomes_populares']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/icons/fontawesome-free-6.5.2-web/css/all.css" />
    <link rel="stylesheet" href="../assets/css/plantas_integra.css">
</head>

<body>
    <div class="voltar">
        <a href="javascript:history.back()">
            <i class="fa-solid fa-circle-arrow-left"></i> VOLTAR
        </a>
    </div>

    <div class="container">
        <div class="container-conteudo">
            <header style="background-image: url('../<?= htmlspecialchars($planta['capa']) ?>'); ">

                <h1><?= htmlspecialchars($planta['nomes_populares']) ?>
                    <small>(<?= htmlspecialchars($planta['nome_cientifico']) ?>)</small>
                </h1>
            </header>

            <!-- Página 1: Conteúdo -->
            <div class="primeira-pagina pagina" data-pagina="1">
                <section>
                    <h2> Nomes Populares</h2>
                    <p><?= nl2br(htmlspecialchars($planta['nomes_populares'])) ?></p>
                </section>

                <section>
                    <h2> Usos Populares</h2>
                    <p><?= nl2br(htmlspecialchars($planta['usos_populares'])) ?></p>
                </section>

                <section>
                    <h2> Modo de Uso</h2>
                    <p><?= nl2br(htmlspecialchars($planta['modo_uso'])) ?></p>
                </section>

                <section>
                    <h2> Contraindicações</h2>
                    <p><?= nl2br(htmlspecialchars($planta['contraindicacoes'])) ?></p>
                </section>

                <section>
                    <h2>💊 Ações Farmacológicas</h2>
                    <ul>
                        <?php
                        $itens = explode(';', $planta['acoes_farmacologicas']);
                        foreach ($itens as $item) {
                            $item = trim($item);
                            if (!empty($item)) {
                                // Se houver dois-pontos, separar em termo e descrição
                                if (strpos($item, ':') !== false) {
                                    list($termo, $descricao) = explode(':', $item, 2);
                                    echo "<li><strong>" . htmlspecialchars(trim($termo)) . ":</strong> " . htmlspecialchars(trim($descricao)) . "</li>";
                                } else {
                                    echo "<li>" . htmlspecialchars($item) . "</li>";
                                }
                            }
                        }
                        ?>
                    </ul>
                </section>

            </div>

            <!-- Página 2: Mídias -->
            <div class="terceira-pagina pagina" data-pagina="2" style="display: none;">
                <div class="midias">
                    <?php if ($fotos->num_rows > 0): ?>
                        <?php while ($foto = $fotos->fetch_assoc()): ?>
                            <img src="../<?= htmlspecialchars($foto['caminho']) ?>" alt="Imagem da planta">
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p style="text-align: center; width: 100%;">Nenhuma imagem disponível para esta planta.</p>
                    <?php endif; ?>
                </div>
            </div>


            <!-- Botões de Paginação -->
            <div class="paginacao">
                <button class="pagina-btn ativo" data-pagina="1">Pagina 1</button>
                <button class="pagina-btn" data-pagina="2">Mídias</button>
            </div>
        </div>
    </div>

    <!-- Modal da imagem -->
    <div id="modal-foto" style="display:none;">
        <div id="overlay"></div>
        <span id="fechar">&times;</span>
        <img id="imagem-modal" src="" alt="">
        <div id="anterior">&#10094;</div>
        <div id="proximo">&#10095;</div>
    </div>

    <script>
       

        
    </script>
    <script src="../assets/js/planta/alterar_pag.js"></script>
    <script src="../assets/js/planta/tela_cheia.js"></script>
</body>

</html>