<?php
require_once('verifica_login.php');

?>
<?php
require_once('../../includes/conexao.php');
$query = "SELECT * FROM eventos ORDER BY data_evento DESC";
$resultado = $conexao->query($query);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gerenciador de Eventos</title>
    <link rel="stylesheet" href="../../assets/icons/fontawesome-free-6.5.2-web/css/all.css" />
    <link rel="stylesheet" href="../../admin/css/gerenciador_eventos.css" />
    <link rel="stylesheet" href="../../admin/css/editar_eventos.css" />
</head>

<body>
    <div class="voltar">
        <a href="gerenciador.php">
            <i class="fa-solid fa-circle-arrow-left"></i> VOLTAR
        </a>
    </div>

    <div class="container">
        <div class="container-controle">
            <div class="adicionar-noticia" id="abrirModalEvento">
                <span>＋</span>
                <p>Adicionar Evento</p>
            </div>
        </div>

        <div class="container-gerenciador">
            <h1>Gerenciador de Eventos</h1>

            <?php while ($evento = $resultado->fetch_assoc()): ?>
                <div class="opcao">
                    <div>
                        <img src="../../<?php echo $evento['capa']; ?>" alt="Capa"
                            style="width: 60px; height: 60px; object-fit: contain; border-radius: 8px;">
                        <h2 style="margin: 0;"><?php echo htmlspecialchars($evento['titulo']); ?></h2>
                        <p><?php echo date("d/m/Y", strtotime($evento['data_evento'])) . " às " . substr($evento['hora'], 0, 5); ?>
                        </p>
                    </div>
                    <div class="incons">
                        <i class="fa-solid fa-pen-to-square" onclick='abrirModalEdicao(<?= json_encode($evento) ?>)'></i>
                        <i class="fa-solid fa-trash" onclick="abrirModalExclusao(<?= $evento['id'] ?>)"></i>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Modal Cadastro -->
    <div class="modal-overlay" id="modalCadastro">
        <div class="modal">
            <span class="fechar-modal" id="fecharModalCadastro">&times;</span>
            <h2>Cadastrar Novo Evento</h2>
            <form id="formCadastro" action="../../backend/crud_evento/processa_evento.php"
                method="POST" enctype="multipart/form-data">

                <label>Título:</label>
                <input type="text" name="titulo" required>

                <label>Capa do Evento (imagem):</label>
                <input type="file" name="capa" accept="image/*" required>

                <div class="flex-group">
                    <div>
                        <label>Data:</label>
                        <input type="date" name="data_evento" required>
                    </div>
                    <div>
                        <label>Hora:</label>
                        <input type="time" name="hora" required>
                    </div>
                </div>

                <div class="flex-group">
                    <div>
                        <label>Localização:</label>
                        <input type="text" name="localizacao" placeholder="Nome do Local:" required>
                    </div>
                    <div>
                        <label>link:</label>
                        <input type="text" name="link_maps" placeholder="Link do Google Maps" required>

                    </div>
                </div>

                <label>Descrição:</label>
                <textarea name="descricao" required></textarea>

                <div class="flex-group">
                    <div>
                        <label>Inscrição:</label>
                        <input name="formulario_inscricao" id="formulario_inscricao" placeholder="Link do formulario"
                            required>
                    </div>
                    <div>
                        <label>Ingresso:</label>
                        <input type="text" name="ingresso" id="ingresso_incricao" placeholder="gratis ou 10" required>
                    </div>
                </div>

                <div class="flex-group">
                    <div>
                        <label>WhatsApp:</label>
                        <input type="text" name="whatsapp" required>
                    </div>
                    <div>
                        <label>Instagram (opcional):</label>
                        <input type="text" name="instagram">
                    </div>
                </div>

                <button type="submit" class="botao-salvar">Salvar</button>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="modalExcluirEvento">
        <div class="modal">
            <h2>Confirmar Exclusão</h2>
            <p>Digite seu login e senha para confirmar a exclusão do Evento:</p>
            <span class="fechar-modal" id="fecharModalExcluir">&times;</span>
            <form action="../../backend/crud_evento/processa_excluir_evento.php" method="POST">
                <input type="hidden" name="id_evento" id="idEventoExcluir">
                <!-- Login e senha -->
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


    <<!-- Modal Edição -->
        <div class="modal-overlay" id="modalEditar" style="display: none;">
            <div class="modal">
                <span class="fechar-modal" id="fecharModalEditar">&times;</span>
                <h2>Editar Evento</h2>
                <form id="formEdicao" action="../../backend/crud_evento/processa_edicao_evento.php"
                    method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_evento" id="id_evento">

                    <label>Título:</label>
                    <input type="text" name="titulo" id="titulo_editar" required>

                    <label>Capa do Evento (imagem):</label>
                    <input type="file" name="capa" id="capa_editar" accept="image/*">

                    <div class="flex-group">
                        <div>
                            <label>Data:</label>
                            <input type="date" name="data_evento" id="data_evento_editar" required>
                        </div>
                        <div>
                            <label>Hora:</label>
                            <input type="time" name="hora" id="hora_editar" required>
                        </div>
                    </div>

                    <div class="flex-group">
                        <div>
                            <label>Localização:</label>
                            <input name="localizacao" id="localizacao_editar" placeholder="Nome local" required>
                        </div>
                        <div>
                            <label>Link:</label>
                            <input type="text" name="link_maps" id="link_maps_editar" placeholder="Link do Google Maps"
                                required>
                        </div>
                    </div>

                    <label>Descrição:</label>
                    <textarea name="descricao" id="descricao_editar" required></textarea>

                    <div class="flex-group">
                        <div>
                            <label>Formulário:</label>
                            <input name="formulario_inscricao" id="formulario_editar" placeholder="Link do formulário"
                                required>
                        </div>
                        <div>
                            <label>Ingresso:</label>
                            <input type="text" name="ingresso" id="ingresso_editar" required>
                        </div>
                    </div>

                    <div class="flex-group">
                        <div>
                            <label>WhatsApp:</label>
                            <input type="text" name="whatsapp" id="whatsapp_editar" required>
                        </div>
                        <div>
                            <label>Instagram (opcional):</label>
                            <input type="text" name="instagram" id="instagram_editar">
                        </div>
                    </div>

                    <button type="submit" class="botao-editar">Salvar alterações</button>
                </form>
            </div>
        </div>

        <script src="../../admin/js/eventos/modal_editar.js"></script>
        <script src="../../admin/js/eventos/modal_cadastro.js"></script>
        <script src="../../admin/js/eventos/modal_excluir.js"></script>
        <script src="../../admin/js/view_password.js"></script>
</body>

</html>