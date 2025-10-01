var pageObj;
var selectedComment = false;
blogtagid_total = 1;
pres_total = 1;
input_ids = 1;

function getFormElements(type,node){
    var elements = [];
    if(type == "form"){
        elements = node.querySelectorAll(".form_input");
    }
    else if(type == "blogreport"){
        elements = node.querySelectorAll(".blog_report_input");
    }
    else if(type == "commentreport"){
        elements = node.querySelectorAll(".comment_report_input");
    }
    var post_vars = {};
    for(let i = 0; i < elements.length; i++){
        let key = elements[i].getAttribute("name");
        if(key in post_vars){
            if(!Array.isArray(post_vars[key])){
                post_vars[key] = [post_vars[key]]; }
            post_vars[key].push(elements[i].value);
        }
        else{
            post_vars[key] = elements[i].value; }
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

function sendForm(form_id=false){
    var filename = pageObj.destination;
    var node = document;
    if(form_id){
        node = document.getElementById(form_id);
    }
    var post_vars = getFormElements("form",node);

    if(pageObj.destination == "../php_requests/create_comment.php"){
        post_vars["blog_url"] = pageObj.header_vars[0];
    }
    if(form_id=="horse_search_area"){
        filename = pageObj.loadable.filename;
        requestPhp(filename,post_vars,pageObj.loadable.element_id);
        return;
    }
    var post_vars = JSON.stringify(post_vars);
    //console.log(post_vars);
    var Request = makeRequest();
    Request.responseType = 'json';
    Request.open("POST", filename);
    Request.setRequestHeader('Content-Type', 'application/json');
    Request.onreadystatechange = function(){
        if(Request.readyState == 4 && Request.status == 200){
            console.log(Request.response);
            if(Request.response['request_outcome'] == false){
                if(Request.response['class']['account_id'] != null && !Request.response['class']['account_id']){
                    loadPopup("popuplogin");
                }
                fillErrors(Request.response['class']);
            }
            else if(Request.response['redirect']){
                window.location.replace(Request.response['redirect']);
            }
            if(filename == '../php_requests/create_comment.php'){
                requestPhp(pageObj.loadable.filename, pageObj.loadable.post_vars, pageObj.loadable.element_id);
                document.getElementById("testsubject").value = "";
            }
            //document.getElementById(destination).innerHTML = Request.responseText;
        }
    }
    Request.send(post_vars);
}

function requestPhp(filename, post_vars, element_id){
    //var filename = pageObj.destination;
    //console.log(post_vars);
    post_vars = JSON.stringify(post_vars);
    //console.log(post_vars);
    var Request = makeRequest();
    Request.open("POST", filename);
    Request.setRequestHeader('Content-Type', 'application/json');
    Request.onreadystatechange = function(){
        if(Request.readyState == 4 && Request.status == 200){
            //console.log(Request.responseText);
            if(element_id == "popupreportblog" || element_id == "popupreportcomment" || element_id == "deleteblog" || element_id == "deletecomment"){
                unloadPopup(element_id);
            }
            else{
                document.getElementById(element_id).innerHTML = Request.responseText;
            }
        }
    }
    Request.send(post_vars);
}

function fillErrors(response){
    var attributes = Object.keys(response);
    var element_id = "";
    var element = null;
    //console.log(attributes);
    for(let i = 0; i < attributes.length; i++){
        element_id = "error_" + attributes[i];
        element = document.getElementById(element_id);
        //console.log(element_id, element);
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

function skipInput(e, key_press_id, i, direction) {
    if(key_press_id == pageObj.key_press_id && pageObj.userInput[0] == true && pageObj.userInput[1] == e.key) {
        // potentially unchanged
        let inputDiv = pageObj.inputAreas[i].parentNode;
        let nextDiv;
        if(direction == 1){
            nextDiv = inputDiv.nextElementSibling;
        } else{ nextDiv = inputDiv.previousElementSibling; }

        let inputs_nodelist = nextDiv.querySelectorAll(".form_input");
        let next_input_id = inputs_nodelist[0].id;
        i = next_input_id;

        if(i > pageObj.inputAreas.length){ return; }
        pageObj.inputAreas[i-direction].focus();
        setTimeout(skipInput, 300, e, key_press_id, i, direction);
    }
}
function findInputCallback(n){
    return n.id == this.id;
}
class CurrentPage {
    constructor(header_vars, destination){
        this.header_vars = header_vars;
        this.destination = destination;
        this.loadable = false;

        this.userInput = [false,false];
        this.key_press_id = 1;
        this.updateInputAreas();
        this.senseKeyPresses();
    }
    updateInputAreas() { 
        this.inputAreas = Array.from(document.querySelectorAll(".form_input")); 
        let select_elements = document.getElementsByTagName("select");
        for(let i = 0; i < select_elements.length; i++){
            select_elements[i].addEventListener("keydown", function(e){
                if(e.key == "ArrowLeft" || e.key == "ArrowRight"){
                    e.preventDefault();
                }
            });
        }
    }
    senseKeyPresses() {
        document.querySelector("html").onkeydown = function(e){
            if(pageObj.userInput[0] == true && pageObj.userInput[1] == e.key){ return; }
            pageObj.userInput = [true,e.key]; ++pageObj.key_press_id;

            let current_input = document.activeElement;
            if(e.key == "ArrowLeft" || e.key == "ArrowRight") {
                let i = pageObj.inputAreas.findIndex(findInputCallback, current_input); //this is set to current_input in the callback
                let direction;
                if(e.key == "ArrowLeft"){ i -= 1; direction = -1; } else{ i += 1; direction = 1; }  //ArrowRight = +1
                pageObj.inputAreas[i].focus();
                setTimeout(skipInput, 500, e, pageObj.key_press_id, i, direction);
            }
        };
        document.querySelector("html").onkeyup = function(e){
            if(pageObj.userInput[0] == true && e.key == pageObj.userInput[1]) {
                pageObj.userInput = [false,false];
            }
        };
    }
}

function updateCssSize(){
    var height = window.innerHeight;
    var width = window.innerWidth;
    document.documentElement.style.setProperty('--height', height + "px");
    document.documentElement.style.setProperty('--width', width + "px");
}

class LoadableElement {
    constructor(filename, element_id, post_id, page){
        this.filename = filename;
        this.element_id = element_id;
        this.post_id = post_id;
        this.page = page;
        this.post_vars = {};
    }
}

function createLoadable(filename, element_id, post_id, page, dict){
    var newLoadable = new LoadableElement(filename, element_id, post_id, page);
    pageObj.loadable = newLoadable;
    if(filename == "../loaders/load_comments.php"){
        newLoadable.post_vars["blog_url"] = post_id;
    }
    else if (filename == "../loaders/load_blogposts.php"){
        newLoadable.post_vars["username"] = post_id;
        if(dict){
            newLoadable.post_vars["title"] = dict["title"];
            newLoadable.post_vars["blog_tag"] = dict["blog_tag"];
        }
    }
    else if (filename == "../loaders/load_trainers.php"){
        newLoadable.post_vars["username"] = post_id;
    }
    newLoadable.post_vars["page"] = page;
    requestPhp(filename, newLoadable.post_vars, element_id);
}

function movePage(direction){
    pageObj.loadable.page += direction;
    pageObj.loadable.page = Math.max(pageObj.loadable.page, 0);
    pageObj.loadable.post_vars["page"] = pageObj.loadable.page;
    requestPhp(pageObj.loadable.filename, pageObj.loadable.post_vars, pageObj.loadable.element_id);
}

function unloadPopup(element_id){
    if(element_id == "popuplogin"){
        document.documentElement.style.setProperty('--popuplogin', "0%");
    }
    if(element_id == "popupreportblog"){
        document.documentElement.style.setProperty('--popupreportblog', "0%");
    }
    if(element_id == "popupreportcomment"){
        document.documentElement.style.setProperty('--popupreportcomment', "0%");
    }
    if(element_id == "deleteblog"){
        document.documentElement.style.setProperty('--deleteblog', "0%");
    }
    if(element_id == "deletecomment"){
        document.documentElement.style.setProperty('--deletecomment', "0%");
    }
    if(element_id == "popupimage"){
        document.documentElement.style.setProperty('--popupimage', "0%");
    }
}

function loadPopup(element_id){
    if(element_id == "popuplogin"){
        document.documentElement.style.setProperty('--popuplogin', "100%");
    }
    if(element_id == "popupreportblog"){
        document.documentElement.style.setProperty('--popupreportblog', "100%");
    }
    if(element_id == "popupreportcomment"){
        document.documentElement.style.setProperty('--popupreportcomment', "100%");
    }
    if(element_id == "deleteblog"){
        document.documentElement.style.setProperty('--deleteblog', "100%");
    }
    if(element_id == "deletecomment"){
        document.documentElement.style.setProperty('--deletecomment', "100%");
    }
}
function updateSelectedComment(button){
    var comment_id = button.getAttribute("name");
    selectedComment = parseInt(comment_id);
}

function reportBlog(blog_url){
    filename = "../php_requests/report_blog.php";
    element_id = "popupreportblog";
    var post_vars = getFormElements("blogreport");
    post_vars["blog_url"] = blog_url;
    requestPhp(filename, post_vars, element_id);
}

function reportComment(){
    filename = "../php_requests/report_comment.php";
    element_id = "popupreportcomment";
    var post_vars = getFormElements("commentreport");
    post_vars["comment_id"] = selectedComment;
    requestPhp(filename, post_vars, element_id);
}

function addBlogTag(location){
    text = document.getElementById("tag_source").innerHTML;
    text = text.trim();
    text = text.replace("<br>", "");
    if(text == ""){
        return;
    }
    //---
    post_vars = {"blogtag":text};
    post_vars = JSON.stringify(post_vars);
    var Request = makeRequest();
    Request.open("POST", "../php_requests/update_blogtag.php");
    Request.setRequestHeader('Content-Type', 'application/json');
    
    Request.send(post_vars);
    //---

    div = document.getElementById(location);
    var id = 0;
    id = pres_total;
    pres_total += 1;
    div.insertAdjacentHTML('afterend','<div id="pres_blogtag_' + id + '" class="blogtagdiv"><span name="blogtag_' + id + '" class="blog_tag">' + text + '</span><button onclick="removeBlogtag(' + id + ')" class="gen_button blogtagbutton unround">X</button></div>');
    return;
}

function removeBlogtag(id){
    div = document.getElementById("blogtag_"+id);
    div.outerHTML = "";

    //---
    post_vars = {"index":id};
    post_vars = JSON.stringify(post_vars);
    var Request = makeRequest();
    Request.open("POST", "../php_requests/update_blogtag.php");
    Request.setRequestHeader('Content-Type', 'application/json');
    
    Request.send(post_vars);
    //---
    return;
}

function clearTags(){
    let id = 0;
    div = document.getElementById("blogtag_"+id);
    while(div){
        div.outerHTML = "";
        id += 1;
        div = document.getElementById("blogtag_"+id);
    }

    //---
    var Request = makeRequest();
    Request.open("POST", "../php_requests/clear_blogtags.php");
    Request.setRequestHeader('Content-Type', 'application/json');
    Request.onreadystatechange = function(){
        if(Request.readyState == 4 && Request.status == 200){
            div = document.getElementById("blogtagarea");
            div.innerHTML = Request.responseText;
        }
    }
    Request.send();
    //---
    return;
}

function addNewBlogTag(location){
    text = document.getElementById("tag_source_new").innerText;
    text = text.trim();
    text = text.replace("<br>", "");
    if(text == ""){
        return;
    }

    div = document.getElementById(location);
    var id = 0;
    try{
        if(pageObj.header_vars[0] != -1){
            blogtagid_total = parseInt(pageObj.header_vars[0]);
            pageObj.header_vars[0] = -1;
            id = blogtagid_total;
            blogtagid_total += 1;
        }
        else{
            id = blogtagid_total;
            blogtagid_total += 1;
        }
    }
    catch{
        id = blogtagid_total;
        blogtagid_total += 1;
    }
    div.insertAdjacentHTML('beforeend','<div id="blogtagvis_' + id + '" class="blogtagdiv"><span name="blogtag_' + id + '" class="blog_tag">' + text + '</span><button type="button" onclick="removeNewBlogtag(' + id + ')" class="gen_button blogtagbutton unround">X</button></div>');
    div.insertAdjacentHTML('afterend','<div hidden id="blogtagnew_' + id + '"><input name="blog_tag[]" hidden value="' + text + '"></input></div>');
    return;
}

function removeNewBlogtag(id){
    div = document.getElementById("blogtagvis_"+id);
    div.outerHTML = "";

    div = document.getElementById("blogtagnew_"+id);
    div.outerHTML = "";
    return;
}

function deleteBlog(blog_url){
    filename = "../php_requests/delete_blog.php";
    element_id = "deleteblog";
    post_vars = {"blog_url": blog_url};
    requestPhp(filename, post_vars, element_id);
}

function deleteComment(){
    filename = "../php_requests/delete_comment.php";
    element_id = "deletecomment";
    post_vars = {"comment_id": selectedComment};
    requestPhp(filename, post_vars, element_id);
}

function popupimage(url){
    document.documentElement.style.setProperty('--popupimage', "100%");
    document.getElementById("zoomimage").src = url;
}

//umamusume
function addNewHorseRecord(location,type){
    div = document.getElementById(location);
    var id = 0;
    try{
        if(pageObj.header_vars[0] != -1){
            blogtagid_total = parseInt(pageObj.header_vars[0]);
            pageObj.header_vars[0] = -1;
            id = blogtagid_total;
            blogtagid_total += 1;
        }
        else{
            id = blogtagid_total;
            blogtagid_total += 1;
        }
        if(pageObj.header_vars[1]){
            pageObj["trainee_dict"] = pageObj.header_vars[1];   // new attribute?
        }
    }
    catch{
        id = blogtagid_total;
        blogtagid_total += 1;
    }
    switch(type){
        case "race":
            div.insertAdjacentHTML('beforeend','<div id="horse_record_' + id + '" class="race_record_grid"><input id='+input_ids+' name="race_name[]" type="text" class="horse_record_input form_input" placeholder="race name"></input><select id='+(input_ids+1)+' name="race_grade[]" class="horse_record_input form_input"><option value="0">DEBUT</option><option value="1">MAIDEN</option><option value="2">OP</option><option value="3">G3</option><option value="4">G2</option><option selected value="5">G1</option><option value="6">EX</option></select><input id='+(input_ids+2)+' name="race_distance[]" type="number" class="horse_record_input form_input" placeholder="1600"></input><select id='+(input_ids+3)+' name="racecourse[]" class="horse_record_input form_input"><option value="0">Sapporo</option><option value="1">Hakodate</option><option value="2">Fukushima</option><option value="3">Niigata</option><option value="4">Tokyo</option><option value="5">Nakayama</option><option value="6">Chukyo</option><option value="7">Kyoto</option><option value="8">Hanshin</option><option value="9">Kokura</option><option value="10">Oi</option></select><select id='+(input_ids+4)+' name="race_track_type[]" class="horse_record_input form_input"><option selected value="0">Turf</option><option value="0">Dirt</option></select><select id='+(input_ids+5)+' name="race_direction[]" class="horse_record_input form_input"><option selected value="0">Left</option><option value="0">Right</option></select><button type="button" onclick="removeRaceRecord(' + id + ')" class="gen_button blogtagbutton unround">X</button></div>');
            input_ids += 6;
            break;
        case "skill":
            div.insertAdjacentHTML('beforeend','<div id="horse_record_' + id + '" class="skill_record_grid"><input id='+(input_ids)+' name="skill_name[]" type="text" class="horse_record_input form_input" placeholder="skill name"></input><select id='+(input_ids+1)+' name="skill_type[]" class="horse_record_input form_input"><option value="0">passive normal</option><option value="1">passive negative</option><option value="2">stamina normal</option><option value="3">stamina rare</option><option selected value="4">speed normal</option><option value="5">speed rare</option><option value="6">speed negative</option><option value="7">debuff normal</option><option value="8">debuff rare</option><option value="9">speed unique</option><option value="10">stamina unique</option><option value="11">speed inherited</option><option value="12">stamina inherited</option></select><input id='+(input_ids+2)+' name="skill_level[]" type="number" class="horse_record_input form_input" placeholder="1"></input><button type="button" onclick="removeRaceRecord(' + id + ')" class="gen_button blogtagbutton unround">X</button></div>');
            input_ids += 3;
            break;
        case "card":
            let text = '<div id="horse_record_' + id + '" class="card_record_grid"><input id='+(input_ids)+' name="card_name[]" type="text" class="horse_record_input form_input" placeholder="happiest day"></input><select id='+(input_ids+1)+' name="trainee_enum[]" class="horse_record_input form_input">';
            let trainee_keys = Object.keys(pageObj.trainee_dict);
            let selected = true;
            for(let key of trainee_keys){
                text+= '<option' + (selected ? ' selected ' : ' ') + 'value="' + key + '">' + pageObj.trainee_dict[key] + '</option>';
                selected = false;
            }
            text += '</select><select id='+(input_ids+2)+' name="stat[]"class="horse_record_input form_input"><option value="0">speed</option><option value="1">stamina</option><option value="2">power</option><option selected value="3">guts</option><option value="4">wit</option></select><select id='+(input_ids+3)+' name="rarity[]" class="horse_record_input form_input"><option value="0">R</option><option value="1">SR</option><option value="2">SSR</option></select><button type="button" onclick="removeRaceRecord(' + id + ')" class="gen_button blogtagbutton unround">X</button></div>';
            div.insertAdjacentHTML('beforeend',text);
            input_ids += 4;
            break;
    }
    pageObj.updateInputAreas();
    return;
}

function removeRaceRecord(id){
    div = document.getElementById("horse_record_"+id);
    div.outerHTML = ""; return;
}