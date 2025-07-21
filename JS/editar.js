// =================================================================================
// FUNCIÓN PARA OBTENER DATOS Y ABRIR EL MODAL DE EDICIÓN
// (Basada en la idea de tu compañera pero con fetch)
// =================================================================================
function editar(id) {
  fetch(`PHP/obtener_participante_editar.php?id=${id}`)
    .then(res => {
      if (!res.ok) throw new Error('Respuesta del servidor no fue OK');
      return res.json();
    })
    .then(result => {
      if (result.success) {
        const p = result.participante;

        for (const key in p) {
    const elemento = document.getElementById(`edit_${key}`);

    if (elemento) {
        if (elemento.tagName === 'SELECT') {
            const valorDB = p[key];
            const opcion = Array.from(elemento.options).find(opt => opt.value === valorDB);
            if (opcion) {
                opcion.selected = true;
            }
        } else {
            elemento.value = p[key];
        }
    }
}

        new bootstrap.Modal(document.getElementById("modalEditar")).show();
      } else {
        alert("❌ No se pudieron obtener los datos del participante.");
      }
    })
    .catch(err => {
      console.error("Error al obtener datos para editar:", err);
      alert("Error de conexión al intentar cargar los datos.");
    });
}

// =================================================================================
// MANEJO DEL ENVÍO DEL FORMULARIO DE EDICIÓN
// =================================================================================
document.addEventListener("DOMContentLoaded", () => {
  const formEditar = document.getElementById("formEditar");

  if (formEditar) {
    formEditar.addEventListener("submit", function(event) {
      event.preventDefault(); 

      // FUSIÓN: Incorporamos el bloque completo de validaciones de tu compañera.
      const correo = document.getElementById("edit_correo_institucional").value.trim();
      const curp = document.getElementById("edit_curp").value.trim();
      const telefono = document.getElementById("edit_telefono").value.trim();
      const boleta = document.getElementById("edit_boleta").value.trim();
      const nombre = document.getElementById("edit_nombre").value.trim();
      const apellidoP = document.getElementById("edit_apellido_paterno").value.trim();
      const apellidoM = document.getElementById("edit_apellido_materno").value.trim();

      const errores = [];
      if (!nombre || !apellidoP || !apellidoM) {
        errores.push('Nombre y apellidos son obligatorios.');
      }
      if (!/^(PE|PP)?\d{10}$/.test(boleta)) {
        errores.push('La boleta no tiene un formato válido.');
      }
      if (!/^[A-Z]{4}\d{6}[A-Z]{6}[A-Z0-9]\d$/i.test(curp)) {
        errores.push('El CURP no tiene un formato válido.');
      }
      if (!/^\d{10}$/.test(telefono)) {
        errores.push('El teléfono debe tener exactamente 10 dígitos.');
      }
      if (!/^[a-zA-Z0-9._%+-]+@alumno\.ipn\.mx$/.test(correo)) {
        errores.push('El correo debe ser institucional (terminar en @alumno.ipn.mx).');
      }

      if (errores.length > 0) {
        alert('Por favor, corrija los siguientes errores:\n' + errores.join('\n'));
        return;
      }

      const formData = new FormData(formEditar);

      fetch("PHP/editar.php", {
        method: "POST",
        body: formData 
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {

          const modalEditar = bootstrap.Modal.getInstance(document.getElementById("modalEditar"));
          if(modalEditar) modalEditar.hide();

          new bootstrap.Modal(document.getElementById("modalExitoEditar")).show();

          setTimeout(() => location.reload(), 2000);
        } else {
          alert("❌ No se pudo actualizar: " + (data.message || "Error desconocido."));
        }
      })
      .catch(err => {
        console.error("Error al actualizar:", err);
        alert("Error de conexión al intentar actualizar.");
      });
    });
  }
});