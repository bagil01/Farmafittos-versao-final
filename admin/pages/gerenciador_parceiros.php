<?php 
require_once('verifica_login.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Parceiros </title>
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
                <p>Adicionar Parceiros</p>
            </div>

        <?php
        require_once('../../includes/conexao.php');

        $query = "SELECT * FROM parceiros";
        $resultado = $conexao->query($query);
        ?>

        <div class="container-gerenciador">
            <h1>Gerenciador de Parceiros</h1>

            <?php while ($parceiro = $resultado->fetch_assoc()): ?>
                <div class="opcao">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <img src="../../<?php echo htmlspecialchars($parceiro['logo']); ?>" alt="Logo"
                            style="width: 60px; height: 60px; object-fit: contain; border-radius: 8px;">

                        <div>
                            <h2 style="margin: 0;"><?php echo htmlspecialchars($parceiro['nome']); ?></h2>
                           
                        </div>
                    </div>

                    <div class="incons">
                        <i class="fa-solid fa-pen-to-square" onclick='abrirModalEdicao(<?= json_encode($parceiro) ?>)'></i>
                        <i class="fa-solid fa-trash" onclick="abrirModalExclusao(<?= $parceiro['id'] ?>)"></i>
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
            <h2>Cadastrar Novo Parceiro</h2>
            <form id="formCadastro" action="../../backend/crud_parceiro/processa_parceiro.php" method="POST"
                enctype="multipart/form-data">
                <label for="nome">Nome do Parceiro:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="referencia">Link do site:</label>
                <input type="text" id="referencia" name="referencia" required>

                <label for="logo">Adicionar logo:</label>
                <input type="file" name="logo" id="logo" accept="image/*" required>

                <button type="submit" class="botao-salvar">Salvar</button>
            </form>
        </div>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal-overlay" id="modalExcluirParceiro" style="display: none;">
        <div class="modal">
            <span class="fechar-modal" id="fecharModalExcluir">&times;</span>
            <h2>Confirmar Exclusão</h2>
            <p>Digite seu login e senha para confirmar a exclusão do parceiro:</p>

            <form action="../../backend/crud_parceiro/processa_excluir_parceiro.php" method="POST">
                <input type="hidden" name="id_parceiro" id="idParceiroExcluir">

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
            <h2>Editar Parceiro</h2>
            
            <form id="formEdicao" action="../../backend/crud_parceiro/processa_edicao_parceiro.php" method="POST"
                enctype="multipart/form-data">

                <input type="hidden" name="id_parceiro" id="id_parceiro">

                <label for="nome_editar">Nome:</label>
                <input type="text" id="nome_editar" name="nome" required>

                <label for="referencia_editar">Link do site:</label>
                <input type="text" id="referencia_editar" name="referencia" required>

                <label for="logo_editar">Alterar logo:</label>
                <input type="file" name="logo" id="logo_editar">

                <button class="botao-editar" type="submit">Salvar alterações</button>
            </form>
        </div>
    </div>


</body>
<script src="../../admin/js/parceiros/modal_editar.js"></script>
<script src="../../admin/js/parceiros/modal_cadastro.js"></script>
<script src="../../admin/js/parceiros/modal_excluir.js"></script>
<script src="../../admin/js/view_password.js"></script>

</html>