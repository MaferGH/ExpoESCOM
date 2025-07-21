document.addEventListener('DOMContentLoaded', () => {

    const btnDiploma = document.getElementById('btnDiploma');

    btnDiploma.addEventListener('click', (event) => {
        event.preventDefault();

        if (!datosParticipanteGlobal || !datosParticipanteGlobal.boleta) {
            alert('No se pueden generar el diploma porque los datos del participante no se han cargado.');
            return;
        }

        const url = `PHP/generar_diploma_fpdf.php?boleta=${datosParticipanteGlobal.boleta}`;

        window.open(url, '_blank');
    });

});