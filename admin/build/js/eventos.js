// let id_cal = "35b2qba53usalutistin2t916o@group.calendar.google.com";
// let api_key = "AIzaSyB4x70PYpmslKqPy_fvvoMMTKADc9UdifE";
let maxitem = 4;
let now = new Date().toJSON();
let actual = new Date();  

let gCalUrl = `https://www.googleapis.com/calendar/v3/calendars/${id_cal}/events?key=${api_key}&maxResults=${maxitem}&orderBy=startTime&timeMin=${now}&singleEvents=true`;
//console.log(gCalUrl);

let container = document.querySelector(".gcf-item-container-block");

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
//buscarEventos();
function mostrarEventos(datos) {
    const calendario = datos.summary;
    const calDes = datos.description;
    const actualizado = datos.updated;
    const item = datos.items;

    let opciones = { year: 'numeric', month: 'short', day: 'numeric' };
    let fecha = new Date(actualizado)
    .toLocaleDateString('es-MX',opciones)
    .replace(/ /g,'-')
    .replace('.','')
    .replace(/-([a-z])/, function (x) {return '-' + x[1].toUpperCase()});

    const textoCalendario = document.querySelector('.gcf-title');
    textoCalendario.textContent = calendario;

    container.innerHTML = '';

    for (let valor of item) {

        const mesName = {month: 'short'};
        const diaName = {day: 'numeric'};
        const iniDateTime = new Date(valor.start.dateTime);
        const iniDate = new Date(valor.start.date);
        const finDateTime = new Date(valor.end.dateTime);
        const finDate = new Date(valor.end.date);
        const iniDiaTime = iniDateTime.toLocaleDateString('es-MX',diaName);
        const iniMesTimeMin = iniDateTime.toLocaleDateString('es-MX',mesName);
        const iniMesTime = iniMesTimeMin[0].toUpperCase() + iniMesTimeMin.substring(1)
        const finDiaTime = finDateTime.toLocaleDateString('es-MX',diaName);
        const finMesTimeMin = finDateTime.toLocaleDateString('es-MX',mesName);
        const finMesTime = finMesTimeMin[0].toUpperCase() + finMesTimeMin.substring(1)
        const iniDia = iniDate.toLocaleDateString('es-MX',diaName);
        const iniMesMin = iniDate.toLocaleDateString('es-MX',mesName);
        const iniMes = iniMesMin[0].toUpperCase() + iniMesMin.substring(1);
        const finDia = finDate.toLocaleDateString('es-MX',diaName);
        const finMes2 = finDate.toLocaleDateString('es-MX',mesName);
        const finMes = finMes2[0].toUpperCase() + finMes2.substring(1);

        if (valor.start.dateTime !== undefined) {
            starDateDia = iniDiaTime;
            starDateMes = iniMesTime;
        }else if (valor.start.date !== undefined) {
            starDateDia = iniDia;
            starDateMes = iniMes;
        }

        if (valor.end.dateTime !== undefined) {
            endDateDia = finDiaTime;
            endDateMes = finMesTime;
        }else if (valor.end.date !== undefined) {
            endDateDia = finDia;
            endDateMes = finMes;
        }

        // ---------------Quitar espacios mayúsculas y caracteres para url---------------
        const texto = valor.summary;
        let procesado = texto.replace(/\d+/g, '').trim();
        //console.log(procesado);

        let normalize = (function() {
            let from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç", 
                to   = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
                mapping = {};
            
            for(let i = 0, j = from.length; i < j; i++ )
                mapping[ from.charAt( i ) ] = to.charAt( i );
            
            return function( str ) {
                let ret = [];
                for( let i = 0, j = str.length; i < j; i++ ) {
                    let c = str.charAt( i );
                    if( mapping.hasOwnProperty( str.charAt( i ) ) )
                        ret.push( mapping[ c ] );
                    else
                        ret.push( c );
                }      
                //return ret.join( '' );
                return ret.join( '' ).replace(/\d+/g, '').trim().replace( /[^-A-Za-z0-9]+/g, '-' ).toLowerCase();
            }
            
            })();

        link = normalize(texto);
        
        container.innerHTML += `
        <div class="gcf-item-block">
            <div class="gcf-item-header-block">
              <div class="gcf-item-date-block">
                <span class="gcf-item-daterange">
                <h2 class="no-margin">${starDateDia}<br><span>${starDateMes}</span></h2>
                <br>
                <h3 class="no-margin">${endDateDia}<br><span>${endDateMes}</span></h3>
                </span>
              </div>
            </div>
            <div class="gcf-item-body-block">
              <div class="gcf-item-title-block">
                <strong class="gcf-item-title">${valor.summary}</strong>
              </div>
              <div class="gcf-item-description">
                ${valor.description}
              </div>
              <div class="gcf-item-location">
                ${valor.location}
              </div>
            </div>
            <div class="btn-calendario">
              <a href="${link}/" class="boton-roja" role="button">Ver más</a>
            </div>
          </div>
        `;
    }

    const textoActualizado = document.querySelector('.gcf-last-update');
    textoActualizado.textContent = fecha;
}
buscarEventos();
