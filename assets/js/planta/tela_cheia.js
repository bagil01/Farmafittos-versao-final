// Modal de imagem
        const imagens = document.querySelectorAll('.midias img');
        const modal = document.getElementById('modal-foto');
        const imagemModal = document.getElementById('imagem-modal');
        const fechar = document.getElementById('fechar');
        const overlay = document.getElementById('overlay');
        const anterior = document.getElementById('anterior');
        const proximo = document.getElementById('proximo');
        let indiceAtual = 0;

        const abrirModal = (src, index) => {
            modal.style.display = 'flex';
            imagemModal.src = src;
            indiceAtual = index;
        };

        imagens.forEach((img, index) => {
            img.addEventListener('click', () => abrirModal(img.src, index));
        });

        const atualizarImagem = (indice) => {
            if (indice < 0) indice = imagens.length - 1;
            if (indice >= imagens.length) indice = 0;
            imagemModal.src = imagens[indice].src;
            indiceAtual = indice;
        };

        anterior.addEventListener('click', () => atualizarImagem(indiceAtual - 1));
        proximo.addEventListener('click', () => atualizarImagem(indiceAtual + 1));
        fechar.addEventListener('click', () => modal.style.display = 'none');
        overlay.addEventListener('click', () => modal.style.display = 'none');