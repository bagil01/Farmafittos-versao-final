<?php
// include './includes/header.php'; // Descomente se tiver um cabeçalho separado
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apresentação do Projeto</title>
    <link rel="stylesheet" href="../assets/css/Apresentacao_Projeto.css">
    <link rel="stylesheet" href="../icons/fontawesome-free-6.5.2-web/css/all.css">
    <?php include '../includes/header.php'; ?>
</head>

<body>
    <div class="container">
        <!-- Endereço e Contatos -->
        <div class="container-contatos-endereco">
            <div class="endereco">
                <h3>Endereço:</h3>
                <a id="text-endereco" href="https://maps.app.goo.gl/EKpDYEdJQex8SvoEA" target="_blank">
                    <i class="fa-solid fa-map-location-dot"></i>
                    Centro de Formação Emaús - Arquidiocese de Santarém
                </a>
            </div>

            <div class="contatos">
                <h3>Contatos:</h3>
                <ul>
                    <li>
                        <a href="https://www.instagram.com/farmafittos?igsh=MXVoNnY3a3doeHdocQ==" target="_blank"
                            rel="noopener noreferrer">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>

                    <li>
                        <a href="https://www.youtube.com/@Farmafittos" target="_blank" rel="noopener noreferrer">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    </li>
                    <li>
                        <a
                            href="mailto:seuemail@gmail.com?subject=Contato%20Farmafittos&body=Olá,%20gostaria%20de%20mais%20informações.">
                            <i class="fa-solid fa-envelope"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Conteúdo da Apresentação -->
        <div class="container-descricao">
            <h2 id="titulo-descricao">Apresentação</h2>
            <p>
                O <strong>FarmaFittos</strong> é um projeto que une ciência, saberes tradicionais e políticas públicas
                para promover saúde, sustentabilidade e inclusão social na Amazônia. Atuando especialmente em
                comunidades ribeirinhas e populações tradicionais, o projeto incentiva o uso seguro e sustentável de
                plantas medicinais, valorizando a cultura local e fortalecendo o Sistema Único de Saúde (SUS) com base
                na fitoterapia.
            </p>

            <h2 id="titulo-descricao">Histórico</h2>
            <p>
                O projeto nasceu em 2021 como resposta à pandemia de COVID-19, inicialmente com a campanha "Doe Amor",
                promovida pela Cáritas de Santarém e Irmãs Franciscanas de Maristella. A partir de 2022, a UFOPA
                implementou a Farmácia de Manipulação de Fitoterápicos e fortaleceu parcerias com o MPPA. Em 2023,
                surgiu a Farmácia Viva no Centro Emaús e um Banco de Germoplasma com a UNAERP. Em 2024, o projeto
                ampliou sua atuação junto a comunidades indígenas e quilombolas, contribuiu com políticas públicas e
                firmou parcerias internacionais, como com a Universidade Lúrio (Moçambique).
            </p>

            <h2 id="titulo-descricao">Objetivos</h2>
            <p>
                • Promover o uso seguro de plantas medicinais com base científica e saberes tradicionais;<br>
                • Integrar fitoterápicos ao SUS e ampliar seu acesso em comunidades da Amazônia;<br>
                • Valorizar a cultura e os conhecimentos ancestrais de povos indígenas, quilombolas e ribeirinhos;<br>
                • Formar e capacitar agricultores, estudantes e profissionais para o cultivo e uso sustentável de
                plantas medicinais;<br>
                • Fortalecer redes nacionais e internacionais de pesquisa, cooperação e inovação em fitoterapia;<br>
                • Tornar-se um Centro de Referência Regional em Fitoterapia e modelo de inovação social, cultural e
                ambiental.
            </p>
        </div>

    </div>

    <?php include '../includes/footer.php'; ?>

</body>

</html>