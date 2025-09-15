document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".tab-btn");
    const sections = document.querySelectorAll(".config-section");

    // Alternar abas
    buttons.forEach(button => {
        button.addEventListener("click", () => {
            buttons.forEach(btn => btn.classList.remove("active"));
            sections.forEach(sec => sec.classList.remove("active"));
            button.classList.add("active");
            document.getElementById(button.dataset.target).classList.add("active");
        });
    });

    // Função para exibir notificação tipo toast
    function showToast(mensagem, tipo = "sucesso") {
        let toast = document.createElement("div");
        toast.className = `toast ${tipo}`;
        toast.textContent = mensagem;
        document.body.appendChild(toast);

        // Força reflow para ativar animação
        setTimeout(() => toast.classList.add("show"), 50);

        // Esconde após 3 segundos
        setTimeout(() => {
            toast.classList.remove("show");
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Função para verificar alterações nos formulários
    function verificarAlteracoes(form) {
        const originalData = {};

        form.querySelectorAll("input, select, textarea").forEach(el => {
            if (!el.name) return; // Ignora elementos sem name
            originalData[el.name] = el.type === "checkbox" ? el.checked : el.value;
        });

        form.addEventListener("submit", function (e) {
            let alterado = false;

            form.querySelectorAll("input, select, textarea").forEach(el => {
                if (!el.name) return;
                if (el.type === "checkbox") {
                    if (originalData[el.name] !== el.checked) alterado = true;
                } else {
                    if (originalData[el.name] !== el.value) alterado = true;
                }
            });

            if (!alterado) {
                e.preventDefault();
                showToast("Nenhuma alteração detectada!", "erro");
            } else {
                showToast("Alterações salvas com sucesso!", "sucesso");
            }
        });
    }

    // Aplica a verificação de alteração a todos os formulários da página
    document.querySelectorAll("form").forEach(form => verificarAlteracoes(form));

    // Verifica se há mensagem de feedback vinda do PHP para exibir toast
    const toastDiv = document.getElementById("toast-msg");
    if (toastDiv) {
        const msg = toastDiv.getAttribute("data-msg");
        if (msg && msg.trim() !== "") {
            // Decide tipo de toast pelo conteúdo da mensagem
            const tipo = msg.toLowerCase().includes("nenhuma") ? "erro" : "sucesso";
            showToast(msg, tipo);
        }
    }
    const btnVoltar = document.getElementById("btn-voltar");
    if (btnVoltar) {
        btnVoltar.addEventListener("click", () => {
            window.location.href = "../site_livros.php";
        });
    }
});
