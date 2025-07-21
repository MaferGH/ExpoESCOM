<?php include 'PHP/verificar_admin.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>UsuariosRegistrados</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="icon" href="recursos/favicon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100" >
    <nav class="navbar navbar-expand-sm bg-dark fixed-top shadow-sm">
  <div class="container">
    <a href="javascript:history.back()" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
    <a href="https://www.ipn.mx" target="_blank"><img src="recursos/ipn.png" class="logo-ipn" alt="Logo IPN" /></a>
    <a href="https://www.escom.ipn.mx" target="_blank"><img src="recursos/escom.png" class="logo-escom" alt="Logo ESCOM"/></a>
    <a class="navbar-brand ms-3 text-white"><strong>USUARIOS REGISTRADOS</strong></a>
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
      <i class="bi bi-list" style="color: white;"></i>
    </button>

    <div class="offcanvas offcanvas-end bg-dark text-white" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menú</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
    </div>
  </div>
</nav>


<!-- Mensaje de bienvenida -->
<section class="container mt-4">
  <div class="alert alert-info text-center shadow-sm" role="alert">
    Bienvenido(a) al panel de administración. Aquí puedes gestionar toda la información de la ExpoESCOM 2025.
  </div>
</section>

<section class="hero-section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <img src="recursos/admin.JPG" alt="preview" class="img-fluid app-preview" width="700" height="700"/>
        </div>
        <div class="col-md-6 text-center">
        <h1>Panel de <span class="highlight fw-bold">Administración</h1>
        <p class="text-center text-muted mb-4">Gestiona los proyectos, usuarios y resultados del evento.</p>  
        </div>
      </div>
    </div>
  </section>

