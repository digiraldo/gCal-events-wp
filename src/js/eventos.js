//let id_cal = "35b2qba53usalutistin2t916o@group.calendar.google.com";
//let api_key = "AIzaSyB4x70PYpmslKqPy_fvvoMMTKADc9UdifE";
let maxitem = 4;
let now = new Date().toJSON();
let actual = new Date();
let espXmas = ".replace(' ', '+')";
let espXnada = ".replace(' ', '')";
let espXlinea = ".replace(' ', '-')";

let gCalUrl = `https://www.googleapis.com/calendar/v3/calendars/${id_cal}/events?key=${api_key}&maxResults=${maxitem}&orderBy=startTime&timeMin=${now}&singleEvents=true`;
let gCalUrlShare = `http://www.google.com/calendar/embed?src=${id_cal}`

let loc = window.location;
let pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
let absolute = loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
//let urlapi = "../wp-content/plugins/gCal-events-wp/admin/build/api/apikey.php";
let urlapi = "../wp-content/plugins/gCal-events-wp/admin/build/json/fondo_config.json";
let hrefapi = `${absolute}${urlapi}`;
let apiConfig = hrefapi;

function buscarEventos() {
    fetch(gCalUrl)
    .then(response => response.json())
    .then(datos => {
        //console.table(datos);
        mostrarEventos(datos);
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
    const calendario = datos.summary;
    const calDes = datos.description;
    const actualizado = datos.updated;
    const item = datos.items;
    const nodato = datos.error;
    const idval = 1;
    const keyval = 1;
    const formularioId = document.querySelector('.id-key');
    console.log(datos);
    console.log(nodato);
    console.log("id_cal: " + id_cal);
    console.log("api_key: " + api_key);

    if (nodato != undefined) {
        if (id_cal === '' && api_key === '') {
            mostrarAlerta(`Introduzca el El Id del Calendario y la Api-Key de Google.`, true);
            return;
        } else if (datos.error.code === 404 && api_key === '') {
            mostrarAlerta(`Id del Calendario no valido. \n Api-Key vacío.`, true);
            return;
        } else if (id_cal === '' && datos.error.code === 404) {
            mostrarAlerta(`Api-Key no válido. \n Id del Calendario vacío.`, true);
            return;
        } else if (id_cal === '' && datos.error.code === 400) {
            mostrarAlerta(`Api-Key no válido. \n Id del Calendario vacío.`, true);
            return;
        } else if (datos.error.code === 403 && api_key === '') {
            mostrarAlerta(`Api-Key vacío. \n Id del Calendario Valido.`, true);
            return;
        } else if (datos.error.code === 404) {
            mostrarAlerta(`Id del Calendario no valido.`, true);
            return;
        } else if (idval === 1 && datos.error.code === 400) {
            mostrarAlerta(`Api-Key no válido. \n Id del Calendario Valido.`, true);
            return;
        } else if (datos.error.code === 400) {
            mostrarAlerta(`Api-Key no válido.`, true);
            return;
        }
    }

    mostrarAlerta(`Id de Calendario y Api Key Correctos`);

    function mostrarAlerta(mensaje, error = null) {
        const alerta =  document.createElement('P');
        alerta.textContent = mensaje;

        if (error) {
            alerta.classList.add('errorid');
        } else {
            alerta.classList.add('correctoid');
        };

        formularioId.appendChild(alerta);

        setTimeout(() => {
            alerta.remove();
        }, 8000);
        console.log(alerta);
    }

    console.log(`Datos del gCal: ${gCalUrl}`);
}



buscarEventos();
