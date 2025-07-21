document.addEventListener("DOMContentLoaded", function () {
    const adminForm = document.getElementById("adminForm");

    if (adminForm) {
        const usuarioInput = document.getElementById("usuario");
        const contrasenaInput = document.getElementById("contrasena");
        const mensajeError = document.getElementById("mensajeError");

        adminForm.addEventListener("submit", function (event) {
            event.preventDefault();

            const usuario = usuarioInput.value.trim();
            const contrasena = contrasenaInput.value.trim();

            mensajeError.style.display = "none";
            mensajeError.textContent = "";

            if (usuario === "" || contrasena === "") {
                mensajeError.textContent = "Por favor, completa todos los campos.";
                mensajeError.style.display = "block";
                return;
            }

            if (!usuario.endsWith("@alumno.ipn.mx")) {
                mensajeError.textContent = "El correo debe ser institucional (@alumno.ipn.mx)";
                mensajeError.style.display = "block";
                return;
            }

            if (usuario === "admin@alumno.ipn.mx" && contrasena === "Admin123+") {
                const modal = bootstrap.Modal.getInstance(document.getElementById("modalAdmin"));
                if (modal) modal.hide();
                window.location.href = "UsuariosRegistrados.php";
            } else {
                mensajeError.textContent = "Usuario o contraseña incorrectos.";
                mensajeError.style.display = "block";
            }
        });

        function limpiarMensajeError() {
            if (mensajeError.style.display === "block") {
                mensajeError.style.display = "none";
                mensajeError.textContent = "";
            }
        }

        if (usuarioInput) usuarioInput.addEventListener("input", limpiarMensajeError);
        if (contrasenaInput) contrasenaInput.addEventListener("input", limpiarMensajeError);
    }
});

