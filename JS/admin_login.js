document.addEventListener("DOMContentLoaded", () => {
  const adminLoginForm = document.getElementById("adminLoginForm");

  if (adminLoginForm) {
    adminLoginForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const correoInput = document.getElementById("adminCorreo");
      const passwordInput = document.getElementById("adminPassword");

      const correo = correoInput.value.trim();
      const password = passwordInput.value;

      if (!correo || !password) {
        alert("Por favor, ingrese correo y contraseña.");
        return;
      }

      try {
        const response = await fetch('PHP/login.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ correo: correo, contraseña: password })
        });

        const result = await response.json();

        if (result.success) {

          if (result.rol === 'admin') {
            
            window.location.href = 'UsuariosRegistrados.php';
          } else {
            alert(" Acceso denegado. Esta sección es solo para administradores.");
          }
        } else {
          alert(" " + (result.message || "Credenciales incorrectas."));
        }
      } catch (error) {
        console.error("Error en el login de admin:", error);
        alert("Error de conexión con el servidor.");
      }
    });
  }
});