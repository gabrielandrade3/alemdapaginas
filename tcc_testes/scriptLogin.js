window.onload = () => {
    // Obtém o array de entradas de navegação da página
    const navEntries = performance.getEntriesByType("navigation");

    // Verifica se existe alguma entrada e se o tipo é 'reload' (recarregamento da página)
    if (navEntries.length > 0 && navEntries[0].type === 'reload') {
        // Seleciona o elemento da mensagem de erro pelo seletor da classe
        const msg = document.querySelector('.mensagem-erro');

        // Se a mensagem existir na página, esconde ela
        if (msg) {
            msg.style.display = 'none';
        }
    }
};