<!----------------------------------------------------------------------------------------->
<!-- Botón flotante con tooltip para añadir participante -->
  <button 
    type="button" 
    class="btn btn-success rounded-circle shadow-lg" 
    style="position: fixed; bottom: 20px; right: 20px; width: 60px; height: 60px;"
    title="Añadir participante"
    data-bs-toggle="modal" 
    data-bs-target="#modalRegistro">
    <i class="bi bi-plus-lg fs-4"></i>
  </button>

  <!-- Modal con formulario -->
  <div class="modal fade" id="modalRegistro" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-dark text-white">
          <h5 class="modal-title" id="modalRegistroLabel">Añadir Participante</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
         <form id="formRegistro" action="PHP/registrar.php" method="POST" onsubmit="return validarFormulario();">
          <input type="hidden" id="origen" name="origen" value="usuarios_registrados">
          <div class="card p-4 form-section">

            <!--***SECCIÓN DE DATOS PERSONALES***-->
            <h4>Datos Personales</h4>
            <div class="mb-3">
              <!--Número de boleta-->
              <label for="boleta" class="form-label">Número de Boleta</label>
              <input type="text" class="form-control" id="boleta" name="boleta" required>
              <span class="text-danger small" id="errorBoleta"></span>
            </div>
            <!--Nombre(s)-->
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre(s)</label>
              <input type="text" class="form-control" id="nombre" name="nombre" required>
              <span class="text-danger small" id="errorNombre"></span>
            </div>
            <!--Apellido paterno-->
            <div class="mb-3">
              <label for="apePater" class="form-label">Apellido paterno</label>
              <input type="text" class="form-control" id="apePater"  name="apePater" required>
              <span class="text-danger small" id="errorApePater"></span>
            </div>
            <!--Apellido materno-->
            <div class="mb-3">
              <label for="apeMater" class="form-label">Apellido materno</label>
              <input type="text" class="form-control" id="apeMater"  name="apeMater" required>
              <span class="text-danger small" id="errorApeMater"></span>
            </div>
            <!--Género-->
            <div class="mb-3">
              <label class="form-label">Género</label>
              <div>
                <input type="radio" id="generoHombre" name="genero" value="Hombre" required>
                <label for="generoHombre">Hombre</label>
                <input type="radio" id="generoMujer" name="genero" value="Mujer" required>
                <label for="generoMujer">Mujer</label>
                <input type="radio" id="generoOtro" name="genero" value="Otro" required>
                <label for="generoOtro">Otro</label>
              </div>
            </div>
            <!--CURP-->
            <div class="mb-3">
              <label for="curp" class="form-label">CURP</label>
              <input type="text" class="form-control" id="curp"  name="curp" maxlength="18" required>
              <span class="text-danger small" id="errorCurp"></span>
            </div>
            <!--Teléfono-->
            <div class="mb-3">
              <label for="telefono" class="form-label">Teléfono</label>
              <input type="tel" class="form-control" id="telefono"  name="telefono" required>
              <span class="text-danger small" id="errorTelefono"></span>
            </div>
            <!--Semestre-->
            <div class="mb-3">
              <label for="semestre" class="form-label">Semestre</label>
              <select class="form-select" id="semestre"  name="semestre" required>
                <option value="">Selecciona una opción</option>
                <option value="1">Primero</option>
                <option value="2">Segundo</option>
                <option value="3">Tercero</option>
                <option value="4">Cuarto</option>
                <option value="5">Quinto</option>
                <option value="6">Sexto</option>
                <option value="7">Séptimo</option>
                <option value="8">Octavo</option>
              </select>
            </div>
            <!--Carrera-->
            <div class="mb-3">
              <label for="carrera" class="form-label">Carrera</label>
              <select class="form-select" id="carrera" name="carrera" required>
                <option value="">Selecciona una opción</option>
                <option value="ISC">ISC</option>
                <option value="LCD">LCD</option>
                <option value="IIA">IA</option>
              </select>
            </div>
            <!--Concurso-->
            <div class="mb-3">
              <label for="concurso" class="form-label">Concurso</label>
              <select class="form-select" id="concurso"  name="concurso" required>
                <option value="">Selecciona una opción</option>
                <option value="Hackathon">Hackathon</option>
                <option value="Ciencias Básicas">Ciencias Básicas</option>
                <option value="Programación">Programación</option>
                <option value="Innovación">Innovación</option>
              </select>
            </div>
          </div>
          <!--***SECCIÓN DE DATOS DE CUENTA***-->
          <div class="card p-4 form-section">
            <h4>Datos de Cuenta</h4>
            <div class="mb-3">
              <!--Correo Institucional-->
              <label for="correo" class="form-label">Correo Institucional</label>
              <input type="email" class="form-control" id="correo" name="correo" required>
              <span class="text-danger small" id="errorCorreo"></span>
            </div>
            <!--Password-->
            <div class="mb-3">
              <label for="password" class="form-label">Contraseña</label>
              <input type="password" class="form-control" id="password" name="password"required>
              <span class="text-danger small" id="errorPassword"></span>
            </div>
          </div>

        <!--***SECCIÓN DE DATOS DEL CONCURSO***-->
          <div class="card p-4 form-section">
          <h4>Datos del concurso</h4>
          <!--Academia-->
          <div class="mb-3">
            <label>Buscar por academia:</label>
            <select class="form-select w-50" id="academia" name="academia" onchange="actualizarOpciones()">
                <option value="">Selecciona una opción</option>
                <option value="ciencia_datos">Ciencia de Datos</option>
                <option value="ciencias_basicas">Ciencias Básicas</option>
                <option value="ciencias_computacion">Ciencias de la Computación</option>
                <option value="ciencias_sociales">Ciencias Sociales</option>
                <option value="fundamentos_sistemas">Fundamentos de Sistemas Electrónicos</option>
                <option value="ingenieria_software">Ingeniería de Software</option>
                <option value="inteligencia_artificial">Inteligencia Artificial</option>
                <option value="proyectos_estrategicos">Proyectos Estratégicos para la Toma de Decisiones</option>
                <option value="sistemas_digitales">Sistemas Digitales</option>
                <option value="sistemas_distribuidos">Sistemas Distribuidos</option>
            </select>
            <span class="text-danger small" id="errorAcademia"></span>
            </div>
        
            <!--Unidad de Aprendizaje-->
            <div class="mb-3" id="cursos" style="display: none;">
                <label>Selecciona un curso:</label>
                <select class="form-select w-50" id="cursoSelect" name="cursoSelect">
                    <option value="">Selecciona un curso</option>
                    <option class="ciencia_datos" value="analisis_series_tiempo">Análisis de Series de Tiempo</option>
                    <!--Ciencia de Datos-->
                    <option class="ciencia_datos" value="CD_CD_">Ciencia de Datos</option>
                    <option class="ciencia_datos" value="CD_AST">Análisis de Series de Tiempo</option>
                    <option class="ciencia_datos" value="CD_AAD">Analítica Avanzada de Datos</option>
                    <option class="ciencia_datos" value="CD_AVD">Analítica y Visualización de Datos</option>
                    <option class="ciencia_datos" value="CD_BDA">Bases de Datos Avanzadas</option>
                    <option class="ciencia_datos" value="CD_BD">Big Data</option>
                    <option class="ciencia_datos" value="CD_DM">Data Mining</option>
                    <option class="ciencia_datos" value="CD_DAAD">Desarrollo de Aplicaciones para Análisis de Datos</option>
                    <option class="ciencia_datos" value="CD_ICD">Introducción a la Ciencia de Datos</option>
                    <option class="ciencia_datos" value="CD_MAD">Matemáticas Avanzadas para la Ciencia de Datos</option>
                    <option class="ciencia_datos" value="CD_MD">Minería de Datos</option>
                    <option class="ciencia_datos" value="CD_MP">Modelado Predictivo</option>
                    <option class="ciencia_datos" value="CD_ME">Modelos Econométricos</option>
                    <option class="ciencia_datos" value="CD_PE">Procesos Estocásticos</option>
                    <option class="ciencia_datos" value="CD_PCD">Programación para la Ciencia de Datos</option>
                    <!--Ciencias basicas-->
                    <option class="ciencias_basicas" value="CB_AL">Álgebra Lineal</option>
                    <option class="ciencias_basicas" value="CB_AV">Análisis Vectorial</option>
                    <option class="ciencias_basicas" value="CB_C">Cálculo</option>
                    <option class="ciencias_basicas" value="CB_CA">Cálculo Aplicado</option>
                    <option class="ciencias_basicas" value="CB_CM">Cálculo Multivariable</option>
                    <option class="ciencias_basicas" value="CB_EE">Economic Engineering</option>
                    <option class="ciencias_basicas" value="CB_ED">Ecuaciones Diferenciales</option>
                    <option class="ciencias_basicas" value="CB_E">Estadística</option>
                    <option class="ciencias_basicas" value="CB_MAI">Matemáticas Avanzadas para la Ingeniería</option>
                    <option class="ciencias_basicas" value="CB_MD">Matemáticas Discretas</option>
                    <option class="ciencias_basicas" value="CB_ME">Mecánica y Electromagnetismo</option>
                    <option class="ciencias_basicas" value="CB_P">Probabilidad</option>
                    <option class="ciencias_basicas" value="CB_PE">Probabilidad y Estadística</option>
                    <option class="ciencias_basicas" value="CB_SATD">Statistical Analytics Tools for Data</option>
                    <!--Ciencias de la computación-->
                    <option class="ciencias_computacion" value="CC_AB">Algoritmos Bioinspirados</option>
                    <option class="ciencias_computacion" value="CC_AED">Algoritmos y Estructuras de Datos</option>
                    <option class="ciencias_computacion" value="CC_ADA">Análisis y Diseño de Algoritmos</option>
                    <option class="ciencias_computacion" value="CC_BB">Bioinformática Básica</option>
                    <option class="ciencias_computacion" value="CC_BI">Bioinformatics</option>
                    <option class="ciencias_computacion" value="CC_C">Compiladores</option>
                    <option class="ciencias_computacion" value="CC_CS">Complex Systems</option>
                    <option class="ciencias_computacion" value="CC_GG">Computer Graphics</option>
                    <option class="ciencias_computacion" value="CC_FP">Fundamentos de Programación</option>
                    <option class="ciencias_computacion" value="CC_GA">Genetic Algoritmos</option>
                    <option class="ciencias_computacion" value="CC_IC">Introduction to Cryptography</option>
                    <option class="ciencias_computacion" value="CC_MN">Métodos Numéricos</option>
                    <option class="ciencias_computacion" value="CC_PP">Paradigmas de Programación</option>
                    <option class="ciencias_computacion" value="CC_STC">Selected Topics in Cryptography</option>
                    <option class="ciencias_computacion" value="CC_TC">Teoría de la Computación</option>
                    <option class="ciencias_computacion" value="CC_TSA">Tópicos Selectos de Algoritmos Bioinspirados</option>
                    <option class="ciencias_computacion" value="CC_VAR">Virtual and Augmented Reality</option>
                    <!--Ciencias Sociales-->
                    <option class="ciencias_sociales" value="CS_COE">Comunicación Oral y Escrita</option>
                    <option class="ciencias_sociales" value="CS_DHS">Desarrollo de Habilidades Sociales para la Alta Dirección</option>
                    <option class="ciencias_sociales" value="CS_EL">Ética y Legalidad</option>
                    <option class="ciencias_sociales" value="CS_IES">Ingeniería Ética y Sociedad</option>
                    <option class="ciencias_sociales" value="CS_LP">Liderazgo Personal</option>
                    <option class="ciencias_sociales" value="CS_LDP">Liderazgo y Desarrollo Profesional</option>
                    <option class="ciencias_sociales" value="CS_MID">Metodología de la Investigación y Divulgación Científica</option>
                    <!--Fundamentos de Sistemas Electronicos-->
                    <option class="fundamentos_sistemas" value="FS_CE">Circuitos Eléctricos</option>
                    <option class="fundamentos_sistemas" value="FS_EA">Electrónica Analógica</option>
                    <option class="fundamentos_sistemas" value="FS_I">Instrumentación</option>
                    <option class="fundamentos_sistemas" value="FS_IC">Instrumentación y Control</option>
                    <!--Ingenieria de Software-->
                    <option class="ingenieria_software" value="IS_ADS">Análisis y Diseño de Sistemas</option>
                    <option class="ingenieria_software" value="IS_BD">Bases de Datos</option>
                    <option class="ingenieria_software" value="IS_DAMN">Desarrollo de Aplicaciones Móviles Nativas</option>
                    <option class="ingenieria_software" value="IS_DAW">Desarrollo de Aplicaciones Web</option>
                    <option class="ingenieria_software" value="IS_IS">Ingeniería de Software</option>
                    <option class="ingenieria_software" value="IS_ISSI">Ingeniería de Software para Sistemas Inteligentes</option>
                    <option class="ingenieria_software" value="IS_NRDB">Non Relational Databases</option>
                    <option class="ingenieria_software" value="IS_SQAD">Software Quality Assurance and Design Patterns</option>
                    <option class="ingenieria_software" value="IS_TDAW">Tecnologías para el Desarrollo de Aplicaciones Web</option>
                    <option class="ingenieria_software" value="IS_WAD">Web Application Development</option>
                    <option class="ingenieria_software" value="IS_WBDF">Web Client and Backend Development Frameworks</option>
                    <!--Inteligencia Artificial-->
                    <option class="inteligencia_artificial" value="IA_ALN">Aplicaciones de Lenguaje Natural</option>
                    <option class="inteligencia_artificial" value="IA_AM">Aprendizaje de Máquina</option>
                    <option class="inteligencia_artificial" value="IA_AMIA">Aprendizaje de Máquina e Inteligencia Artificial</option>
                    <option class="inteligencia_artificial" value="IA_FIA">Fundamentos de Inteligencia Artificial</option>
                    <option class="inteligencia_artificial" value="IA_IA">Inteligencia Artificial</option>
                    <option class="inteligencia_artificial" value="IA_IHM">Interacción Humano Máquina</option>
                    <option class="inteligencia_artificial" value="IA_ML">Machine Learning</option>
                    <option class="inteligencia_artificial" value="IA_NLP">Natural Language Processing</option>
                    <option class="inteligencia_artificial" value="IA_PLN">Procesamiento de Lenguaje Natural</option>
                    <option class="inteligencia_artificial" value="IA_PDI">Procesamiento Digital de Imágenes</option>
                    <option class="inteligencia_artificial" value="IA_RV">Reconocimiento de Voz</option>
                    <option class="inteligencia_artificial" value="IA_RNAP">Redes Neuronales y Aprendizaje Profundo</option>
                    <option class="inteligencia_artificial" value="IA_TLN">Tecnologías de Lenguaje Natural</option>
                    <option class="inteligencia_artificial" value="IA_TSAP">Temas Selectos de Aprendizaje Profundo</option>
                    <option class="inteligencia_artificial" value="IA_TSIA">Temas Selectos de Inteligencia Artificial</option>
                    <option class="inteligencia_artificial" value="IA_VA">Visión Artificial</option>
                    <!--Proyectos Estrategicos-->
                    <option class="proyectos_estrategicos" value="PE_APT">Administración de Proyectos de Ti</option>
                    <option class="proyectos_estrategicos" value="PE_FE">Finanzas Empresariales</option>
                    <option class="proyectos_estrategicos" value="PE_FEPI">Formulación y Evaluación de Proyectos Informáticos</option>            
                    <option class="proyectos_estrategicos" value="PE_FE">Fundamentos Económicos</option>
                    <option class="proyectos_estrategicos" value="PE_GE">Gestión Empresarial</option>
                    <option class="proyectos_estrategicos" value="PE_HTEM">High Technology Enterprise Management</option>
                    <option class="proyectos_estrategicos" value="PE_IET">Innovación y Emprendimiento Tecnológico</option>
                    <option class="proyectos_estrategicos" value="PE_ITG">IT Governance</option>
                    <option class="proyectos_estrategicos" value="PE_MCTD">Métodos Cuantitativos para la Toma de Desiciones</option>
                    <!--Sistemas Digitales-->
                    <option class="sistemas_digitales" value="SD_AC">Arquitectura de Computadoras</option>
                    <option class="sistemas_digitales" value="SD_DSD">Diseño de Sistemas Digitales</option>
                    <option class="sistemas_digitales" value="SD_ES">Embedded Systems</option>
                    <option class="sistemas_digitales" value="SD_FDD">Fundamentos de Diseño Digital</option>
                    <option class="sistemas_digitales" value="SD_IOT">Internet of Things</option>
                    <option class="sistemas_digitales" value="SD_IM">Introducción a los Microcontroladores</option>
                    <option class="sistemas_digitales" value="SD_PS">Procesamiento de Señales</option>
                    <option class="sistemas_digitales" value="SD_PDS">Procesamiento Digital de Señales</option>
                    <option class="sistemas_digitales" value="SD_SC">Sistemas en Chip</option>
                    <!--Sistemas Distribuidos-->
                    <option class="sistemas_distribuidos" value="SD_ASR">Administración de Servicios en Red</option>
                    <option class="sistemas_distribuidos" value="SD_ACR">Aplicaciones para Comunicaciones en Red</option>
                    <option class="sistemas_distribuidos" value="SD_C">Ciberseguridad</option>
                    <option class="sistemas_distribuidos" value="SD_CS">Computer Security</option>
                    <option class="sistemas_distribuidos" value="SD_CAD">Cómputo de Alto Desempeño</option>
                    <option class="sistemas_distribuidos" value="SD_CN">Cómputo en la Nube</option>
                    <option class="sistemas_distribuidos" value="SD_CP">Cómputo Paralelo</option>
                    <option class="sistemas_distribuidos" value="SD_CR">Cryptography</option>
                    <option class="sistemas_distribuidos" value="SD_DSD">Desarrollo de Sistemas Distribuidos</option>
                    <option class="sistemas_distribuidos" value="SD_PD">Protección de Datos</option>
                    <option class="sistemas_distribuidos" value="SD_RC">Redes de Computadoras</option>
                    <option class="sistemas_distribuidos" value="SD_SD">Sistemas Distribuidos</option>
                    <option class="sistemas_distribuidos" value="SD_SO">Sistemas Operativos</option>
                    <option class="sistemas_distribuidos" value="SD_TCS">Teoría de Comunicaciones y Señales</option>
                  </select>
                  <span class="text-danger small" id="errorCurso"></span>
            </div>
          
            <div class="mb-3" id="horarioPreferidoDiv" style="display: none;"> <!-- Oculto por defecto -->
                <label class="form-label">Horario de preferencia para la exposición:</label>
                <div class="form-check">
                <input class="form-check-input" type="radio" name="horario" id="horarioMatutino" value="matutino">
                <label class="form-check-label" for="horarioMatutino">Matutino (10:30 - 13:30)</label>
                </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="horario" id="horarioVespertino" value="vespertino">
                    <label class="form-check-label" for="horarioVespertino">Vespertino (15:00 - 18:00)</label>
                    </div>
                    <span class="text-danger small" id="errorHorario"></span>
                  </div>
            <!--Nombre del proyecto-->
            <div class="mb-3">
              <label for="nombre_proyecto" class="form-label">Nombre del proyecto</label>
              <input type="text" class="form-control" id="nombre_proyecto" name="nombre_proyecto" required>
              <span class="text-danger small" id="errorNombre_proyecto"></span>
            </div>
            <!--Nombre del equipo-->
            <div class="mb-3">
              <label for="nombre_equipo" class="form-label">Nombre del equipo</label>
              <input type="text" class="form-control" id="nombre_equipo" name="nombre_equipo" required>
              <span class="text-danger small" id="errorNombre_equipo"></span>
            </div>
            </div>
      
          <!--REGISTRO DE DATOS-->
          <div class="d-flex justify-content-between mt-3">
            <button type="submit" class="btn btn-dark">Registrar</button>
            <button type="reset" class="btn btn-secondary">Limpiar</button>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>

    <!-- Modal de Confirmación -->
