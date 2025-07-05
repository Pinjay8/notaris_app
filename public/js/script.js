document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("togglePassword");
    const input = document.getElementById("password");
    const icon = document.getElementById("togglePasswordIcon");

    toggle.addEventListener("click", function () {
        const type = input.type === "password" ? "text" : "password";
        input.type = type;

        // Ganti ikon
        icon.classList.toggle("fa-eye");
        icon.classList.toggle("fa-eye-slash");
    });
});
