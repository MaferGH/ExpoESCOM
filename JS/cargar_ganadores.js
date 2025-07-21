function cargarDatosGanadores() {

    fetch('PHP/obtener_lista_ganadores.php')
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const ganadores = data.ganadores;
                const tablaBody = document.getElementById('tablaGanadores').getElementsByTagName('tbody')[0];
                const topGanadoresDiv = document.getElementById('topGanadores');

                tablaBody.innerHTML = '';
                topGanadoresDiv.innerHTML = '';

                if (ganadores.length === 0) {
                    topGanadoresDiv.innerHTML = '<p class="text-center">Aún no se han anunciado los ganadores.</p>';
                    return;
                }

                ganadores.forEach((ganador, index) => {
                    const fila = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${ganador.nombre}</td>
                            <td>${ganador.apellido_paterno} ${ganador.apellido_materno}</td>
                            <td>${ganador.boleta}</td>
                            <td>${ganador.carrera}</td>
                        </tr>
                    `;
                    tablaBody.innerHTML += fila;

                    if (index < 3) {
                        const medallas = ['🥇', '🥈', '🥉'];
                        const colores = ['gold', 'silver', '#cd7f32']; 

                        const tarjeta = `
                            <div class="col-md-4 mb-4">
                                <div class="card text-center shadow h-100">
                                    <div class="card-body">
                                        <h2 style="font-size: 3rem; color: ${colores[index]}">${medallas[index]}</h2>
                                        <h5 class="card-title">${index + 1}º Lugar</h5>
                                        <p class="card-text fw-bold">${ganador.nombre} ${ganador.apellido_paterno}</p>
                                        <p class="card-text text-muted">Proyecto: ${ganador.nombre_proyecto}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        topGanadoresDiv.innerHTML += tarjeta;
                    }
                });
            } else {
                console.error("Error del servidor:", data.message);
                document.getElementById('topGanadores').innerHTML = '<p class="text-center text-danger">No se pudieron cargar los datos de los ganadores.</p>';
            }
        })
        .catch(err => {
            console.error("Error de conexión al cargar ganadores:", err);
            document.getElementById('topGanadores').innerHTML = '<p class="text-center text-danger">Error de conexión. Intente de nuevo más tarde.</p>';
        });
}