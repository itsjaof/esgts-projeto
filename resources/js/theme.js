// Sistema de Tema~
const themeToggle = document.getElementById("theme-toggle");
const themeText = themeToggle.querySelector(".theme-text");
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

// Atualizar ícone do tema
function updateThemeIcon(theme) {
    const icon = themeToggle.querySelector("i");
    if (theme === "dark") {
        icon.className = "fas fa-sun";
        themeText.textContent = "Tema Claro";
    } else {
        icon.className = "fas fa-moon";
        themeText.textContent = "Tema Escuro";
    }
}

// Inicializar tema
const currentTheme = getInitialTheme();
setTheme(currentTheme);

// Alternar tema ao clicar
themeToggle.addEventListener("click", (e) => {
    e.preventDefault();
    const currentTheme = html.getAttribute("data-theme");
    const newTheme = currentTheme === "dark" ? "light" : "dark";
    setTheme(newTheme);
});

// Ouvir mudanças na preferência do sistema (opcional)
window
    .matchMedia("(prefers-color-scheme: dark)")
    .addEventListener("change", (e) => {
        if (!localStorage.getItem("theme")) {
            setTheme(e.matches ? "dark" : "light");
        }
    });
