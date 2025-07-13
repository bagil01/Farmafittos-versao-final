<?php
require_once('../../includes/conexao.php');

$query = "SELECT * FROM plantas WHERE deletado = 1 ORDER BY id DESC";
$resultado = $conexao->query($query);

if (!$resultado) {
    die("Erro na consulta: " . $conexao->error);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Lixeira - Plantas</title>
  <link rel="stylesheet" href="../../assets/icons/fontawesome-free-6.5.2-web/css/all.css">
  <link rel="stylesheet" href="../../admin/css/gerenciador.css">
</head>
<body>
  <div class="voltar">
    <a href="../../admin/pages/gerenciador_Plantas.php">
      <i class="fa-solid fa-circle-arrow-left"></i> VOLTAR
    </a>
  </div>

  <div class="container">
    <h1>Lixeira de Plantas</h1>

    <?php if ($resultado->num_rows > 0): ?>
      <?php while ($planta = $resultado->fetch_assoc()): ?>
        <div class="opcao">
          <img src="../../<?= htmlspecialchars($planta['capa']) ?>" alt="Capa" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">

          <h2><?= htmlspecialchars($planta['nome_cientifico']) ?></h2>
          <div class="incons">
            <!-- Botão restaurar -->
            <form method="POST" action="../../backend/crud_planta/restaurar_planta.php" style="display:inline;">
              <input type="hidden" name="id_planta" value="<?= $planta['id'] ?>">
              <button type="submit" title="Restaurar" style="background:none; border:none; cursor:pointer;">
                <i class="fa-solid fa-rotate-left"></i>
              </button>
            </form>

            <!-- Botão excluir permanente -->
            <form method="POST" action="../../backend/crud_planta/excluir_definitivo.php" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir permanentemente esta planta?');">
              <input type="hidden" name="id_planta" value="<?= $planta['id'] ?>">
              <button type="submit" title="Excluir permanentemente" style="background:none; border:none; cursor:pointer; color: red;">
                <i class="fa-solid fa-trash"></i>
              </button>
            </form>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>Nenhuma planta na lixeira.</p>
    <?php endif; ?>
  </div>
</body>
</html>
