let galeriaModalJaConfigurado = false;

function abrirModalGaleria(idPlanta) {
  const modal = document.getElementById('modalGaleriaImagens');
  const galeria = document.getElementById('conteudoGaleria');
  const fechar = document.getElementById('fecharModalGaleria');

  if (!modal || !galeria || !fechar) return;

  // Limpa conteúdo anterior
  galeria.innerHTML = '<p>Carregando imagens...</p>';

  // Requisição para carregar imagens
  fetch(`../../backend/crud_planta/listar_imagens.php?id_planta=${idPlanta}`)
    .then(response => response.text())
    .then(html => {
      galeria.innerHTML = html;
      modal.style.display = 'flex';
    })
    .catch(() => {
      galeria.innerHTML = '<p>Erro ao carregar as imagens.</p>';
      modal.style.display = 'flex';
    });

  // Evita reatribuir listeners múltiplas vezes
  if (!galeriaModalJaConfigurado) {
    fechar.addEventListener('click', () => {
      modal.style.display = 'none';
    });

    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.style.display = 'none';
      }
    });

    galeriaModalJaConfigurado = true;
  }
}
