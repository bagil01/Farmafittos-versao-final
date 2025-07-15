function abrirModalExclusao(idNoticia) {
  const modal = document.getElementById('modalExcluirNoticia');
  const inputId = document.getElementById('idNoticiaExcluir');

  if (modal && inputId) {
    inputId.value = idNoticia;
    modal.style.display = 'flex';
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const fechar = document.getElementById('fecharModalExcluir');
  const modal = document.getElementById('modalExcluirNoticia');

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
