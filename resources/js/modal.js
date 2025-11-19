// Sistema de Modal
const modalOverlay = document.getElementById("modal-overlay");
const openModalBtn = document.getElementById("open-modal-btn");
const closeModalBtn = document.getElementById("close-modal-btn");
const cancelBtn = document.getElementById("cancel-btn");
const statusToggle = document.getElementById("status-toggle");
const statusText = document.getElementById("status-text");
const addEmployeeForm = document.getElementById("add-employee-form");

// Abrir modal
openModalBtn.addEventListener("click", () => {
    modalOverlay.classList.add("active");
    document.body.style.overflow = "hidden";
});

// Fechar modal
function closeModal() {
    modalOverlay.classList.remove("active");
    document.body.style.overflow = "";
    addEmployeeForm.reset();
    statusToggle.checked = false;
    updateStatusText();
}

closeModalBtn.addEventListener("click", closeModal);
cancelBtn.addEventListener("click", closeModal);

// Fechar ao clicar no overlay
modalOverlay.addEventListener("click", (e) => {
    if (e.target === modalOverlay) {
        closeModal();
    }
});

// Fechar com ESC
document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && modalOverlay.classList.contains("active")) {
        closeModal();
    }
});

// Toggle de status
function updateStatusText() {
    if (statusToggle.checked) {
        statusText.textContent = "Empregado ativo";
    } else {
        statusText.textContent = "Empregado inativo";
    }
}

statusToggle.addEventListener("change", updateStatusText);

// Submeter formulário
addEmployeeForm.addEventListener("submit", (e) => {
    e.preventDefault();

    // Aqui pode adicionar a lógica para adicionar o empregado
    const formData = new FormData(addEmployeeForm);
    const employeeData = {
        nome: formData.get("nome-completo"),
        email: formData.get("email"),
        cargo: formData.get("cargo"),
        idInterno: formData.get("id-interno"),
        localizacao: formData.get("localizacao"),
        ativo: statusToggle.checked,
    };

    console.log("Dados do empregado:", employeeData);

    // Fechar modal após submissão
    closeModal();

    // Aqui pode adicionar uma notificação de sucesso
    alert("Empregado adicionado com sucesso!");
});
