let idSeleccionado = null;

// Abre el modal con datos
window.eliminar = function(id) {
  const fila = document.querySelector(`button[onclick="eliminar(${id})"]`).closest("tr");
  const nombre = fila.children[1].textContent;

  document.getElementById("nombreEliminar").textContent = nombre;
  document.getElementById("idEliminar").value = id;
  idSeleccionado = id;

  const modal = new bootstrap.Modal(document.getElementById("modalEliminar"));
  modal.show();
};

// Confirma eliminación
document.addEventListener("DOMContentLoaded", function () {
  const btnConfirmar = document.getElementById("btnConfirmarEliminar");
  btnConfirmar.addEventListener("click", function () {
    const id = idSeleccionado;

    fetch("php/eliminar.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id: id })
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          // Cerrar modal de confirmación
          const modalEliminar = bootstrap.Modal.getInstance(document.getElementById("modalEliminar"));
          modalEliminar.hide();

          // Mostrar modal de éxito
          const modalExito = new bootstrap.Modal(document.getElementById("modalExito"));
          modalExito.show();

          // Recargar tabla después de un breve tiempo
          setTimeout(() => {
            location.reload();
          }, 2000);
        } else {
          alert("Error al eliminar: " + (data.error || data.message));
        }
      })
      .catch(err => {
        console.error("Error de conexión:", err);
        alert("No se pudo conectar con el servidor.");
      });
  });
});
