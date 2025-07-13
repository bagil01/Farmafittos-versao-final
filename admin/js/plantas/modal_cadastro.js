document.addEventListener("DOMContentLoaded", () => {
    const botaoAbrir = document.getElementById("abrirModalPlanta");
    const modal = document.getElementById("modalCadastroPlanta");
    const fechar = document.getElementById("fecharModalCadastroPlanta");

    // Abrir modal
    botaoAbrir.addEventListener("click", () => {
        modal.style.display = "flex";
    });

    // Fechar modal
    fechar.addEventListener("click", () => {
        modal.style.display = "none";
    });

    // Fechar modal ao clicar fora
    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });

    // Navegação entre páginas do modal
    const btnProxima = document.getElementById("btnProxima");
    const btnAnterior = document.getElementById("btnAnterior");

    const primeiraPagina = document.querySelector(".pagina-1");
    const segundaPagina = document.querySelector(".pagina-2");

    btnProxima.addEventListener("click", (e) => {
        e.preventDefault();
        primeiraPagina.style.display = "none";
        segundaPagina.style.display = "block";
    });

    btnAnterior.addEventListener("click", (e) => {
        e.preventDefault();
        primeiraPagina.style.display = "block";
        segundaPagina.style.display = "none";
    });
});