<?php
require_once('../../includes/conexao.php');

$id = $_GET['id_planta'] ?? null;
if (!$id) exit('<p>ID inválido.</p>');

$stmt = $conexao->prepare("SELECT * FROM fotos_plantas WHERE planta_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo "<p>Nenhuma imagem encontrada.</p>";
    exit;
}
?>

<?php while ($img = $resultado->fetch_assoc()): ?>
  <div class="img-item" style="margin-bottom: 15px;">
    <img src="../../<?php echo htmlspecialchars($img['caminho']); ?>" alt="Imagem da Planta" style="width: 100px; height: auto; border-radius: 4px;">

    <?php if (!empty($img['descricao'])): ?>
      <p><strong>Descrição:</strong> <?= htmlspecialchars($img['descricao']) ?></p>
    <?php endif; ?>

    <form action="../../backend/crud_planta/excluir_imagem.php" method="POST" style="display:inline;">
     <input type="hidden" name="id_imagem" value="<?= $img['id'] ?>">
      <button type="submit">Excluir</button>
    </form>
  </div>
<?php endwhile; ?>