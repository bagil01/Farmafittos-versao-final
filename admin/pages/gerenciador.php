<?php
require_once('verifica_login.php');

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="../css/index_gerenciador.css" />
    <link rel="stylesheet" href="../../assets/icons/fontawesome-free-6.5.2-web/css/all.css">
</head>

<body>
    <div class="admin-container">
        <div class="voltar">
            <a href="./logout.php">
                <i class="fa-solid fa-right-from-bracket"></i> SAIR
            </a>
        </div>
        <main class="main-content">
            <h1>Bem-vindo ao Painel de administração</h1>
            <p>Selecione uma das opções no menu para gerenciar o conteúdo.</p>

            <div class="painel-wrapper">
                <!-- Blocos de administração à esquerda -->
                <div class="container-controle">
                    <div class="card-grid">
                        <a href="gerenciar_admin.php">
                            <div class="card">
                                <i class="fa-solid fa-users-gear"></i>
                                <h3>Gerenciar ADMs</h3>
                            </div>
                        </a>

                        <a href="gerenciador_noticias.php">
                            <div class="card">
                                <i class="fa-solid fa-newspaper"></i>
                                <h3>Gerenciar Notícia</h3>
                            </div>
                        </a>
                        <a href="gerenciador_atividades.php">
                            <div class="card">
                                <i class="fas fa-plus-circle"></i>
                                <h3>Gerenciar Atividades</h3>
                            </div>
                        </a>
                        <a href="gerenciador_plantas.php">
                            <div class="card">
                                <i class="fa-solid fa-sun-plant-wilt"></i>
                                <h3>Gerenciar Plantas</h3>
                            </div>
                        </a>
                        <a href="gerenciador_eventos.php">
                            <div class="card">
                                <i class="fa-solid fa-calendar-days"></i>
                                <h3>Gerenciar Eventos</h3>
                            </div>
                        </a>

                        <a href="gerenciador_parceiros.php">
                            <div class="card">
                                <i class="fa-solid fa-handshake"></i>
                                <h3>Gerenciar Parceiros</h3>
                            </div>
                        </a>

                        <a href="gerenciador_colaboradores.php">
                            <div class="card">
                                <i class="fa-solid fa-handshake-angle"></i>
                                <h3>Gerenciar Colaboradores</h3>
                            </div>
                        </a>

                        <a href="gerenciador_voluntarios.php">
                            <div class="card">
                                <i class="fa-solid fa-handshake-simple"></i>
                                <h3>Gerenciar voluntarios</h3>
                            </div>
                        </a>

                        <a href="gerenciador_referencias.php">
                            <div class="card">
                                <i class="fa-solid fa-star-of-life"></i>
                                <h3>Gerenciar Referências</h3>
                            </div>
                        </a>
                    </div>
                </div>


            </div>
        </main>
    </div>
</body>

</html>