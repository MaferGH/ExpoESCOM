let datosParticipanteGlobal = null;

function poblarDatos(datos) {

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

    function formatearAcademia(id) {
        return mapaAcademias[id] || id; 
    }

    function formatearHora(hora) {
        if (!hora || hora === '00:00:00') return "No Asignado";
        const [h, m] = hora.split(':');
        const horas12 = h % 12 || 12; 
        const ampm = h >= 12 ? 'PM' : 'AM';
        return `${String(horas12).padStart(2, '0')}:${m} ${ampm}`;
    }

    document.getElementById('nombreParticipante').textContent = `${datos.nombre} ${datos.apellido_paterno} ${datos.apellido_materno}`; // Nombre completo
    document.getElementById('proyectoParticipante').textContent = datos.nombre_proyecto;
    document.getElementById('academiaParticipante').textContent = formatearAcademia(datos.academia);
    document.getElementById('unidadParticipante').textContent = datos.unidad_aprendizaje;
    document.getElementById('salonParticipante').textContent = datos.salon_asignado;
    document.getElementById('horarioParticipante').textContent = formatearHora(datos.horario_asignado);

    const btnDiploma = document.getElementById('btnDiploma');
    const seccionGanador = document.getElementById('seccionGanador');

    if (datos.es_ganador == 1) { 
        //  GANADOR:
        if (btnDiploma) {
            btnDiploma.classList.remove('disabled');
            btnDiploma.removeAttribute('title');
            btnDiploma.style.pointerEvents = 'auto'; 
        }
        if (seccionGanador) {
            seccionGanador.style.display = 'block'; 
        }
    } else {
        // NO GANADOR:
        if (btnDiploma) {
            btnDiploma.classList.add('disabled'); 
            btnDiploma.setAttribute('title', 'Diploma disponible únicamente para ganadores');
            btnDiploma.style.pointerEvents = 'none';
        }
        if (seccionGanador) {
            seccionGanador.style.display = 'none';
        }
    }
}

// --- LÓGICA PRINCIPAL AL CARGAR LA PÁGINA ---
document.addEventListener('DOMContentLoaded', () => {
    fetch('PHP/participante.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(result => {
            if (result.status === 'ok') {
                datosParticipanteGlobal = result.data; 
                poblarDatos(datosParticipanteGlobal);
            } else {
                throw new Error(result.data.message || 'No se pudo verificar la sesión.');
            }
        })
        .catch(error => {
            console.error('Error al obtener los datos del panel:', error);
            alert('Error: ' + error.message + '\nSerás redirigido a la página de inicio de sesión.');
            window.location.href = 'login.html';
        });
});