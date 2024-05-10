<form method="post" action="search.php">
<div class="inputrow">
    <input class="editing form_input" id="searchbox" name="title"></input>
    <button class="svgbutton floatright">Search</button>
</div>
<label id="blogtag_create" class="svgbutton" for="addBlogtag">Add Tag</label>
</form>
<button id="addBlogtag" hidden onclick="addBlogTag('blogtag_create')"></button>