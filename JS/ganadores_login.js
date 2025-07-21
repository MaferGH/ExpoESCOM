document.addEventListener("DOMContentLoaded", () => {
    const formLoginGanador = document.getElementById("formLoginGanador");
    const contenidoGanadores = document.getElementById("contenidoGanadores");
    const modalElement = document.getElementById('modalLoginGanador');
    if (!formLoginGanador || !contenidoGanadores || !modalElement) {
        return;
    }

    const modal = new bootstrap.Modal(modalElement);
    modal.show();

    formLoginGanador.addEventListener("submit", async (e) => {
        e.preventDefault();

        const correo = document.getElementById("ganadorCorreo").value.trim();
        const password = document.getElementById("ganadorPassword").value;
        const mensajeError = document.getElementById("errorLoginGanador");

        mensajeError.style.display = 'none';

        try {
            const response = await fetch('PHP/login_ganador.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ correo: correo, contraseña: password })
            });

            const result = await response.json();

            if (result.success) {
                modal.hide();
                contenidoGanadores.style.display = 'block';

                if (typeof cargarDatosGanadores === 'function') {
                    cargarDatosGanadores();
                }

            } else {
                mensajeError.textContent = result.message || "Error desconocido.";
                mensajeError.style.display = 'block';
            }

        } catch (error) {
            mensajeError.textContent = "Error de conexión con el servidor.";
            mensajeError.style.display = 'block';
            console.error(error);
        }
    });
});