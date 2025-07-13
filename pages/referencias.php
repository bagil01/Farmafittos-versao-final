<!DOCTYPE html>
<html lang="pt-Br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Referências</title>
  <link rel="stylesheet" href="../assets/css/referencias.css" />
  <link rel="stylesheet" href="../assets/icons/fontawesome-free-6.5.2-web/css/all.css">
  <?php include '../includes/header.php'; ?>
</head>
<body>
  <?php
    require_once(__DIR__ . '/../includes/conexao.php');

    $sql = "SELECT * FROM referencias";
    $resultado = $conexao->query($sql);
  ?>

  <div class="container">
    <h1>Referências</h1>
    <div class="referencias-grid">

      <?php if ($resultado->num_rows > 0): ?>
        <?php while ($ref = $resultado->fetch_assoc()): ?>
          <div class="card">
            <img src="../<?= htmlspecialchars($ref['logo']) ?>" alt="<?= htmlspecialchars($ref['titulo']) ?>" />
            <div class="card-content">
              <h2><?= htmlspecialchars($ref['titulo']) ?></h2>

              <p>
                <?= nl2br(htmlspecialchars($ref['descricao'])) ?>
                <?php if (filter_var($ref['referencia'], FILTER_VALIDATE_URL)): ?>
                  <br>
                  <a href="<?= htmlspecialchars($ref['referencia']) ?>" target="_blank">Acesse aqui</a>
                <?php endif; ?>
              </p>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p style="text-align:center; padding: 150px;">Nenhuma referência encontrada.</p>
      <?php endif; ?>

    </div>
  </div>

  <?php include '../includes/footer.php'; ?>
</body>

</html>
