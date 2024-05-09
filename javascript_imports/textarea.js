function measureTextarea(){
    var element = document.getElementById("testsubject");
    var w = element.offsetWidth + "px";
    var h = element.offsetHeight + "px";
    var x = element.offsetLeft + "px";
    var y = element.offsetTop + "px";

    //var letterWidth = window.getComputedStyle(element).getPropertyValue("font-size");
    //letterWidth = parseInt(letterWidth.replace("px", ""));
    var text = element.value;
    //console.log("EAEE");
    //console.log(boxWidth.toString(), letterWidth, text.length*letterWidth, text);
    //aint that something!
    document.documentElement.style.setProperty('--textarea-width', w);
    document.documentElement.style.setProperty('--textarea-height', h);
    document.documentElement.style.setProperty('--textarea-x', x);
    document.documentElement.style.setProperty('--textarea-y', y);

    document.getElementById("shadowArea").innerText = text;
    element = document.getElementById("shadowArea");
    //console.log(element.offsetHeight, h);
    if(element.offsetHeight != h){
        var newRows = Number.parseInt(element.offsetHeight / 20) +1;
        element = document.getElementById("testsubject");
        element.rows = newRows.toString();
        //console.log(newRows);
        //document.documentElement.style.setProperty('--textarea-input-height', element.offsetHeight);
    }
    
}
//setInterval(measureTextarea, 10);