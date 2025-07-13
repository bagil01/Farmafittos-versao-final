function abrirModalGaleria(idPlanta) {
  const modal = document.getElementById('modalGaleriaImagens');
  const galeria = document.getElementById('conteudoGaleria');
  const fechar = document.getElementById('fecharModalGaleria');

  if (!modal || !galeria || !fechar) return;

  // Limpa conteúdo anterior
  galeria.innerHTML = '<p>Carregando imagens...</p>';

  fetch(`../../backend/crud_planta/listar_imagens.php?id_planta=${idPlanta}`)
    .then(res => res.text())
    .then(html => {
      galeria.innerHTML = html;
      modal.style.display = 'flex';
    })
    .catch(() => {
      galeria.innerHTML = '<p>Erro ao carregar as imagens.</p>';
      modal.style.display = 'flex';
    });

  // Fecha ao clicar no X
  fechar.onclick = () => {
    modal.style.display = 'none';
  };

  // Fecha ao clicar fora do modal
  modal.onclick = (event) => {
    if (event.target === modal) {
      modal.style.display = 'none';
    }
  };
}
