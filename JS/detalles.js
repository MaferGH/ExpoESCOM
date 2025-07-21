window.detalles = function(id) {
  fetch("php/detalles.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id })
  })
  .then(res => res.json())
  .then(data => {
    if (!data.success) {
      alert("No se pudo obtener la información del participante.");
      return;
    }

    const p = data.participante;
    const lista = document.getElementById("listaDetalles");
    lista.innerHTML = `
      <li class="list-group-item"><strong>ID:</strong> ${p.id}</li>
      <li class="list-group-item"><strong>Boleta:</strong> ${p.boleta}</li>
      <li class="list-group-item"><strong>Nombre:</strong> ${p.nombre}</li>
      <li class="list-group-item"><strong>Apellido Paterno:</strong> ${p.apellido_paterno}</li>
      <li class="list-group-item"><strong>Apellido Materno:</strong> ${p.apellido_materno}</li>
      <li class="list-group-item"><strong>Género:</strong> ${p.genero}</li>
      <li class="list-group-item"><strong>CURP:</strong> ${p.curp}</li>
      <li class="list-group-item"><strong>Teléfono:</strong> ${p.telefono}</li>
      <li class="list-group-item"><strong>Semestre:</strong> ${p.semestre}</li>
      <li class="list-group-item"><strong>Carrera:</strong> ${p.carrera}</li>
      <li class="list-group-item"><strong>Concurso:</strong> ${p.concurso}</li>
      <li class="list-group-item"><strong>Correo:</strong> ${p.correo_institucional}</li>
      <li class="list-group-item"><strong>Nombre del Proyecto:</strong> ${p.nombre_proyecto}</li>
      <li class="list-group-item"><strong>Academia:</strong> ${p.academia}</li>
      <li class="list-group-item"><strong>Horario Asignado:</strong> ${p.horario_asignado}</li>
      <li class="list-group-item"><strong>Salón Asignado:</strong> ${p.salon_asignado}</li>
    `;

    const modal = new bootstrap.Modal(document.getElementById("modalDetalles"));
    modal.show();
  })
  .catch(error => {
    console.error("Error al obtener detalles:", error);
    alert("Error al conectar con el servidor.");
  });
};
