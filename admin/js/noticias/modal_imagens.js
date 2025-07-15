function abrirModalImagens(idNoticias) {
  const modal = document.getElementById('modalImagens');
  const inputId = document.getElementById('idNoticiaImagens');

  if (modal && inputId) {
    inputId.value = idNoticias;
    modal.style.display = 'flex';
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const fechar = document.getElementById('fecharModalImagens');
  const modal = document.getElementById('modalImagens');

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