<div class="modal fade modal-lg" id="modalVerificacion" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Verifica tus Datos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="contenidoVerificacion">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btnModificarDatos">Modificar</button>
        <button type="button" class="btn btn-primary" id="btnAceptarRegistro">Aceptar y Registrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal de éxito Registro 
<div class="modal fade" id="modalRegistroExitoso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="staticBackdropLabel">
          <i class="bi bi-check-circle-fill"></i> ¡Registro Completado!
        </h5>
      </div>
      <div class="modal-body text-center">
        <p class="fs-5">El registro a ExpoESCOM se ha realizado con éxito.</p>
      </div>
      <div class="modal-footer justify-content-center">
        Botón para ir al login 
        <a href="#" class="btn btn-dark btn-lg">
          Cerrar <i class="bi bi-arrow-right-circle"></i>
        </a>
      </div>
    </div>
  </div>
</div>
-->

  
  <!-- Modal Confirmación -->
<div class="modal fade" id="modalConfirmacion" tabindex="-1" aria-labelledby="modalConfirmacionLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="modalConfirmacionLabel">Confirmar Registro</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="contenidoModal">
        <!-- Aquí se inserta el resumen de datos con JS -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" id="btnConfirmarRegistro" class="btn btn-primary">Confirmar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal de éxito Registro -->
