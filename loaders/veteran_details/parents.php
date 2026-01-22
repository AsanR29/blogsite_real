<div style="width:100%; display:grid; grid-template-columns: 1fr 1fr;">
<?php
$used_temp = false;
if(isset($horse_records)) {
    $t = $horse_records;
    $used_temp = true;
}

$horse_records = $horse->loadInspirations();
for($i = 0; $i < count($horse_records); $i++): ?>
    <div class="parent_record_grid">
        <div style="width:fit-content; margin: 0 auto;">
            <?php require("../loaders/veteran_box.php"); ?>
        </div>
    </div>
<?php endfor; 
# However many parents aren't there, put in input areas 
for($i = 0; $i < 2-count($horse_records); $i++): ?>
    <div class="parent_record_grid">
        <button onlick="unqueueParent(<?php echo $i; ?>)" class="nostylebutton" type="button" style="width:100%">
        <div style="width:fit-content; margin: 0 auto;">
            <div id="parent_top_<?php echo $i; ?>" data-full="N">
                <img data-horseimg src=""></img><br>
                <input hidden data-horseid readonly name="parent_id[]" class="horse_record_input form_input"></input>
                <output data-horsename></output>
                <output data-horserating></output><br>
                <output data-statspark></output>
                <output data-aptspark></output>
            </div>
        </div><br>
        <div>
            <img src=""></img>
            <output id="grandparent_left_<?php echo $i; ?>"></output>
        </div>
        <div>
            <img src=""></img>
            <output id="grandparent_right_<?php echo $i; ?>"></output>
        </div>
        </button>
    </div>
<?php endfor; 
if($used_temp) {
    $horse_records = $t;
}
?>
</div>