window.addEventListener("show-form", (event) => {
    $("#form").modal("show");
});

window.addEventListener("hide-form", (event) => {
    $("#form").modal("hide");
});

window.addEventListener("show-delete-modal", (event) => {
    $("#deleteModal").modal("show");
});

window.addEventListener("hide-delete-modal", (event) => {
    $("#deleteModal").modal("hide");
});

window.addEventListener("empty-modal", (event) => {
    $("#emptyModal").modal("show");
});

window.addEventListener("show-offcanvas", (event) => {
    $("#readOffcanvas").offcanvas("show");
});

window.addEventListener("show-qr-modal", (event) => {
    $("#qrModal").modal("show");
});

window.addEventListener("show-import-modal", (event) => {
    $("#importModal").modal("show");
});

window.addEventListener("hide-import-modal", (event) => {
    $("#importModal").modal("hide");
});

const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
);

const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);

let passwordInput = document.querySelector("#password");
let toogleVisibility = document.querySelector("#toogle-visibility");
toogleVisibility.addEventListener("click", () => {
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toogleVisibility.classList.remove("fa-eye-slash");
        toogleVisibility.classList.add("fa-eye");
    } else {
        passwordInput.type = "password";
        toogleVisibility.classList.remove("fa-eye");
        toogleVisibility.classList.add("fa-eye-slash");
    }
});