<div class="modal fade" id="modalRegistroExitoso" tabindex="-1" aria-labelledby="modalExitoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border shadow-sm">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="modalExitoLabel">
          <i class="bi bi-check-circle-fill"></i> Registro Exitoso
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
        <p class="text-success fw-bold">El registro a ExpoESCOM se ha realizado con éxito.</p>
      </div>
    </div>
  </div>
</div>


 <!-- Tarjetas resumen -->
<div class="container mt-4">
  <div class="row mb-6 align-items-stretch justify-content-center">
    <!-- Registrados -->
    <div class="col-md-4">
      <div class="card shadow-sm border-primary h-100">
        <div class="card-body text-primary text-center">
          <h5 class="card-title">Registrados</h5>
          <p id="totalRegistrados" class="fs-1">0</p> <!-- Cambiado -->
        </div>
      </div>
    </div>
    <!-- Ranking dinámico -->
    <div class="col-md-4">
      <div class="card shadow-sm border-success h-100">
        <div class="card-body">
          <h5 class="card-title text-success mb-3">Academias con más participación</h5>
          <ol id="rankingAcademias" class="ps-3 mb-0 small text-success">
            <!-- Aquí se insertan con JS -->
          </ol>
        </div>
      </div>
    </div>
  </div>
</div>


    <!-- Filtro -->
    <div class="container mt-4"> 
    <div class="mb-3 mt-4">
      <label>Buscar por academia:</label>
      <select class="form-select w-50" id="filtroAcademia">
        <option>Todas</option>
        <option>Ciencia de Datos</option>
        <option>Ciencias Básicas</option>
        <option>Ciencias de la Computación</option>
        <option>Ciencias Sociales</option>
        <option>Fundamentos de Sistemas Electrónicos</option>
        <option>Ingeniería de Software</option>
        <option>Inteligencia Artificial</option>
        <option>Proyectos Estratégicos para la Toma de Desiciones</option>
        <option>Sistemas Digitales</option>
        <option>Sistemas Distribuidos</option>
      </select>
    </div>
    </div>

    <!-- Tabla -->
     <!-- Tabla de participantes -->
  <div class="container mt-4">
    <h4 class="mb-3">Lista de Participantes</h4>
    <table class="table table-striped table-bordered table-hover shadow">
      <thead class="table-dark">
        <tr>
          <th>Boleta</th>
          <th>Nombre</th>
          <th>Proyecto</th>
          <th>Academia</th>
          <th>Horario</th>
          <th>Ganador</th>
          <th>Acciones</th>
          
        </tr>
      </thead>
      <tbody id="tablaAlumnos">
        <!-- Aquí se insertarán los registros dinámicamente -->
      </tbody>
    </table>
  </div>

  </div>

