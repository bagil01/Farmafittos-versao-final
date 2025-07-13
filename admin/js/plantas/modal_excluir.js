function abrirModalExclusao(idNoticia) {
  const modal = document.getElementById('modalExcluirPlanta');
  const inputId = document.getElementById('idPlantaExcluir');

  if (modal && inputId) {
    inputId.value = idNoticia;
    modal.style.display = 'flex';
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const fechar = document.getElementById('fecharModalExcluir');
  const modal = document.getElementById('modalExcluirPlanta');

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
