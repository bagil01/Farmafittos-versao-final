<?php
require_once('../../includes/conexao.php');
$query = "SELECT * FROM referencias";
$resultado = $conexao->query($query);
?>
<?php 
require_once('verifica_login.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Gerenciador de Referências</title>
    <link rel="stylesheet" href="../../assets/icons/fontawesome-free-6.5.2-web/css/all.css">
    <link rel="stylesheet" href="../../admin/css/gerenciador.css">
    <link rel="stylesheet" href="../../admin/css/editar_eventos.css" />
</head>
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
                <p>Adicionar Referência</p>
            </div>
        </div>

        <div class="container-gerenciador">
            <h1>Gerenciador de Referências</h1>

            <?php while ($ref = $resultado->fetch_assoc()): ?>
                <div class="opcao">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <img src="../../<?php echo htmlspecialchars($ref['logo']); ?>" alt="Logo"
                            style="width: 60px; height: 60px; object-fit: contain; border-radius: 8px;">
                        <div>
                            <h2 style="margin: 0;"><?php echo htmlspecialchars($ref['titulo']); ?></h2>
                        </div>
                    </div>
                    <div class="incons">
                        <i class="fa-solid fa-pen-to-square"
                            onclick='abrirModalEdicao(<?= json_encode($ref, JSON_UNESCAPED_UNICODE) ?>)'></i>

                        <i class="fa-solid fa-trash" onclick="abrirModalExclusao(<?= $ref['id'] ?>)"></i>
                    </div>

                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Modal Cadastro -->
    <div class="modal-overlay" id="modalCadastro">
        <div class="modal">
            <span class="fechar-modal" id="fecharModalCadastro">&times;</span>
            <h2>Cadastrar Nova Referência</h2>

            <form id="formCadastro" action="../../backend/crud_referencia/processa_referencia.php"
                method="POST" enctype="multipart/form-data">

                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required>

                <label for="referencia">Link da referência:</label>
                <input type="text" id="referencia" name="referencia" required>

                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" placeholder="Breve descrição sobre a referência..."
                    required></textarea>

                <label for="logo">Adicionar logo:</label>
                <input type="file" name="logo" id="logo" accept="image/*" required>

                <button type="submit" class="botao-salvar">Salvar</button>
            </form>
        </div>
    </div>

    <!-- Modal Editar -->
    <div class="modal-overlay" id="modalEditar">
        <div class="modal">
            <span class="fechar-modal" id="fecharModalEditar">&times;</span>
            <h2>Editar Referência</h2>

            <form id="formEdicao"
                action="../../backend/crud_referencia/processa_edicao_referencia.php" method="POST"
                enctype="multipart/form-data">
                <input type="hidden" name="id_referencia" id="id_referencia">

                <label for="titulo_editar">Título:</label>
                <input type="text" id="titulo_editar" name="titulo" required>

                <label for="referencia_editar">Link ou texto da referência:</label>
                <input type="text" id="referencia_editar" name="referencia" required>

                <label for="descricao_editar">Descrição:</label>
                <textarea id="descricao_editar" name="descricao" rows="4"
                    placeholder="Descrição da referência..."></textarea>

                <label for="logo_editar">Alterar logo (opcional):</label>
                <input type="file" name="logo" id="logo_editar" accept="image/*">

                <button type="submit" class="botao-editar">Salvar alterações</button>
            </form>
        </div>
    </div>

    <!-- Modal Excluir -->
    <div class="modal-overlay" id="modalExcluirReferencia" style="display: none;">
        <div class="modal">
            <span class="fechar-modal" id="fecharModalExcluir">&times;</span>
            <h2>Confirmar Exclusão</h2>
            <p>Digite seu login e senha para confirmar a exclusão da referencia:</p>

            <form action="../../backend/crud_referencia/processa_excluir_referencia.php"
                method="POST">
                <input type="hidden" name="id_referencia" id="idReferenciaExcluir">

                <label for="loginExcluir">Login:</label>
                <input type="text" name="login" id="loginExcluir" required>

                <label for="senhaExcluir">Senha:</label>
                <div style="position: relative;">
                    <input type="password" name="senha" id="senhaExcluir" required>
                    <i class="fa-solid fa-eye toggle-password" data-target="senhaExcluir"
                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                </div>

                <button type="submit" class="botao-salvar">Confirmar Exclusão</button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../../admin/js/referencias/modal_editar.js"></script>
    <script src="../../admin/js/referencias/modal_cadastro.js"></script>
    <script src="../../admin/js/referencias/modal_excluir.js"></script>
    <script src="../../admin/js/view_password.js"></script>

</body>

</html>