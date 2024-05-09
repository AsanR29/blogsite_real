var pageObj;
var selectedComment = false;
blogtagid_create = 1;
blogtagid_search = 1;

function getFormElements(type){
    var elements = [];
    if(type == "form"){
        elements = document.querySelectorAll(".form_input");
    }
    else if(type == "blogreport"){
        elements = document.querySelectorAll(".blog_report_input");
    }
    else if(type == "commentreport"){
        elements = document.querySelectorAll(".comment_report_input");
    }
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
    var post_vars = getFormElements("form");
    if(pageObj.destination == "../php_requests/create_comment.php"){
        post_vars["blog_url"] = pageObj.header_vars[0];
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
            console.log(Request.response['request_outcome']);
            if(Request.response['request_outcome'] == false){
                console.log(Request.response['class']['account_id'] != null);
                if(Request.response['class']['account_id'] != null && !Request.response['class']['account_id']){
                    loadPopup("popuplogin");
                }
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

function requestPhp(filename, post_vars, element_id){
    //var filename = pageObj.destination;
    post_vars = JSON.stringify(post_vars);
    //console.log(post_vars);
    var Request = makeRequest();
    Request.open("POST", filename);
    Request.setRequestHeader('Content-Type', 'application/json');
    Request.onreadystatechange = function(){
        if(Request.readyState == 4 && Request.status == 200){
            console.log(Request.responseText);
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
        this.loadable = false;
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

function createLoadable(filename, element_id, post_id, page){
    console.log("HEY");
    var newLoadable = new LoadableElement(filename, element_id, post_id, page);
    pageObj.loadable = newLoadable;
    if(filename == "../loaders/load_comments.php"){
        newLoadable.post_vars["blog_url"] = post_id;
    }
    else if (filename == "../loaders/load_blogposts.php"){
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
    div = document.getElementById(location);
    var id = 0;
    if(location == "blogtag_create"){
        id = blogtagid_create;
        blogtagid_create += 1;
    }
    else if(location == "blogtag_search"){
        id = blogtagid_search;
        blogtagid_search += 1;
    }
    div.insertAdjacentHTML('afterend','<div id="blogtag_' + id + '" class="inputrow padbottom"><input name="blog_tag[]" type="text" class="createbloginput form_input" required></input><button onclick="removeBlogtag(' + id + ')" class="svgbutton">Remove</button></div>');
    return;
}

function removeBlogtag(id){
    div = document.getElementById("blogtag_"+id);
    div.outerHTML = "";
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