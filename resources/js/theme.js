// Sistema de Tema
const html = document.documentElement;

// Verificar tema salvo ou preferência do sistema
function getInitialTheme() {
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme) {
        return savedTheme;
    }
    // Verificar preferência do sistema
    if (
        window.matchMedia &&
        window.matchMedia("(prefers-color-scheme: dark)").matches
    ) {
        return "dark";
    }
    return "light";
}

// Aplicar tema
function setTheme(theme) {
    html.setAttribute("data-theme", theme);
    localStorage.setItem("theme", theme);
}

// Inicializar tema
const currentTheme = getInitialTheme();
setTheme(currentTheme);

// Ouvir mudanças na preferência do sistema (opcional)
window
    .matchMedia("(prefers-color-scheme: dark)")
    .addEventListener("change", (e) => {
        if (!localStorage.getItem("theme")) {
            setTheme(e.matches ? "dark" : "light");
        }
    });
