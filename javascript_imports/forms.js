var pageObj;

function getFormElements(){
    var elements = document.querySelectorAll(".form_input");
    var post_vars = {};
    for(let i = 0; i < elements.length; i++){
        post_vars[elements[i].getAttribute("name")] = elements[i].value;
    }
    return post_vars;
}

function makeRequest(){
    var Request = null;
    if(window.XMLHttpRequest){
        Request = new XMLHttpRequest();
    }
    else if(window.ActiveXObject){
        Request = new ActiveXObject("Microsoft.XMLHTTP");
    }
    return Request;
}

function sendForm(){
    var filename = pageObj.destination;
    var post_vars = JSON.stringify(getFormElements());
    //console.log(post_vars);
    var Request = makeRequest();
    Request.responseType = 'json';
    Request.open("POST", filename);
    Request.setRequestHeader('Content-Type', 'application/json');
    Request.onreadystatechange = function(){
        if(Request.readyState == 4 && Request.status == 200){
            console.log(Request.response);
            console.log(Request.response['request_outcome']);
            if(Request.response['request_outcome'] == false){
                fillErrors(Request.response['class']);
            }
            else if(Request.response['redirect']){
                window.location.replace(Request.response['redirect']);
            }
            //document.getElementById(destination).innerHTML = Request.responseText;
        }
    }
    Request.send(post_vars);
}

function requestPhp(){
    var filename = pageObj.destination;
    var post_vars = JSON.stringify(getFormElements());
    //console.log(post_vars);
    var Request = makeRequest();
    Request.open("POST", filename);
    Request.setRequestHeader('Content-Type', 'application/json');
    Request.onreadystatechange = function(){
        if(Request.readyState == 4 && Request.status == 200){
            console.log(Request.responseText);
            //document.getElementById(destination).innerHTML = Request.responseText;
        }
    }
    Request.send(post_vars);
}

function fillErrors(response){
    var attributes = Object.keys(response);
    var element_id = "";
    var element = null;
    console.log(attributes);
    for(let i = 0; i < attributes.length; i++){
        element_id = "error_" + attributes[i];
        element = document.getElementById(element_id);
        console.log(element_id, element);
        if(element){
            if(response[attributes[i]]){
                element.innerHTML = "";
            }
            else{
                element.innerHTML = "*Invalid";
            }
        }
    }
}

class CurrentPage {
    constructor(header_vars, destination){
        this.header_vars = header_vars;
        this.destination = destination;
    }
}

function updateCssSize(){
    var height = window.innerHeight;
    var width = window.innerWidth;
    document.documentElement.style.setProperty('--height', height + "px");
    document.documentElement.style.setProperty('--width', width + "px");
}

function checkfile(){
    var element = document.getElementById("imageSubmission");
    console.log(element.files);
}