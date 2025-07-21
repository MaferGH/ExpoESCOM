document.addEventListener('DOMContentLoaded', () => {

    const btnAcuse = document.getElementById('btnAcuse');

    btnAcuse.addEventListener('click', (event) => {

        event.preventDefault();

        if (!datosParticipanteGlobal || !datosParticipanteGlobal.boleta) {
            alert('No se puede generar el acuse porque los datos del participante no se han cargado. Por favor, espere un momento.');
            return;
        }

        const url = `PHP/generar_acuse_fpdf.php?boleta=${datosParticipanteGlobal.boleta}`;

        window.open(url, '_blank');
    });

});