// =================================================================================
// FUNCIÓN PARA ACTUALIZAR OPCIONES (CURSOS Y HORARIOS)
// =================================================================================
function actualizarOpciones() {
    const academiaSelect = document.getElementById("academia");
    const cursosDiv = document.getElementById("cursos");
    const cursoSelect = document.getElementById("cursoSelect");
    if (!academiaSelect || !cursosDiv || !cursoSelect) return; 

    cursoSelect.querySelectorAll('option').forEach(option => {
        if (option.value !== "") option.style.display = "none";
    });
    cursoSelect.value = ""; 
    if (academiaSelect.value) {
        cursosDiv.style.display = "block";
        cursoSelect.querySelectorAll('.' + academiaSelect.value).forEach(option => {
            option.style.display = "block";
        });
    } else {
        cursosDiv.style.display = "none";
    }

    const horarioDiv = document.getElementById("horarioPreferidoDiv");
    const radioMatutino = document.getElementById("horarioMatutino");
    const radioVespertino = document.getElementById("horarioVespertino");
    if (!horarioDiv || !radioMatutino || !radioVespertino) return;

    const academiasMatutino = ["ciencias_computacion", "ciencias_sociales", "ingenieria_software", "sistemas_distribuidos"];
    const academiasVespertino = ["ciencia_datos", "ciencias_basicas", "fundamentos_sistemas", "inteligencia_artificial", "proyectos_estrategicos", "sistemas_digitales"];
    const academiaSeleccionada = academiaSelect.value;

    horarioDiv.style.display = "none";
    radioMatutino.disabled = true;
    radioVespertino.disabled = true;
    radioMatutino.checked = false;
    radioVespertino.checked = false;

    if (academiaSeleccionada) {
        horarioDiv.style.display = "block";
        if (academiasMatutino.includes(academiaSeleccionada)) {
            radioMatutino.disabled = false;
        } else if (academiasVespertino.includes(academiaSeleccionada)) {
            radioVespertino.disabled = false;
        }
    }
}

// =================================================================================
// FUNCIÓN PARA VALIDAR EL FORMULARIO
// =================================================================================
function validarFormulario() {

    const boleta = document.getElementById('boleta')?.value.trim() || '';
    const nombre = document.getElementById('nombre')?.value.trim() || '';
    const apellidoPater = document.getElementById('apePater')?.value.trim() || '';
    const apellidoMater = document.getElementById('apeMater')?.value.trim() || '';
    const genero = document.querySelector('input[name="genero"]:checked')?.value || "";
    const curp = document.getElementById('curp')?.value.trim() || '';
    const telefono = document.getElementById('telefono')?.value.trim() || '';
    const semestre = document.getElementById('semestre')?.value.trim() || '';
    const carrera = document.getElementById('carrera')?.value.trim() || '';
    const concurso = document.getElementById('concurso')?.value.trim() || '';
    const correo = document.getElementById('correo')?.value.trim() || '';
    const password = document.getElementById('password')?.value || '';
    const academia = document.getElementById('academia')?.value.trim() || '';
    const curso = document.getElementById('cursoSelect')?.value.trim() || '';
    const horario = document.querySelector('input[name="horario"]:checked')?.value || "";
    const nombreProyecto = document.getElementById('nombre_proyecto')?.value.trim() || '';
    const nombreEquipo = document.getElementById('nombre_equipo')?.value.trim() || '';

    const errorElements = {
        boleta: document.getElementById('errorBoleta'), nombre: document.getElementById('errorNombre'),
        apePater: document.getElementById('errorApePater'), apeMater: document.getElementById('errorApeMater'),
        curp: document.getElementById('errorCurp'), correo: document.getElementById('errorCorreo'),
        password: document.getElementById('errorPassword'), telefono: document.getElementById('errorTelefono'),
        horario: document.getElementById('errorHorario'), nombre_proyecto: document.getElementById('errorNombre_proyecto'),
        nombre_equipo: document.getElementById('errorNombre_equipo'), academia: document.getElementById('errorAcademia'),
        curso: document.getElementById('errorCurso')
    };
    Object.values(errorElements).forEach(el => {
        if (el) el.textContent = "";
    });

    let esValido = true;
    const boletaRegex = /^((PE|PP)\d{8}|\d{10})$/, nombreRegex = /^[a-zA-ZÁÉÍÓÚÑáéíóúñ\s]+$/u, curpRegex = /^[A-Z]{4}\d{6}[A-Z]{6}[A-Z0-9]\d$/i, telefonoRegex = /^\d{10}$/, correoRegex = /^[a-zA-Z0-9._%+-]+@alumno\.ipn\.mx$/, passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{6,}$/, proyectoEquipoRegex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]{3,}$/u;
    if (!boletaRegex.test(boleta)) { errorElements.boleta.textContent = "Boleta inválida."; esValido = false; }
    if (!nombreRegex.test(nombre)) { errorElements.nombre.textContent = "Nombre inválido."; esValido = false; }
    if (!nombreRegex.test(apellidoPater)) { errorElements.apePater.textContent = "Apellido paterno inválido."; esValido = false; }
    if (!nombreRegex.test(apellidoMater)) { errorElements.apeMater.textContent = "Apellido materno inválido."; esValido = false; }
    if (!curpRegex.test(curp)) { errorElements.curp.textContent = "CURP inválida."; esValido = false; }
    if (!telefonoRegex.test(telefono)) { errorElements.telefono.textContent = "Teléfono inválido (10 dígitos)."; esValido = false; }
    if (!correoRegex.test(correo)) { errorElements.correo.textContent = "Correo debe ser institucional (@alumno.ipn.mx)."; esValido = false; }
    if (!passwordRegex.test(password)) { errorElements.password.textContent = "Contraseña inválida. Mínimo 6 caracteres, una mayúscula, un número y un carácter especial."; esValido = false; }
    if (academia === "" || academia === "Selecciona una opción") { errorElements.academia.textContent = "Selecciona una academia válida."; esValido = false; }
    if (curso === "" || curso === "Selecciona un curso") { errorElements.curso.textContent = "Selecciona un curso válido."; esValido = false; }
    if (!horario) { errorElements.horario.textContent = "Debes seleccionar un horario."; esValido = false; }
    if (!proyectoEquipoRegex.test(nombreProyecto)) { errorElements.nombre_proyecto.textContent = "Nombre de proyecto inválido (mínimo 3 caracteres)."; esValido = false; }
    if (!proyectoEquipoRegex.test(nombreEquipo)) { errorElements.nombre_equipo.textContent = "Nombre de equipo inválido (mínimo 3 caracteres)."; esValido = false; }

    if (!esValido) return false;

    const mensajeHTML = `<p><strong>Hola ${nombre}, verifica que los datos que ingresaste sean correctos:</strong></p><ul><li><strong>No de boleta:</strong> ${boleta}</li><li><strong>Nombre:</strong> ${nombre} ${apellidoPater} ${apellidoMater}</li><li><strong>CURP:</strong> ${curp}</li><li><strong>Género:</strong> ${genero}</li><li><strong>Teléfono:</strong> ${telefono}</li><li><strong>Semestre:</strong> ${semestre}</li><li><strong>Carrera:</strong> ${carrera}</li><li><strong>Concurso:</strong> ${concurso}</li><li><strong>Correo:</strong> ${correo}</li><li><strong>Academia:</strong> ${document.getElementById('academia').selectedOptions[0].text}</li><li><strong>Curso:</strong> ${document.getElementById('cursoSelect').selectedOptions[0].text}</li><li><strong>Horario Preferido:</strong> ${horario}</li><li><strong>Nombre del proyecto:</strong> ${nombreProyecto}</li><li><strong>Nombre del equipo:</strong> ${nombreEquipo}</li></ul>`;
    const contenidoVerificacion = document.getElementById("contenidoVerificacion");
    const modalVerificacionEl = document.getElementById('modalVerificacion');
    if (contenidoVerificacion && modalVerificacionEl) {
        contenidoVerificacion.innerHTML = mensajeHTML;
        new bootstrap.Modal(modalVerificacionEl).show();
    }
    return false; 
}

