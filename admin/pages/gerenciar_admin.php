
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador</title>
    <link rel="stylesheet" href="../../assets/icons/fontawesome-free-6.5.2-web/css/all.css">
    <link rel="stylesheet" href="../../admin/css/gerenciador.css">
    <link rel="stylesheet" href="../../admin/css/editar_admin.css">
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
                <p>Adicionar Administrador</p>
            </div>
            <div class="container-gerenciador">
                <h1>Gerenciador de Administradores</h1>

                <?php
                require_once('../../includes/conexao.php');
                $query = "SELECT * FROM admins";
                $resultado = $conexao->query($query);
                while ($admin = $resultado->fetch_assoc()) {
                    $foto = !empty($admin['foto']) ? '../../' . htmlspecialchars($admin['foto']) : '../../assets/photos/user-default.jpg';

                    echo '<div class="opcao">';
                    echo '<div style="display: flex; align-items: center; gap: 10px;">';
                    echo '<img src="' . $foto . '" alt="Foto" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">';
                    echo '<div>';
                    echo '<h2 style="margin: 0;">' . htmlspecialchars($admin['nome']) . '</h2>';
                    echo '<p style="margin: 0; font-size: 0.9em; color: #555;">' . htmlspecialchars($admin['login']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="incons">';
                    echo '<a href="#' . $admin['id'] . '">';
                    echo '<i class="fa-solid fa-pen-to-square" onclick=\'abrirModalEdicao(' . json_encode($admin) . ')\'></i>';
                    echo '</a>';
                    echo '<a href="#' . $admin['id'] . '">';
                    echo '<i class="fa-solid fa-trash" onclick="abrirModalExclusao(' . $admin['id'] . ')"></i>';
                    echo '</a>';
                    echo '</div>';
                    echo '</div>';


                }
                ?>
            </div>
        </div>


        <!-- Modal de Cadastro-->
        <div class="modal-overlay" id="modalCadastro">
            <div class="modal">
                <span class="fechar-modal" id="fecharModal">&times;</span>
                <h2>Cadastrar Novo Administrador</h2>

                <form id="formCadastro" action="../../backend/crud_admin/processa_admin.php" method="POST"
                    enctype="multipart/form-data">
                    <label for="Nome">Nome:</label>
                    <input type="text" id="nome" name="Nome" required>

                    <label for="login">Login gerado:</label>
                    <input type="text" id="login" name="Login" readonly style="background-color: #e9ecef;">

                    <label for="Senha">Senha</label>
                    <div style="position: relative;">
                        <input type="password" name="Senha" id="senha" required>
                        <i class="fa-solid fa-eye toggle-password" data-target="senha"
                            style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                    </div>

                    <label for="Confirmar_senha">Confirmar senha</label>
                    <div style="position: relative;">
                        <input type="password" id="Confirmar_senha" name="Confirmar_senha" required>
                        <i class="fa-solid fa-eye toggle-password" data-target="Confirmar_senha"
                            style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                    </div>

                    <label for="foto">Adicionar foto</label>
                    <input type="file" name="foto" id="foto">

                    <button type="submit" class="botao-salvar">Salvar</button>
                </form>
            </div>
        </div>


        <?php if (isset($_GET['erro']) && $_GET['erro'] === 'senha_fraca'): ?>
            <div
                style="background-color: #ffdddd; color: #a94442; border: 1px solid #a94442; padding: 10px; margin: 15px; border-radius: 5px;">
                ⚠️ A senha deve ter entre <strong>6 e 10 caracteres</strong>, conter <strong>letras</strong>,
                <strong>números</strong> e pelo menos <strong>um caractere especial</strong>.
            </div>
        <?php endif; ?>


        <!-- Modal de confirmação de exclusão -->
        <div class="modal-overlay" id="modalConfirmarExclusao" style="display: none;">
            <div class="modal">
                <span class="fechar-modal" onclick="fecharModalExclusao()">&times;</span>
                <h2>Confirmar Exclusão</h2>
                <p>Digite seu login e senha para confirmar a exclusão:</p>

                <form action="../../backend/crud_admin/excluir_admin.php" method="POST">
                    <input type="hidden" id="idAdminExcluir" name="id_admin">

                    <label for="loginConfirmacao">Login:</label>
                    <input type="text" id="loginConfirmacao" name="login" required>

                    <label for="senhaConfirmacao">Senha:</label>
                    <div style="position: relative;">
                        <input type="password" id="senhaConfirmacao" name="senha" required>
                        <i class="fa-solid fa-eye toggle-password" data-target="senhaConfirmacao"
                            style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                    </div>

                    <button type="submit" class="botao-salvar" style="margin-top: 10px;">Confirmar Exclusão</button>
                </form>
            </div>
        </div>

        <!-- Modal de Edição-->
        <div class="modal-overlay" id="modalEditarCadastro" style="display: none;">
            <div class="modal">
                <span class="fechar-modal" onclick="fecharModalEdicao()">&times;</span>
                <h2>Editar Administrador</h2>

                <form id="formEdicao" action="../../backend/crud_admin/processa_edicao_admin.php" method="POST"
                    enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $admins['id']; ?>">

                    <input type="hidden" id="idAdmin" name="id">

                    <label for="nomeEdicao">Nome:</label>
                    <input type="text" id="nomeEdicao" name="Nome" required>

                    <label for="loginEdicao">Login:</label>
                    <input type="text" id="loginEdicao" name="Login" readonly>

                    <label for="Senha">Senha</label>
                    <div style="position: relative;">
                        <input type="password" name="Senha" id="senha" required>
                        <i class="fa-solid fa-eye toggle-password" data-target="senha"
                            style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                    </div>

                     <label for="senhaConfirmacao">Senha:</label>
                    <div style="position: relative;">
                        <input type="password" id="senhaConfirmacao" name="senha" required>
                        <i class="fa-solid fa-eye toggle-password" data-target="senhaConfirmacao"
                            style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                    </div>

                    <label for="fotoEdicao">Alterar foto:</label>
                    <input type="file" name="foto" id="fotoEdicao">

                    <button class="botao-editar" type="submit">Salvar alterações</button>
                </form>
            </div>
        </div>

        <!--scripts-->
        <script src="../../admin/js/gerenciador.js"></script>
        <script src="../../admin/js/view_password.js"></script>
        
        <script src="../../admin/js/admins/modal_exclusao.js"></script>
        <script src="../../admin/js/admins/modal_editar.js"></script>
        <script src="../../admin/js/admins/generation_login.js"></script>


</body>

</html>