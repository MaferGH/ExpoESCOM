document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.getElementById("loginForm");

  if (loginForm) {
    loginForm.addEventListener("submit", async function (e) {
      e.preventDefault(); 

      const emailInput = document.getElementById("email");
      const passwordInput = document.getElementById("password");
      
      const correo = emailInput.value.trim();
      const password = passwordInput.value;

      const correoRegex = /^[a-zA-Z0-9._%+-]+@alumno\.ipn\.mx$/;
      const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{6,}$/;

      if (!correoRegex.test(correo)) {
        alert("Correo inválido. Debe ser institucional (@alumno.ipn.mx).");
        return;
      }
      if (!passwordRegex.test(password)) {
        alert("Contraseña inválida. Debe tener al menos 6 caracteres, una mayúscula, un número y un carácter especial.");
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
          alert("✅ ¡Inicio de sesión exitoso!");

          if (result.rol === 'admin') {
            window.location.href = 'UsuariosRegistrados.php'; 
          } else {
           
            window.location.href = 'participantes.html';
          }
          
        } else {
          alert("❌ " + (result.message || "Error en inicio de sesión."));
        }
      } catch (error) {
        alert("Error de conexión con el servidor. Revisa la consola.");
        console.error("Error en fetch:", error);
      }
    });
  }
});