<!--=================================================================================
    MODALES
    =================================================================================
-->

  <!-- Modal de Confirmación de Eliminación -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="modalEliminarLabel">Confirmar Eliminación</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <p>¿Estás seguro de que deseas eliminar al participante <strong id="nombreEliminar"></strong>?</p>
        <input type="hidden" id="idEliminar">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal de éxito Eliminar-->
<div class="modal fade" id="modalExito" tabindex="-1" aria-labelledby="modalExitoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="modalExitoLabel">Participante eliminado</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
        <p class="text-success fw-bold">El participante fue eliminado correctamente.</p>
      </div>
    </div>
  </div>
</div>

<!-- Modal Editar Participante --> 
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formEditar" >
      <div class="modal-content">
        <div class="modal-header bg-dark text-white ">
          <h5 class="modal-title" id="modalEditarLabel">Editar Participante</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body row g-3">
          <input type="hidden" name="id" id="edit_id">

          <!-- Boleta y CURP -->
          <div class="col-md-6">
            <label>Boleta</label>
            <input type="text" name="boleta" id="edit_boleta" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label>CURP</label>
            <input type="text" name="curp" id="edit_curp" class="form-control" required>
          </div>

          <!-- Nombre y Apellidos -->
          <div class="col-md-4">
            <label>Nombre</label>
            <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
          </div>
          <div class="col-md-4">
            <label>Apellido Paterno</label>
            <input type="text" name="apellido_paterno" id="edit_apellido_paterno" class="form-control" required>
          </div>
          <div class="col-md-4">
            <label>Apellido Materno</label>
            <input type="text" name="apellido_materno" id="edit_apellido_materno" class="form-control" required>
          </div>

          <!-- Género y Teléfono -->
          <div class="col-md-6">
            <label>Género</label>
            <select name="genero" id="edit_genero" class="form-select" required>
              <option value="Hombre">Hombre</option>
              <option value="Mujer">Mujer</option>
              <option value="Otro">Otro</option>
            </select>
          </div>
          <div class="col-md-6">
            <label>Teléfono</label>
            <input type="text" name="telefono" id="edit_telefono" class="form-control" required>
          </div>

          <!-- Semestre y Carrera -->
          <div class="col-md-6">
            <label>Semestre</label>
            <input type="text" name="semestre" id="edit_semestre" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label>Carrera</label>
            <input type="text" name="carrera" id="edit_carrera" class="form-control" required>
          </div>

          <!-- Concurso y Correo -->
          <div class="col-md-6">
            <label>Concurso</label>
            <input type="text" name="concurso" id="edit_concurso" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label>Correo institucional</label>
            <input type="email" name="correo_institucional" id="edit_correo_institucional" class="form-control" required>
          </div>

          <!-- Academia y Unidad -->
          <div class="col-md-6">
            <label>Academia</label>
            <input type="text" name="academia" id="edit_academia" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label>Unidad de Aprendizaje</label>
            <input type="text" name="unidad_aprendizaje" id="edit_unidad_aprendizaje" class="form-control" required>
          </div>

          <!-- Horario preferencia -->
              <input type="hidden" name="horario_preferencia" id="edit_horario_preferencia">
             <div class="col-md-6">
             <label>Salón Asignado</label>
               <input type="text" name="salon_asignado" id="edit_salon_asignado" class="form-control" readonly>
            </div>

           <div class="col-md-6">
            <label>Horario Asignado</label>
             <input type="text" name="horario_asignado" id="edit_horario_asignado" class="form-control" readonly>
          </div>

          <!-- Proyecto y Equipo -->
          <div class="col-md-6">
            <label>Nombre del Proyecto</label>
            <input type="text" name="nombre_proyecto" id="edit_nombre_proyecto" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label>Nombre del Equipo</label>
            <input type="text" name="nombre_equipo" id="edit_nombre_equipo" class="form-control" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Guardar Cambios</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>


