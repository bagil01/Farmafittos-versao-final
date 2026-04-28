<!-- Botão de adicionar -->
 <?php
require_once('verifica_login.php');

?>
<?php
require_once('../../includes/conexao.php');
$query = "SELECT * FROM referencias";
$resultado = $conexao->query($query);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Gerenciador de Voluntários</title>
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
                <p>Adicionar Voluntário</p>
            </div>

            <?php
            require_once('../../includes/conexao.php');
            $query = "SELECT * FROM voluntarios";
            $resultado = $conexao->query($query);
            ?>

            <div class="container-gerenciador">
                <h1>Gerenciador de Voluntários</h1>

                <?php while ($voluntario = $resultado->fetch_assoc()): ?>
                    <div class="opcao">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <img src="../../<?php echo htmlspecialchars($voluntario['foto']); ?>"
                                alt="Foto" style="width: 50px; height: 50px; object-fit: contain; border-radius: 50%;">
                            <div>
                                <h2 style="margin: 0;"><?php echo htmlspecialchars($voluntario['nome']); ?></h2>
                                <small><?php echo htmlspecialchars($voluntario['curso']); ?></small>
                            </div>
                        </div>

                        <div class="incons">
                            <i class="fa-solid fa-pen-to-square"
                                onclick='abrirModalEdicao(<?= json_encode($voluntario) ?>)'></i>
                            <i class="fa-solid fa-trash" onclick="abrirModalExclusao(<?= $voluntario['id'] ?>)"></i>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <!--modal de cadastro-->
    <div class="modal-overlay" id="modalCadastro">
        <div class="modal">
            <span class="fechar-modal" id="fecharModalCadastro">&times;</span>
            <h2>Cadastrar Novo Voluntário</h2>
            <form id="formCadastro" action="../../backend/crud_voluntario/processa_voluntario.php"
                method="POST" enctype="multipart/form-data">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="curso">Curso:</label>
                <input type="text" id="curso" name="curso" required>

                <label for="curriculo_lattes">Currículo Lattes (URL):</label>
                <input type="url" id="curriculo_lattes" name="curriculo_lattes" required>

                <label for="foto">Foto:</label>
                <input type="file" name="foto" id="foto" accept="image/*" required>

                <button type="submit" class="botao-salvar">Salvar</button>
            </form>
        </div>
    </div>

    <!--modal excluir-->
    <div class="modal-overlay" id="modalExcluirVoluntario" style="display: none;">
        <div class="modal">
            <span class="fechar-modal" id="fecharModalExcluir">&times;</span>
            <h2>Confirmar Exclusão</h2>
            <p>Digite seu login e senha para confirmar a exclusão do Voluntário:</p>
            <form method="POST" action="../../backend/crud_voluntario/processa_excluir_voluntario.php">
                <input type="hidden" name="id_voluntario" id="id_voluntario_excluir">

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

    <!--modal editar-->
    <div class="modal-overlay" id="modalEditar">
        <div class="modal">
            <span class="fechar-modal" id="fecharModalEditar">&times;</span>
            <h2>Editar Voluntário</h2>

            <form id="formEdicao"
                action="../../backend/crud_voluntario/processa_edicao_voluntario.php" method="POST"
                enctype="multipart/form-data">
                <input type="hidden" name="id_voluntario" id="id_voluntario">

                <label for="nome_editar">Nome:</label>
                <input type="text" id="nome_editar" name="nome" required>

                <label for="curso_editar">Curso:</label>
                <input type="text" id="curso_editar" name="curso" required>

                <label for="curriculo_lattes_editar">Currículo Lattes:</label>
                <input type="url" id="curriculo_lattes_editar" name="curriculo_lattes" required>

                <label for="foto_editar">Alterar Foto:</label>
                <input type="file" name="foto" id="foto_editar">

                <button type="submit" class="botao-editar">Salvar alterações</button>
            </form>
        </div>
    </div>

    <script src="../../admin/js/voluntarios/modal_editar.js"></script>
    <script src="../../admin/js/voluntarios/modal_cadastro.js"></script>
    <script src="../../admin/js/voluntarios/modal_exclusao.js"></script>
    <script src="../../admin/js/view_password.js"></script>

</body>

</html>