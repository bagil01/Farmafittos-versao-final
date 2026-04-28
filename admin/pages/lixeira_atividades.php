 <?php
require_once('verifica_login.php');

?>
<?php
require_once('../../includes/conexao.php');

$query = "SELECT * FROM atividades WHERE deletado = 1 ORDER BY data_publicacao DESC";
$resultado = $conexao->query($query);

if (!$resultado) {
    die("Erro na consulta: " . $conexao->error);
}

?>
<?php 
require_once('verifica_login.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Lixeira - Atividades</title>
  <link rel="stylesheet" href="../../assets/icons/fontawesome-free-6.5.2-web/css/all.css">
  <link rel="stylesheet" href="../../admin/css/gerenciador.css">
</head>
<body>
  <div class="voltar">
    <a href="../../admin/pages/gerenciador_atividades.php">
      <i class="fa-solid fa-circle-arrow-left"></i> VOLTAR
    </a>
  </div>

  <div class="container">
    <h1>Lixeira de Atividades</h1>

    <?php if ($resultado->num_rows > 0): ?>
      <?php while ($atividade = $resultado->fetch_assoc()): ?>
        <div class="opcao">
          <h2><?= htmlspecialchars($atividade['titulo']) ?></h2>
          <div class="incons">
            <!-- Botão restaurar -->
            <form method="POST" action="../../backend/crud_atividade/restaurar_atividade.php" style="display:inline;">
              <input type="hidden" name="id_atividade" value="<?= $atividade['id'] ?>">
              <button type="submit" title="Restaurar" style="background:none; border:none; cursor:pointer;">
                <i class="fa-solid fa-rotate-left"></i>
              </button>
            </form>

            <!-- Botão excluir permanente -->
            <form method="POST" action="../../backend/crud_atividade/excluir_definitivo.php" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir permanentemente?');">
              <input type="hidden" name="id_atividade" value="<?= $atividade['id'] ?>">
              <button type="submit" title="Excluir permanentemente" style="background:none; border:none; cursor:pointer; color: red;">
                <i class="fa-solid fa-trash"></i>
              </button>
            </form>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>Nenhuma notícia na lixeira.</p>
    <?php endif; ?>
  </div>
</body>
</html>
