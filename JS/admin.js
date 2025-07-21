// ==============================================
// ==============================================

// Función para marcar un participante como ganador/no ganador
function marcarComoGanador(id, esGanador) {
    fetch('PHP/marcar_ganador.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id, es_ganador: esGanador })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert('Error al actualizar: ' + data.message);
            const switchInput = document.getElementById(`ganador-${id}`);
            if (switchInput) switchInput.checked = !esGanador;
        }
    })
    .catch(error => {
        console.error('Error de conexión:', error);
        alert('Error de conexión al intentar actualizar el estado de ganador.');
        const switchInput = document.getElementById(`ganador-${id}`);
        if (switchInput) switchInput.checked = !esGanador;
    });
}



// ======================================
// LÓGICA PRINCIPAL AL CARGAR LA PÁGINA
// ======================================
document.addEventListener("DOMContentLoaded", function () {
    // Inicializar AOS y Tooltips
    if (typeof AOS !== 'undefined') AOS.init();
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Función para dibujar la tabla de participantes
    function dibujarTabla(participantes) {
        const tabla = document.getElementById("tablaAlumnos");
        tabla.innerHTML = ""; 

        if (participantes.length === 0) {
            tabla.innerHTML = '<tr><td colspan="7" class="text-center">No hay participantes registrados.</td></tr>';
            return;
        }

        participantes.forEach(p => {
            
            const esGanadorChecked = (p.es_ganador == 1) ? 'checked' : '';
            const nombreCompleto = `${p.nombre || ''} ${p.apellido_paterno || ''}`.trim();
            const academiaFormateada = mapearNombreAcademia(p.academia);

            const fila = `
                <tr>
                    <td>${p.boleta || 'N/A'}</td>
                    <td>${nombreCompleto}</td>
                    <td>${p.nombre_proyecto || 'N/A'}</td>
                    <td data-academia-key="${p.academia}">${academiaFormateada}</td>
                    <td>${p.horario_asignado || 'N/A'}</td>
                    <td>
                        <div class="form-check form-switch d-flex justify-content-center">
                            <input class="form-check-input" type="checkbox" role="switch" 
                                   id="ganador-${p.id}" ${esGanadorChecked} 
                                   onchange="marcarComoGanador(${p.id}, this.checked)">
                        </div>
                    </td>
                    <td>
                        <button onclick="editar(${p.id})" class="btn btn-sm btn-warning" title="Editar"><i class="bi bi-pencil"></i></button>
                        <button onclick="eliminar(${p.id})" class="btn btn-sm btn-danger" title="Eliminar"><i class="bi bi-trash"></i></button>

                        <button onclick="detalles(${p.id})" class="btn btn-sm btn-info" title="Ver Detalles"><i class="bi bi-eye"></i></button>
                    </td>
                </tr>`;

            tabla.innerHTML += fila;
        });
    }

    function actualizarEstadisticas(data) {
        document.getElementById("totalRegistrados").textContent = data.total || 0;
        const rankingList = document.getElementById("rankingAcademias");
        rankingList.innerHTML = "";
        if (data.ranking && Object.keys(data.ranking).length > 0) {
            for (const [academia, cantidad] of Object.entries(data.ranking)) {
                rankingList.innerHTML += `<li><strong>${mapearNombreAcademia(academia)}</strong> — ${cantidad} proyectos</li>`;
            }
        } else {
            rankingList.innerHTML = '<li>No hay datos de participación.</li>';
        }
    }

    // --- Petición Fetch Principal ---
    let todosLosParticipantes = []; 

    fetch("PHP/obtener_participantes.php")
        .then(response => {
            if (!response.ok) throw new Error('Error en la respuesta del servidor');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                todosLosParticipantes = data.participantes;
                actualizarEstadisticas(data);
                dibujarTabla(todosLosParticipantes);
            } else {
                throw new Error(data.message || 'Error al obtener los datos');
            }
        })
        .catch(error => {
            console.error("Error al cargar los datos:", error);
            document.getElementById("tablaAlumnos").innerHTML = `<tr><td colspan="7" class="text-center text-danger">Error: ${error.message}</td></tr>`;
        });

    // --- Lógica del Filtro por Academia ---
    const filtro = document.getElementById("filtroAcademia");
    if (filtro) {
        filtro.addEventListener("change", function () {
            const academiaSeleccionada = this.value;

            if (academiaSeleccionada === "Todas") {
                dibujarTabla(todosLosParticipantes); 
                return;
            }

            const participantesFiltrados = todosLosParticipantes.filter(p => 
                mapearNombreAcademia(p.academia) === academiaSeleccionada
            );

            dibujarTabla(participantesFiltrados);
        });
    }
});


// ========================================
// MAPA DE ACADEMIAS Y FUNCIÓN DE MAPEO
// ========================================
const mapaAcademias = {
  "ciencia_datos": "Ciencia de Datos",
  "ciencias_basicas": "Ciencias Básicas",
  "ciencias_computacion": "Ciencias de la Computación",
  "ciencias_sociales": "Ciencias Sociales",
  "fundamentos_sistemas": "Fundamentos de Sistemas Electrónicos",
  "ingenieria_software": "Ingeniería de Software",
  "inteligencia_artificial": "Inteligencia Artificial",
  "proyectos_estrategicos": "Proyectos Estratégicos para la Toma de Decisiones",
  "sistemas_digitales": "Sistemas Digitales",
  "sistemas_distribuidos": "Sistemas Distribuidos"
};

function mapearNombreAcademia(key) {
  return mapaAcademias[key] || key;
}