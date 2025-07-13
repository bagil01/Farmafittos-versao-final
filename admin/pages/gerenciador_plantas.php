<?php
require_once('../../includes/conexao.php');

$query = "SELECT * FROM plantas WHERE deletado = 0 ORDER BY id DESC";
$resultado = $conexao->query($query);
?>
<?php 
require_once('verifica_login.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gerenciador de Plantas</title>
    <link rel="stylesheet" href="../../assets/icons/fontawesome-free-6.5.2-web/css/all.css" />
    <link rel="stylesheet" href="../../admin/css/gerenciador_eventos.css" />
    <link rel="stylesheet" href="../../admin/css/galeria.css">
    <link rel="stylesheet" href="../../admin/css/editar_eventos.css" />
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
            <div class="adicionar-noticia" id="abrirModalPlanta">
                <span>＋</span>
                <p>Adicionar Planta</p>
            </div>
            <a href="../../admin/pages/lixeira_plantas.php">
                <div class="lixeira">
                    <i class="fa-solid fa-trash"></i>
                    <p>Lixeira</p>

                </div>
            </a>
        </div>

        <div class="container-gerenciador">
            <h1>Gerenciador de Plantas</h1>

            <?php while ($planta = $resultado->fetch_assoc()): ?>
                <div class="opcao">
                    <img src="../../<?php echo $planta['capa']; ?>" alt="Capa"
                        style="width: 60px; height: 60px; object-fit: contain; border-radius: 8px;">

                    <h2><?= htmlspecialchars($planta['nomes_populares']) ?></h2>
                    <div class="incons">
                        <i class="fa-solid fa-images" title="Gerenciar Imagens"
                            onclick="abrirModalImagens(<?= $planta['id'] ?>)"></i>

                        <i class="fa-solid fa-folder" title="Gerenciar Imagens"
                            onclick="abrirModalGaleria(<?= $planta['id'] ?>)"></i>

                        <i class="fa-solid fa-pen-to-square"
                            onclick='abrirModalEditarPlanta(<?= json_encode($planta) ?>)'></i>

                        <i class="fa-solid fa-trash" title="Excluir" onclick="abrirModalExclusao(<?= $planta['id'] ?>)"></i>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Modal Cadastro -->
    <div class="modal-overlay" id="modalCadastroPlanta">
        <div class="modal">
            <span class="fechar-modal" id="fecharModalCadastroPlanta">&times;</span>
            <h2>Cadastrar Nova Planta</h2>
            <form id="formCadastro" action="../../backend/crud_planta/processa_planta.php" method="POST"
                enctype="multipart/form-data">

                <label for="nome_cientifico">Nome Científico:</label>
                <input type="text" id="nome_cientifico" name="nome_cientifico" required />

                <label for="nomes_populares">Nomes Populares:</label>
                <textarea id="nomes_populares" name="nomes_populares" rows="3" required></textarea>

                <label for="usos_populares">Usos Populares e Etnomedicinais:</label>
                <textarea id="usos_populares" name="usos_populares" rows="4" required></textarea>

                <label for="modo_uso">Modo de Uso e Posologia:</label>
                <textarea id="modo_uso" name="modo_uso" rows="4" required></textarea>

                <label for="contraindicacoes">Contraindicações e Advertências:</label>
                <textarea id="contraindicacoes" name="contraindicacoes" rows="4" required></textarea>

                <label for="acoes_farmacologicas">Ações Farmacológicas:</label>
                <textarea id="acoes_farmacologicas" name="acoes_farmacologicas" rows="4" required></textarea>

                <label for="destaque">É destaque?</label>
                <select id="destaque" name="destaque" required>
                    <option value="nao">Não</option>
                    <option value="sim">Sim</option>
                </select>

                <label for="capa">Imagem de Capa:</label>
                <input type="file" name="capa" id="capa" accept="image/*" required>

                <button type="submit" class="botao-salvar">Salvar</button>
            </form>
        </div>
    </div>


    <!-- Modal Exclusão -->
    <div class="modal-overlay" id="modalExcluirPlanta" style="display: none;">
        <div class="modal">
            <span class="fechar-modal" id="fecharModalExcluir">&times;</span>
            <h2>Confirmar Exclusão</h2>
            <p>Digite seu login e senha para confirmar a exclusão:</p>
            <form action="../../backend/crud_planta/processa_excluir_planta.php" method="POST">
                <input type="hidden" name="id_planta" id="idPlantaExcluir">

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

    <!-- Modal de Edição -->
    <div class="modal-overlay" id="modalEditarPlanta" style="display: none;">
        <div class="modal">
            <span class="fechar-modal" id="fecharModalEditarPlanta">&times;</span>
            <h2>Editar Planta Medicinal</h2>

            <form id="formEdicaoPlanta" action="../../backend/crud_planta/processa_edicao_planta.php" method="POST"
                enctype="multipart/form-data">
                <input type="hidden" id="id_planta" name="id_planta">

                <label for="nome_cientifico_editar">Nome Científico:</label>
                <input type="text" id="nome_cientifico_editar" name="nome_cientifico" required>

                <label for="nomes_populares_editar">Nomes Populares:</label>
                <textarea id="nomes_populares_editar" name="nomes_populares" rows="3"></textarea>

                <label for="usos_populares_editar">Usos Populares e Etnomedicinais:</label>
                <textarea id="usos_populares_editar" name="usos_populares" rows="3"></textarea>

                <label for="modo_uso_editar">Modo de Uso e Posologia:</label>
                <textarea id="modo_uso_editar" name="modo_uso" rows="3"></textarea>

                <label for="contraindicacoes_editar">Contraindicações e Advertências:</label>
                <textarea id="contraindicacoes_editar" name="contraindicacoes" rows="3"></textarea>

                <label for="acoes_farmacologicas_editar">Ações Farmacológicas:</label>
                <textarea id="acoes_farmacologicas_editar" name="acoes_farmacologicas" rows="3"></textarea>

                <label for="destaque_editar">É destaque?</label>
                <select id="destaque_editar" name="destaque">
                    <option value="nao">Não</option>
                    <option value="sim">Sim</option>
                </select>

                <label for="capa_editar">Nova capa (opcional):</label>
                <input type="file" name="capa" id="capa_editar" accept="image/*">

                <button type="submit" class="botao-salvar">Salvar Alterações</button>
            </form>
        </div>
    </div>

    <!-- Modal Upload de Imagens -->
    <div class="modal-overlay" id="modalImagens">
        <div class="modal">
            <span class="fechar-modal" id="fecharModalImagens">&times;</span>
            <h2>Adicionar Imagens da Planta</h2>
            <form action="../../backend/crud_planta/upload_imagens.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="plantas_id" id="plantasIdImagens" required>


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
            <h2>Imagens da Planta</h2>

            <div id="conteudoGaleria" class="galeria-imagens">
                <!-- Conteúdo dinâmico será carregado via JS -->
            </div>
        </div>
    </div>

    <!-- Aqui você pode adicionar os scripts como modal_cadastro_plantas.js -->
    <script src="../../admin/js/view_password.js"></script>
    <script src="../../admin/js/plantas/modal_editar.js"></script>
    <script src="../../admin/js/plantas/modal_excluir.js"></script>
    <script src="../../admin/js/plantas/modal_cadastro.js"></script>
    <script src="../../admin/js/plantas/modal_imagens.js"></script>
    <script src="../../admin/js/plantas/modal_galeria.js"></script>
    <script>
    </script>
</body>

</html>