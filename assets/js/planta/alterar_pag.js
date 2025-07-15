 // Alternar páginas
        const botoes = document.querySelectorAll('.pagina-btn');
        const paginas = document.querySelectorAll('.pagina');

        botoes.forEach(btn => {
            btn.addEventListener('click', () => {
                const pagina = btn.dataset.pagina;

                paginas.forEach(pg => pg.style.display = 'none');
                document.querySelector(`.pagina[data-pagina="${pagina}"]`).style.display = 'block';

                botoes.forEach(b => b.classList.remove('ativo'));
                btn.classList.add('ativo');
            });
        });