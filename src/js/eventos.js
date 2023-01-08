let id_cal = "35b2qba53usalutistin2t916o@group.calendar.google.com";
let api_key = "AIzaSyB4x70PYpmslKqPy_fvvoMMTKADc9UdifE";

let maxitem = 4;
let now = new Date().toJSON();
let actual = new Date();
let espXmas = ".replace(' ', '+')";
let espXnada = ".replace(' ', '')";
let espXlinea = ".replace(' ', '-')";

let gCalUrl = `https://www.googleapis.com/calendar/v3/calendars/${id_cal}/events?key=${api_key}&maxResults=${maxitem}&orderBy=startTime&timeMin=${now}&singleEvents=true`;
let gCalUrlTitle = `http://www.google.com/calendar/embed?src=${id_cal}`

function buscarEventos() {
    fetch(gCalUrl)
    .then(response => response.json())
    .then(data => {
        //console.table(data);
        mostrarEventos(data);
    })
    .catch(error => {
        console.error(`ERROR: ${error}`);
        //console.error("ERROR: " + error);
    })
    .finally(() => {
        console.log("Ha Terminado de consultar los Eventos");
    })
}

function mostrarEventos(datos){

    if (datos.error) {
        if (datos.error.code === 400) {
            console.log(`La clave API: ${api_key} - no es válida. Pase una clave de API válida.`);
            return;
        } else if (datos.error.code === 403 && id_cal === '') {
            console.log(`Introduzca la Api-Key de Google y el El Id del Calendario.`);
            return;
        } else if (datos.error.code === 404 && id_cal === '') {
            console.log(`Introduzca Id del Calendario de Google - A la solicitud le falta Id del Calendario de Google.`);
            return;
        } else if (datos.error.code === 404) {
            console.log(`El Id del Calendario: ${id_cal} - No Encontrado. Pase un Id valido o verifique los permisos.`);
            return;
        } else if (datos.error.code === 403) {
            console.log(`Introduzca la Api-Key de Google - A la solicitud le falta una clave de API válida.`);
            return;
        }
        return false;
    }

    console.log('Logro la sincronización completa');
    console.log(`Datos del gCal: ${gCalUrl}`);
    

}

buscarEventos();
