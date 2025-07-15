function abrirModalEdicaoNoticia(noticia) {
  const modal = document.getElementById('modalEditarNoticia');
  if (!modal) return;

  document.getElementById('id_noticia').value = noticia.id || '';
  document.getElementById('titulo_editar').value = noticia.titulo || '';

  // Converter a data para o formato datetime-local
  const data = new Date(noticia.data_publicacao);
  if (!isNaN(data.getTime())) {
    const dataFormatada = data.toISOString().slice(0, 16);
    document.getElementById('data_editar').value = dataFormatada;
  }

  document.getElementById('destaque_editar').value = noticia.destaque || 'nao';
  document.getElementById('conteudo_editar').value = noticia.conteudo || '';

  modal.style.display = 'flex';
}

document.addEventListener('DOMContentLoaded', () => {
  const fecharModal = document.getElementById('fecharModalEditarNoticia');
  const modal = document.getElementById('modalEditarNoticia'); // corrigido aqui também

  if (fecharModal && modal) {
    fecharModal.addEventListener('click', () => {
      modal.style.display = 'none';
    });

    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.style.display = 'none';
      }
    });
  }
});
