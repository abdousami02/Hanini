
function getSizeStr(size){
    let out_size = (size / 1000);
    if(out_size > 1000){
       out_size =  (out_size / 1000);
    }
    return  out_size.toFixed(1)+ 'KB'
}
// show Date like: 23 Nov 2024
function getDateStr(dateISO){
    return moment(dateISO).format('DD MMM YYYY');
}

function getDateTimeStr(dateISO){
    return moment(dateISO).format('DD MMM YYYY, HH:mm');
}


function appendScript(script_text, scriptClass='new-script'){

    let scripts = script_text.match(/<script\b[^>]*>([\s\S]*?)<\/script>/gi) || [];

    scripts.forEach(function(elem){
        let text = elem.replace(/^<script[^>]*>\s*|\s*<\/script>\s*$/g, '');
        // console.log(text);
        const script = document.createElement('script');
        script.type = 'text/javascript';
        script.text = text;
        script.classList.add(scriptClass)
        // console.log(script)
        document.body.appendChild(script);

    })
}

function deleteScript(selector){
    let scripts = document.querySelectorAll(selector);
    scripts.forEach((elem) => {elem.remove()})
}

function isImage(file){
    return file.type.split('/')[0] === 'image';
}

async function renderDataImage(image){
    let reader = new FileReader();
    reader.readAsDataURL(image);
    reader.onload = function(e){
        return e.target.result;
    }  
}

function showPosition(position) {
    console.log(position.coords);
    return "Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude;
}
  
function getLocation(success, error) {
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(success, error);

    }else{
        console.warn('Geolocation is not supported by this browser.')
    }
}


