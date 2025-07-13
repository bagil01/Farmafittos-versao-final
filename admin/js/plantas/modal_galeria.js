function abrirModalGaleria(idPlanta) {
  const modal = document.getElementById('modalGaleriaImagens');
  const galeria = document.getElementById('conteudoGaleria');

  fetch(`../../backend/crud_planta/listar.php?id_planta=${idPlanta}`)
    .then(res => res.text())
    .then(html => {
      galeria.innerHTML = html;
      modal.style.display = 'flex';
    })
    .catch(() => {
      galeria.innerHTML = '<p>Erro ao carregar as imagens.</p>';
      modal.style.display = 'flex';
    });

  document.getElementById('fecharModalGaleria').onclick = () => {
    modal.style.display = 'none';
  };
}
