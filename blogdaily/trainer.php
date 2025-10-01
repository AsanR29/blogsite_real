<?php $pagetitle = "The Static details"; ?>
<?php require_once('../loaders/header.php'); 
$trainer_id = -1;
if(isset($_GET['trainer_id'])){
    $trainer_id = $_GET['trainer_id'];
    $_SESSION['trainer_id'] = $trainer_id;
} elseif(isset($_SESSION['trainer_id'])){
    $trainer_id = $_SESSION['trainer_id'];
}
?>
<?php require_once('../php_requests/load_horse_records.php');  ?>
<body onload='
    pageObj = new CurrentPage([0,<?php echo namesAsJavascript(); ?>], "../php_requests/create_horse_records.php"); 
    createLoadable("../loaders/load_horsesearch.php", "horse_searchresults", "", 0);
    updateCssSize();'>
<script type="text/javascript" src="../javascript_imports/textarea.js"></script>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>
<?php require_once('../loaders/nav_horse.php'); ?>
<article>

<form>
    <div id="mainbuffer"></div>
    <label>Races: </label>
    <div id="createtags" class="inputrow">
        <button type="button" id="blogtag_create" class="gen_button" onclick="addNewHorseRecord('horse_records','race')">Add Race</button>
        <button type="button" id="blogtag_create" class="gen_button" onclick="addNewHorseRecord('horse_records','skill')">Add Skill</button>
        <button type="button" id="blogtag_create" class="gen_button" onclick="addNewHorseRecord('horse_records','card')">Add Card</button>
    </div>
    <div id="horse_records">

    </div>
    <div class="vertical_buttons floatright">
        <button type="button" class="gen_button floatright" onclick="sendForm('horse_records')">Submit Records</button>
        <a href="./create_horse.php"><button type="button" class="gen_button floatright">Create Horse</button></a>
    </div>
</form>

<div>

</div>
</article>

<?php require_once('../loaders/main_bottom.php'); ?>
</body>
</html>