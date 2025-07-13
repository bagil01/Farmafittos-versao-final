function abrirModalEditarPlanta(planta) {
  const modal = document.getElementById('modalEditarPlanta');
  if (!modal) return;

  document.getElementById('id_planta').value = planta.id || '';
  document.getElementById('nome_cientifico_editar').value = planta.nome_cientifico || '';
  document.getElementById('nomes_populares_editar').value = planta.nomes_populares || '';
  document.getElementById('usos_populares_editar').value = planta.usos_populares || '';
  document.getElementById('modo_uso_editar').value = planta.modo_uso || '';
  document.getElementById('contraindicacoes_editar').value = planta.contraindicacoes || '';
  document.getElementById('acoes_farmacologicas_editar').value = planta.acoes_farmacologicas || '';
  document.getElementById('destaque_editar').value = planta.destaque || 'nao';

  modal.style.display = 'flex';
}

document.addEventListener('DOMContentLoaded', () => {
  const fecharModal = document.getElementById('fecharModalEditarPlanta');
  const modal = document.getElementById('modalEditarPlanta');

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