// =================================================================================
// LÓGICA DE LOS BOTONES DE LOS MODALES
// =================================================================================
document.addEventListener('DOMContentLoaded', () => {
    let datosNuevoRegistro = null; 

    const btnModificar = document.getElementById('btnModificarDatos');
    if (btnModificar) {
        btnModificar.addEventListener('click', () => {
            const modalVerificacion = bootstrap.Modal.getInstance(document.getElementById('modalVerificacion'));
            if (modalVerificacion) modalVerificacion.hide();
        });
    }

    const btnAceptar = document.getElementById('btnAceptarRegistro');
    if (btnAceptar) {
        btnAceptar.addEventListener('click', () => {
            const form = document.getElementById("formRegistro");
            if (!form) return;
            const formData = new FormData(form);

            formData.set("boleta", formData.get("boleta").trim());
            btnAceptar.disabled = true;

            fetch("PHP/registrar.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const modalVerificacion = bootstrap.Modal.getInstance(document.getElementById('modalVerificacion'));
                if (modalVerificacion) modalVerificacion.hide();

                if (data.status === "ok") {
                    datosNuevoRegistro = data.data;

                    // Cierra todos los posibles modales abiertos
                    ['modalRegistro', 'modalConfirmacion', 'modalVerificacion'].forEach(id => {
                        const modalEl = document.getElementById(id);
                        if (modalEl) bootstrap.Modal.getInstance(modalEl)?.hide();
                    });

                    // Mostrar el modal de éxito
                    const modalExito = new bootstrap.Modal(document.getElementById('modalRegistroExitoso'));
                    modalExito.show();

                    // Obtener el origen del formulario (usuarios_registrados o principal)
                    const origen = formData.get("origen") || "registro_principal";

                    // Esperar unos segundos y luego recargar
                    setTimeout(() => {
                        modalExito.hide();

                        // Si el registro viene del panel de administración, recargar para actualizar la tabla
                        if (origen === "usuarios_registrados") {
                            location.reload();
                        } else {
                            // Si es desde el registro general, redireccionar o limpiar
                            // Aquí puedes hacer otra cosa, como redirigir al login o limpiar el formulario
                            window.location.href = "login.html";
                        }
                    }, 3000);
                } else {
                    alert("❌ Error en el registro:\n" + (data.message || "Error desconocido."));
                }
            })
            .catch(err => {
                console.error("Error en la petición fetch:", err);
                alert("❌ Ocurrió un error crítico.");
            })
            .finally(() => {
                btnAceptar.disabled = false;
            });
        });
    }

    const btnDescargar = document.getElementById('btnDescargarAcuseRegistro');
    if (btnDescargar) {
        btnDescargar.addEventListener('click', () => {
            if (datosNuevoRegistro && datosNuevoRegistro.boleta) {
                const url = `PHP/generar_acuse_fpdf.php?boleta=${datosNuevoRegistro.boleta}`;
                window.open(url, '_blank');
            } else {
                alert("No se encontraron los datos para generar el acuse.");
            }
        });
    }
});