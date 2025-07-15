function abrirModalGaleria(idNoticia) {
  const modal = document.getElementById('modalGaleriaImagens');
  const galeria = document.getElementById('conteudoGaleria');

  if (!modal || !galeria) return;

  galeria.innerHTML = '<p>Carregando imagens...</p>';

  fetch(`../../backend/crud_noticia/listar_imagens.php?id_noticia=${idNoticia}`)
    .then(response => response.text())
    .then(data => {
      galeria.innerHTML = data;
      modal.style.display = 'flex';
    })
    .catch(error => {
      galeria.innerHTML = '<p>Erro ao carregar imagens.</p>';
      console.error(error);
    });
}

document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('modalGaleriaImagens');
  const fechar = document.getElementById('fecharModalGaleria');

  if (fechar && modal) {
    fechar.addEventListener('click', () => {
      modal.style.display = 'none';
    });

    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.style.display = 'none';
      }
    });
  }
});