<!-- Modal de éxito Editar -->
<div class="modal fade" id="modalExitoEditar" tabindex="-1" aria-labelledby="modalExitoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="modalExitoLabelE">Datos actualizados</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
        <p class="text-success fw-bold">Los datos fueron actualizados correctamente</p>
      </div>
    </div>
  </div>
</div>



<!-- Modal Detalles Participante -->
<div class="modal fade" id="modalDetalles" tabindex="-1" aria-labelledby="modalDetallesLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="modalDetallesLabel">Detalles del Participante</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <ul class="list-group" id="listaDetalles">
          <!-- Detalles se llenan con JS -->
        </ul>
      </div>
    </div>
  </div>
</div>





<!----------------------------------------------------------------------------------------->
<!-- Footer -->
<footer class="bg-dark text-white py-4 mt-auto">
  <div class="container">
    <div class="row d-flex">
      <div class="col-md-6 mb-3 mb-md-0">
        <h5>ESCOM - IPN</h5>
        <p class="mb-0">Unidad Profesional Adolfo López Mateos<br>
        Av. Juan de Dios Bátiz s/n, Nueva Industrial Vallejo<br>
        Ciudad de México, C.P. 07738</p>
      </div>
      <div class="col-md-4 ms-auto">
        <h5>Elaborado por</h5>
        <ul class="list-unstyled">
          <li><i class="bi bi-person"></i> Castillo Avendaño Stephanie Amairany</li>
          <li><i class="bi bi-person"></i> García Hernández María Fernanda</li>
          <li><i class="bi bi-person"></i> Barranco García Kevin Alexis</li>
          <li><i class="bi bi-person"></i> Mora Olvera Abraham</li>
        </ul>
      </div>
    </div>
    <hr class="my-3">
    <div class="text-center">
      <p class="mb-0">© 2025 Equipo 3 - Todos los derechos reservados</p>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<script src="JS/admin.js"></script>    
<script src="JS/editar.js"></script>     
<script src="JS/eliminar.js"></script>   
<script src="JS/detalles.js"></script>   
<script src="JS/registro.js"></script>      

</body>
</html>