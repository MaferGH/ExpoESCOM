let ganadores = [];

// Cargar participantes y renderizar
function cargarParticipantes() {
  fetch("PHP/obtener_participantes.php")
    .then(res => res.json())
    .then(data => {
      const lista = document.getElementById("listaParticipantes");
      lista.innerHTML = "";
      ganadores = [];

      // Ordenar: ganadores arriba
      data.participantes.sort((a, b) => b.es_ganador - a.es_ganador);

      data.participantes.forEach(p => {
        if (p.es_ganador) ganadores.push(p.id);

        const item = document.createElement("div");
        item.className = "list-group-item d-flex justify-content-between align-items-center";
        item.setAttribute("data-id", p.id);

        item.innerHTML = `
          <div>
            <h5 class="mb-1">${p.nombre} ${p.apellido_paterno}</h5>
            <small>Proyecto: ${p.nombre_proyecto} | Academia: ${p.academia}</small>
          </div>
          <div class="btn-group">
            <button class="btn btn-${p.es_ganador ? 'danger' : 'outline-success'} btn-sm"
              onclick="toggleGanador(${p.id}, '${p.nombre}', '${p.nombre_proyecto}', this)">
              ${p.es_ganador ? 'Quitar ganador' : 'Marcar como ganador'}
            </button>
            <button class="btn btn-outline-info btn-sm" onclick="verDetalles(${p.id})">Ver detalles</button>
          </div>
        `;

        lista.appendChild(item);
      });
    })
    .catch(err => console.error("Error al cargar participantes:", err));
}

// Función para marcar o quitar ganador
function toggleGanador(id, nombre, proyecto, boton) {
  const esGanador = ganadores.includes(id);

  if (esGanador) {
    quitarGanador(id)
      .then(() => {
        boton.classList.remove("btn-danger");
        boton.classList.add("btn-outline-success");
        boton.innerText = "Marcar como ganador";
        reordenarParticipantes();
      })
      .catch(err => console.error(err));
  } else {
    marcarGanador(id, nombre, proyecto)
      .then(() => {
        boton.classList.remove("btn-outline-success");
        boton.classList.add("btn-danger");
        boton.innerText = "Quitar ganador";
        reordenarParticipantes();
      })
      .catch(err => console.error(err));
  }
}

function marcarGanador(id, nombre, proyecto) {
  return fetch("PHP/agregar_ganador.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      if (!ganadores.includes(id)) ganadores.push(id);
    } else {
      return Promise.reject("Error al guardar en BD: " + data.error);
    }
  });
}

function quitarGanador(id) {
  return fetch("PHP/quitar_ganador.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      const index = ganadores.indexOf(id);
      if (index !== -1) ganadores.splice(index, 1);
    } else {
      return Promise.reject("Error al quitar de BD: " + data.error);
    }
  });
}

// Reordena los participantes para que ganadores queden arriba
function reordenarParticipantes() {
  const lista = document.getElementById("listaParticipantes");
  const items = Array.from(lista.children);

  items.sort((a, b) => {
    const idA = parseInt(a.getAttribute("data-id"));
    const idB = parseInt(b.getAttribute("data-id"));

    const esGanadorA = ganadores.includes(idA);
    const esGanadorB = ganadores.includes(idB);

    // Ganadores arriba
    return (esGanadorB ? 1 : 0) - (esGanadorA ? 1 : 0);
  });

  // Vaciar y reinsertar en orden
  lista.innerHTML = "";
  items.forEach(item => lista.appendChild(item));
}

// Mostrar detalles en modal
function verDetalles(id) {
  fetch("PHP/obtener_detalles.php?id=" + id)
    .then(res => res.json())
    .then(p => {
      const modalBody = document.getElementById("detallesContenido");
      modalBody.innerHTML = `
        <p><strong>Boleta:</strong> ${p.boleta}</p>
        <p><strong>Nombre:</strong> ${p.nombre} ${p.apellido_paterno} ${p.apellido_materno}</p>
        <p><strong>Proyecto:</strong> ${p.nombre_proyecto}</p>
        <p><strong>Academia:</strong> ${p.academia}</p>
        <p><strong>CURP:</strong> ${p.curp}</p>
        <p><strong>Correo:</strong> ${p.correo_institucional}</p>
        <p><strong>Horario:</strong> ${p.horario_asignado}</p> 
        <p><strong>Horario:</strong> ${p.salon_asignado}</p> 
      `;
      const modal = new bootstrap.Modal(document.getElementById("modalDetalles"));
      modal.show();
    });
}

// Carga inicial al cargar la página
document.addEventListener("DOMContentLoaded", cargarParticipantes);
