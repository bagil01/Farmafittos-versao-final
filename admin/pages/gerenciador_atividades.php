<?php
require_once('../../includes/conexao.php');

// Seleciona todas as Atividades que NÃO estão na lixeira
$query = "SELECT * FROM atividades WHERE deletado = 0 ORDER BY data_publicacao DESC";
$resultado = $conexao->query($query);

require_once('verifica_login.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gerenciador de Atividades</title>
  <link rel="stylesheet" href="../../assets/icons/fontawesome-free-6.5.2-web/css/all.css" />
  <link rel="stylesheet" href="../../admin/css/gerenciador.css" />
  <link rel="stylesheet" href="../../admin/css/galeria.css">
</head>

<body>
  <div class="voltar">
    <a href="gerenciador.php">
      <i class="fa-solid fa-circle-arrow-left"></i> VOLTAR
    </a>
  </div>

  <div class="container">
    <div class="container-controle">
      <div class="adicionar-noticia" id="abrirModalNoticia">
        <span>＋</span>
        <p>Adicionar Atividade</p>
      </div>

      <a href="../../admin/pages/lixeira_atividades.php">
        <div class="lixeira">
          <i class="fa-solid fa-trash"></i>
          <p>Lixeira</p>
        </div>
      </a>
    </div>

    <div class="container-gerenciador">
      <h1>Gerenciador de Atividades</h1>

      <?php while ($atividade = $resultado->fetch_assoc()): ?>
        <div class="opcao">
          <?php if (!empty($atividade['capa'])): ?>
            <img src="../../<?php echo $atividade['capa']; ?>" alt="Capa"
              style="width: 60px; height: 60px; object-fit: contain; border-radius: 10px; padding: 5px;">
          <?php endif; ?>
          <h2><?= htmlspecialchars($atividade['titulo']) ?></h2>
          <div class="incons">
            <i class="fa-solid fa-images" title="Gerenciar Imagens"
              onclick="abrirModalImagens(<?= $atividade['id'] ?>)"></i>

            <i class="fa-solid fa-folder" title="Ver Galeria" onclick="abrirModalGaleria(<?= $atividade['id'] ?>)"></i>

            <i class="fa-solid fa-pen-to-square" onclick='abrirModalEdicaoAtividade(<?= json_encode($atividade) ?>)'></i>

            <i class="fa-solid fa-trash" title="Excluir" onclick="abrirModalExclusao(<?= $atividade['id'] ?>)"></i>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
  <!-- Modal Cadastro -->
  <div class="modal-overlay" id="modalCadastro">
    <div class="modal">
      <span class="fechar-modal" id="fecharModal">&times;</span>
      <h2>Cadastrar Nova Atividade</h2>
      <form id="formCadastro" action="../../backend/crud_atividade/processa_atividade.php"
        method="POST" enctype="multipart/form-data">

        <label for="titulo">Título da Atividade:</label>
        <input type="text" id="titulo" name="titulo" required />

        <label for="capa">Capa (imagem principal):</label>
        <input type="file" name="capa" id="capa" accept="image/*" required>

        <label for="data">Data de Publicação:</label>
        <input type="date" id="data" name="data" required />

        <label for="destaque">É destaque?</label>
        <select id="destaque" name="destaque">
          <option value="nao">Não</option>
          <option value="sim">Sim</option>
        </select>

        <label for="conteudo">Conteúdo:</label>
        <textarea id="conteudo" name="conteudo" rows="5" required></textarea>

        <button type="submit" class="botao-salvar">Salvar</button>
      </form>
    </div>
  </div>

  <!-- Modal de Edição -->
  <div class="modal-overlay" id="modalEditarAtividade" style="display: none;">
    <div class="modal">
      <span class="fechar-modal" id="fecharModalEditarAtividade">&times;</span>
      <h2>Editar Atividade</h2>

      <form id="formEdicaoAtividade"
        action="../../backend/crud_atividade/processa_edicao_atividade.php" method="POST"
        enctype="multipart/form-data">
        <input type="hidden" id="id_atividade" name="id_atividade">

        <label for="titulo_editar">Título da Atividade:</label>
        <input type="text" id="titulo_editar" name="titulo" required>

        <label for="capa">Nova capa (opcional):</label>
        <input type="file" name="capa" id="capa" accept="image/*">

        <label for="data_editar">Data de Publicação:</label>
        <input type="datetime-local" id="data_editar" name="data" required>

        <label for="destaque_editar">É destaque?</label>
        <select id="destaque_editar" name="destaque">
          <option value="nao">Não</option>
          <option value="sim">Sim</option>
        </select>

        <label for="conteudo_editar">Conteúdo:</label>
        <textarea id="conteudo_editar" name="conteudo" rows="5" required></textarea>

        <button type="submit" class="botao-salvar">Salvar Alterações</button>
      </form>
    </div>
  </div>

  <!-- Modal de Exclusão -->
  <div class="modal-overlay" id="modalExcluirAtividade" style="display: none;">
    <div class="modal">
      <span class="fechar-modal" id="fecharModalExcluir">&times;</span>
      <h2>Confirmar Exclusão</h2>
      <p>Digite seu login e senha para confirmar a exclusão da atividade:</p>

      <form action="../../backend/crud_atividade/processa_excluir_atividade.php" method="POST">
        <input type="hidden" name="id_atividade" id="idAtividadeExcluir">

        <label for="loginExcluir">Login:</label>
        <input type="text" name="login" id="loginExcluir" required>

        <label for="senhaExcluir">Senha:</label>
        <div style="position: relative;">
          <input type="password" name="senha" id="senhaExcluir" required>
          <i class="fa-solid fa-eye toggle-password" data-target="senhaExcluir"
            style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
        </div>

        <button type="submit" class="botao-salvar" style="margin-top: 15px;">Confirmar Exclusão</button>
      </form>
    </div>
  </div>

  <!-- Modal Upload de Imagens -->
  <div class="modal-overlay" id="modalImagens">
    <div class="modal">
      <span class="fechar-modal" id="fecharModalImagens">&times;</span>
      <h2>Adicionar Imagens</h2>
      <form action="../../backend/crud_atividade/upload_imagens.php" method="POST"
        enctype="multipart/form-data">
        <input type="hidden" name="id_atividade" id="idAtividadeImagens">

        <label for="imagens">Selecione as imagens:</label>
        <input type="file" name="imagens[]" id="imagens" multiple accept="image/*" required>

        <button type="submit" class="botao-salvar">Enviar</button>
      </form>
    </div>
  </div>

  <!-- Modal Galeria de Imagens -->
  <div class="modal-overlay" id="modalGaleriaImagens" style="display: none;">
    <div class="modal">
      <span class="fechar-modal" id="fecharModalGaleria">&times;</span>
      <h2>Imagens da Atividade</h2>

      <div id="conteudoGaleria" class="galeria-imagens">
        <!-- Conteúdo dinâmico será carregado via JS -->
      </div>
    </div>
  </div>

  <script src="../../admin/js/gerenciador.js"></script>
  <script src="../../admin/js/atividades/modal_editar.js"></script>
  <script src="../../admin/js/atividades/modal_galeria.js"></script>
  <script src="../../admin/js/atividades/modal_cadastro.js"></script>
  <script src="../../admin/js/atividades/modal_excluir.js"></script>
  <script src="../../admin/js/atividades/modal_imagens.js"></script>
  <script src="../../admin/js/view_password.js"></script>
</body>

</html>