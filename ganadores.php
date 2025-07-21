<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/Prototipo_expoEscom_VersionFinal/Prototipo_expoESCOM_Version2F/PHP/verificar_ganadores_portal.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="CSS/style2.css">
    <link rel="stylesheet" href="CSS/style.css">

    <link rel="icon" href="recursos/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <title>Ganadores | ExpoESCOM</title>
</head> 
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-sm bg-dark fixed-top shadow-sm">
  <div class="container">
    <a href="https://www.ipn.mx" target="_blank"><img src="recursos/ipn.png" class="logo-ipn" alt="Logo IPN" /></a>
    <a href="https://www.escom.ipn.mx" target="_blank"><img src="recursos/escom.png" class="logo-escom" alt="Logo ESCOM"/></a>
    <a class="navbar-brand ms-3 text-white"><strong>ExpoESCOM</strong></a>
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
      <i class="bi bi-list" style="color: white;"></i>
    </button>
    <div class="offcanvas offcanvas-end bg-dark text-white" tabindex="-1" id="offcanvasNavbar">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menú</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav ...">
    <li class="nav-item"><a class="nav-link text-white" href="inicio.html">Inicio</a></li>
    <li class="nav-item"><a class="nav-link text-white" href="registro.html">Registro</a></li>
    <li class="nav-item"><a class="nav-link text-white" href="ganadores.php">Ganadores</a></li>
      </div>
    </div>
  </div>
</nav>



<div class="modal fade" id="modalAdmin" tabindex="-1">
</div>

<div class="modal fade" id="modalLoginGanador" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Acceso al Portal de Ganadores</h5>
      </div>
      <div class="modal-body">
        <p>Este es un portal exclusivo. Para continuar, por favor, verifica tu identidad.</p>
        <form id="formLoginGanador">
          <div class="mb-3">
            <label for="ganadorCorreo" class="form-label">Correo Institucional</label>
            <input type="email" class="form-control" id="ganadorCorreo" name="correo" required>
          </div>
          <div class="mb-3">
            <label for="ganadorPassword" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="ganadorPassword" name="password" required>
          </div>
          <div id="errorLoginGanador" class="text-danger mb-2" style="display: none;"></div>
          <button type="submit" class="btn btn-secondary w-100">Verificar y Entrar</button>
          <a href="inicio.html" class="btn btn-link w-100 mt-2">Cancelar y volver al inicio</a>
        </form>
      </div>
    </div>
  </div>
</div>

<div id="contenidoGanadores" style="display: none;"> 
    <section class="hero-section">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6">
            <img src="recursos/ganadores.png" alt="preview" class="img-fluid app-preview" width="700" height="700"/>
          </div>
          <div class="col-md-6 text-center">
            <h1>Ganadores <span class="highlight fw-bold">ExpoESCOM</span></h1>
            <p class="text-center text-muted mb-4">¡Felicidades a los equipos que destacaron por su creatividad e innovación!</p>
          </div>
        </div>
      </div>
    </section>

    <section class="container mt-5 mb-5">
      <div class="row justify-content-center" id="topGanadores">
      </div>
    </section>

    <div style="width: 80%; margin: 0 auto;">
      <h3 class="text-center mb-4">Lista Completa de Ganadores</h3>
      <table class="table table-hover table-bordered shadow" id="tablaGanadores">
        <thead class="table-dark">
            <tr>
              <th>Posición</th>
              <th>Nombre Completo</th>
              <th>Boleta</th>
              <th>Carrera</th>
              <th>Proyecto</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
</div>

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
<script src="JS/ganadores_login.js"></script> 
<script src="JS/cargar_ganadores.js"></script> 

</body>
</html>