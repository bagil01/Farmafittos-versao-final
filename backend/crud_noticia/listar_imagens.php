<?php
require_once('../../includes/conexao.php');

// Validação segura do ID da notícia
$id = filter_input(INPUT_GET, 'id_noticia', FILTER_VALIDATE_INT);
if (!$id) {
    echo '<p>ID inválido.</p>';
    exit;
}

// Consulta imagens da notícia
$stmt = $conexao->prepare("SELECT id, caminho FROM fotos_noticias WHERE noticia_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

// Caso não haja imagens
if ($resultado->num_rows === 0) {
    echo "<p style='padding: 20px; text-align: center;'>Nenhuma imagem encontrada.</p>";
    exit;
}
?>

<?php while ($img = $resultado->fetch_assoc()): ?>
    <div class="img-item" style="margin: 10px; display: inline-block; text-align: center;">
        <img src="../../<?= htmlspecialchars($img['caminho']) ?>" 
             alt="Imagem da Notícia" 
             style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
        
        <form action="../../backend/crud_noticia/excluir_imagem.php" method="POST" style="margin-top: 8px;">
            <input type="hidden" name="id_imagem" value="<?= $img['id'] ?>">
            <button type="submit" style="background: #c0392b; color: white; border: none; padding: 5px 10px; border-radius: 6px; cursor: pointer;">
                Excluir
            </button>
        </form>
    </div>
<?php endwhile; ?>
