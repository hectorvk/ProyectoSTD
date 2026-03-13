//Este documento centraliza las validaciones para login, registro y formularios
document.addEventListener("DOMContentLoaded", () => {
    //Login <script src="js/validaciones.js"></script>
    const loginForm = document.getElementById("loginForm");
    if(loginForm) {
        loginForm.addEventListener("submit", function(e) {
            const user = document.getElementById("loginUser").value.trim();
            const pass = document.getElementById("loginPass").value.trim();

            if(user === "" || pass === "") {
                alert("Por favor completa todos los campos del login.");
                e.preventDefault();
            }
        });
    }
    //Registro <script src="js/validaciones.js"></script>
    const registroForm = document.getElementById("registroForm");
    if(registroForm) {
        registroForm.addEventListener("submit", function(e) {
            const user = document.getElementById("regUser").value.trim();
            const pass = document.getElementById("regPass").value.trim();

            if(user.length < 3) {
                alert("El usuario debe tener al menos 3 caracteres.");
                e.preventDefault();
                return;
            }
            if(pass.length < 6) {
                alert("La contraseña debe tener al menos 6 caracteres.");
                e.preventDefault();
            }
        });
    }
    //Formularios CRUD <form class="crudForm" action="guardar_cultivo.php" method="post">
    const crudForms = document.querySelectorAll(".crudForm");
    crudForms.forEach(form => {
        form.addEventListener("submit", function(e){
            const inputs = form.querySelectorAll("input, select, textarea");
            for(let input of inputs) {
                if(input.type !== "submit" && input.value.trim() === "") {
                    alert("Todos los campos deben estar completos.");
                    e.preventDefault();
                    return;
                }
            }
        });
    });
    //Perfil de usuario
    // Validación perfil
    const perfilForm = document.getElementById("perfilForm");
    if(perfilForm) {
        perfilForm.addEventListener("submit", function(e){
            const newPass = document.getElementById("newPass").value.trim();
            const confirmPass = document.getElementById("confirmPass").value.trim();

            if(newPass !== "" && newPass !== confirmPass) {
                alert("La nueva contraseña y su confirmación no coinciden.");
                e.preventDefault();
            }
        });
    }
});