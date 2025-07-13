<?php 
require_once('verifica_login.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de colaboradors </title>
    <link rel="stylesheet" href="../../assets/icons/fontawesome-free-6.5.2-web/css/all.css">
    <link rel="stylesheet" href="../../admin/css/gerenciador.css">
    <link rel="stylesheet" href="../../admin/css/editar_admin.css">

</head>

<body>
    <div class="voltar">
        <a href="gerenciador.php">
            <i class="fa-solid fa-circle-arrow-left"></i>
            VOLTAR
        </a>
    </div>
    <div class="container">
        <div class="container-controle">
            <div class="adicionar-noticia" id="abrirModalNoticia">
                <span>＋</span>
                <p>Adicionar colaboradores</p>
            </div>

            <?php
            require_once('../../includes/conexao.php');

            $query = "SELECT * FROM colaboradores";
            $resultado = $conexao->query($query);
            ?>

            <div class="container-gerenciador">
                <h1>Gerenciador de colaboradores</h1>

                <?php while ($colaborador = $resultado->fetch_assoc()): ?>
                    <div class="opcao">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <img src="../../<?php echo htmlspecialchars($colaborador['foto']); ?>"
                                alt="Foto" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                            <h2><?php echo htmlspecialchars($colaborador['nome']); ?></h2>

                        </div>

                        <div class="incons">
                            <i class="fa-solid fa-pen-to-square"
                                onclick='abrirModalEdicao(<?= json_encode($colaborador, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>)'></i>

                            <i class="fa-solid fa-trash"
                                onclick="abrirModalExclusao(<?php echo $colaborador['id']; ?>)"></i>

                        </div>
                    </div>

                <?php endwhile; ?>
            </div>
        </div>

    </div>


    <!-- Modal Cadastro -->
    <div class="modal-overlay" id="modalCadastro">
        <div class="modal">
            <span class="fechar-modal" id="fecharModalCadastro">&times;</span>
            <h2>Cadastrar Novo colaborador</h2>
            <form id="formCadastro" action="../../backend/crud_colaborador/processa_colaborador.php"
                method="POST" enctype="multipart/form-data">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="formacao">Formação:</label>
                <input type="text" id="formacao" name="formacao" required>

                <label for="curriculo_lattes">Currículo Lattes (URL):</label>
                <input type="url" id="curriculo_lattes" name="curriculo_lattes" required>

                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" required></textarea>

                <label for="foto">Foto:</label>
                <input type="file" id="foto" name="foto" accept="image/*" required>

                <button type="submit" class="botao-salvar">Salvar</button>
            </form>

        </div>
    </div>

    <!-- Modal de Confirmação de Exclusão -->

    <div class="modal-overlay" id="modalExcluirColaborador" style="display: none;">
        <div class="modal">
            <span class="fechar-modal" id="fecharModalExcluir">&times;</span>
            <h2>Confirmar Exclusão</h2>
            <p>Digite seu login e senha para confirmar a exclusão do colaborador:</p>

            <form action="../../backend/crud_colaborador/processa_excluir_colaborador.php"
                method="POST">
                <!-- E este input escondido também: -->
                <input type="hidden" name="id_colaborador" id="idColaboradorExcluir">

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
    
    <!-- Modal Editar -->
    <div class="modal-overlay" id="modalEditar">
        <div class="modal">
            <span class="fechar-modal" id="fecharModalEditar">&times;</span>
            <h2>Editar Colaborador</h2>

            <form id="formEdicao"
                action="../../backend/crud_colaborador/processa_edicao_colaborador.php"
                method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_colaborador" id="id_colaborador">

                <label for="nome_editar">Nome:</label>
                <input type="text" id="nome_editar" name="nome" required>

                <label for="formacao_editar">Formação:</label>
                <input type="text" id="formacao_editar" name="formacao" required>

                <label for="curriculo_lattes_editar">Currículo Lattes:</label>
                <input type="text" id="curriculo_lattes_editar" name="curriculo_lattes" required>

                <label for="descricao_editar">Descrição:</label>
                <textarea id="descricao_editar" name="descricao" required></textarea>

                <label for="foto_editar">Alterar foto:</label>
                <input type="file" name="foto" id="foto_editar" accept="image/*">

                <button class="botao-editar" type="submit">Salvar alterações</button>
            </form>
        </div>
    </div>

</body>
<script src="../../admin/js/colaboradores/modal_editar.js"></script>
<script src="../../admin/js/colaboradores/modal_cadastro.js"></script>
<script src="../../admin/js/colaboradores/modal_exclusao.js"></script>
<script src="../../admin/js/view_password.js"></script>


</html>