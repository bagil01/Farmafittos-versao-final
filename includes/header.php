<?php require_once(__DIR__ . '/config.php'); ?>

<!---estilos header--->
<link rel="icon" type="image/png" href="<?= BASE_URL ?>/assets/favicons/favicon.png">
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/header.css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/config.css" />
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/icons/fontawesome-free-6.5.2-web/css/all.css">
</head>

<body>
    <header>
        <div class="painel">
            <div class="leaf-background"></div>
            <div class="incones">
                <a href="<?= BASE_URL ?>/">
                    <img src="<?= BASE_URL ?>/assets/photos/logo-preta.png" alt="Logo do projeto" class="logo" />
                </a>
               
            </div>
            <div class="titulo_header">
                <h1>FARMAFITTOS</h1>
                <h2>AMAZÔNIA</h2>
            </div>
        </div>

        <nav class="navbar">
            

            <ul class="menu" id="menuMobile">
                <li><a href="<?= BASE_URL ?>/index.php">Página Inicial</a></li>

                <li class="dropdown">
                    <a href="#">Sobre Nós ▾</a>
                    <ul class="submenu">
                        <li><a href="<?= BASE_URL ?>/pages/apresentacao_projeto.php">Apresentação do Projeto</a></li>
                        <li><a href="<?= BASE_URL ?>/pages/colaboradores.php">Colaboradores e Voluntários</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#">Publicações ▾</a>
                    <ul class="submenu">
                        <li><a href="<?= BASE_URL ?>/pages/prev_noticias.php">Notícias</a></li>
                        <li><a href="<?= BASE_URL ?>/pages/prev_atividades.php">Atividades</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#">Plantas ▾</a>
                    <ul class="submenu">
                        <li><a href="<?= BASE_URL ?>/pages/prev_plantas.php">Plantas</a></li>
                        <li><a href="<?= BASE_URL ?>/pages/referencias.php">Referências</a></li>
                    </ul>
                </li>

                <li><a href="<?= BASE_URL ?>/pages/eventos.php">Eventos</a></li>
            </ul>
        </nav>
    </header>

    <!-- Scripts -->
    <script src="<?= BASE_URL ?>/assets/js/config.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/header.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/animacao.js"></script>
  
</body>

</html>