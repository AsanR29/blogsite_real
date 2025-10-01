<?php $pagetitle = "New Horse"; ?>
<?php require_once('../loaders/header.php'); ?>
<?php require_once('../php_requests/load_horse_records.php');  ?>
<body onload='pageObj = new CurrentPage([0], ""); updateCssSize();'>
<script type="text/javascript" src="../javascript_imports/textarea.js"></script>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>

<article>
    
<form method="post" action="../php_requests/create_horse.php" enctype="multipart/form-data">
    <select required type="text" class="titlesize createbloginput form_input" name="trainee_enum">
        <?php
            $enums_array = HorseType::cases();
            $names_array = array_column(HorseType::cases(),'value');

            foreach($enums_array as $pos => $enum): ?>
                <option value="<?php echo $names_array[$pos]; ?>"><?php echo GetName($enum)[0]; ?></option>
            <?php endforeach; ?>
    </select>
    <div id="mainbuffer"></div>
    <div class="horse_stat_sparks_grid">
        <label>stat spark</label><label>apt spark</label>
        <select name="stat_spark" class="horse_create_input form_input">
            <?php $stat_names = ["Speed","Stamina","Power","Guts","Wit"];
            for($i = 0; $i < 5; $i++):
                for($j = 0; $j < 3; $j++): ?>
                    <option value="<?php echo (($i*3)+$j); ?>"> <?php echo $stat_names[$i] . " " . ($j+1); ?> </option>
            <?php endfor; endfor; ?>
        </select>
        <select name="apt_spark" class="horse_create_input form_input">
            <?php $apt_names = ["Turf","Dirt","Sprint","Mile","Medium","Long","Front","Pace","Late","End"]; 
            for($i = 0; $i < 10; $i++):
                for($j = 0; $j < 3; $j++): ?>
                    <option value="<?php echo (($i*3)+$j); ?>"> <?php echo $apt_names[$i] . " " . ($j+1); ?> </option>
            <?php endfor; endfor; ?>
        </select>
    </div>
    <div class="horse_career_stats_grid">
        <label>rating</label><label>fans</label><label>epiphet</label><label>date</label><label>major wins</label><label>career scenario</label>
        <input name="rating" type="number" class="horse_create_input form_input" placeholder="7000"></input>
        <input name="fans" type="number" class="horse_create_input form_input" placeholder="61000"></input>
        <input name="epiphet" type="text" class="horse_create_input form_input" placeholder="URA Champion"></input>
        <input name="horse_date" type="date" class="horse_create_input form_input" required></input>
        <input name="major_wins" type="text" class="horse_create_input form_input" placeholder="major wins"></input>
        <select name="career_scenario" class="horse_create_input form_input">
            <option selected value="0">The Beginning: URA Finale</option>
        </select>
    </div>
    <div class="horse_stat_stats_grid">
        <input name="speed" type="number" class="horse_create_input form_input" placeholder="speed"></input>
        <input name="stamina" type="number" class="horse_create_input form_input" placeholder="stamina"></input>
        <input name="power" type="number" class="horse_create_input form_input" placeholder="power"></input>
        <input name="guts" type="number" class="horse_create_input form_input" placeholder="guts"></input>
        <input name="wit" type="number" class="horse_create_input form_input" placeholder="wit"></input>
    </div>
    <div class="horse_aptitude_stats_grid">
        <label>turf</label><label>dirt</label><label>sprint</label><label>mile</label><label>medium</label><label>long</label><label>front</label><label>pace</label><label>late</label><label>end</label>
        <input name="turf" data-horse_record="turf" data-limit="1" type="text" maxlength="1"></input>
        <input name="dirt" data-horse_record="dirt" data-limit="2" type="text" maxlength="1"></input>
        <input name="sprint" data-horse_record="sprint" data-limit="3" type="text" maxlength="1"></input>
        <input name="mile" data-horse_record="mile" data-limit="4" type="text" maxlength="1"></input>
        <input name="medium" data-horse_record="medium" data-limit="5" type="text" maxlength="1"></input>
        <input name="long" data-horse_record="long" data-limit="6" type="text" maxlength="1"></input>
        <input name="front" data-horse_record="front" data-limit="7" type="text" maxlength="1"></input>
        <input name="pace" data-horse_record="pace" data-limit="8" type="text" maxlength="1"></input>
        <input name="late" data-horse_record="late" data-limit="9" type="text" maxlength="1"></input>
        <input name="end" data-horse_record="end" data-limit="10" type="text" maxlength="1"></input>
<script>
    let valid_letters = ['s','a','b','c','d','e','f','g'];
    let input_nodes = document.querySelectorAll("[data-limit]");
    for(let key of input_nodes.keys()) {
        let node_atp = input_nodes.item(key);
        node_atp.addEventListener("keydown", function(e){
            if(valid_letters.includes(e.key))
                { node_atp.value = e.key; }
        });
        node_atp.addEventListener("keyup", (e)=>{
            if(node_atp.value.length == node_atp.maxLength){
                if(!(valid_letters.includes(e.key) || valid_letters.includes(node_atp.value)))
                    { node_atp.value = ""; }
                else{
                    let data_index = Number(node_atp.dataset.limit);
                    if(data_index == 10)
                        { data_index = 1; } else{ data_index += 1; }
                    let next_node = document.querySelector(`[data-limit="${data_index}"]`);
                    if(next_node)
                        { next_node.focus(); }
                }
            }
        });
    }


</script>
    </div>


    <div id="shadowArea"></div>
    <textarea oninput="measureTextarea()" class="editing form_input" id="testsubject" rows="1" name="contents"></textarea>
    <div id="bloglinks"></div>
    <input hidden type="file" id="imageSubmission" name="imageSubmission[]" accept="image/jpeg, application/pdf" multiple class="form_input"><br>           
    <label class="gen_button" for="imageSubmission">Add images</label>
    <label>Blog tags: </label>
    <div id="createtags" class="inputrow">
        <span id="tag_source_new" class="editing" contenteditable="true"></span>
        <label id="blogtag_create" class="gen_button" for="addBlogtagnew">Add Tag</label>
    </div>
    <div id="invisible_blogtags">

    </div>
    <select name="visibility" class="form_input" required>
        <option value="0">Private</option>
        <option value="1">Unlisted</option>
        <option selected value="2">Public</option>
    </select>
    <!--<button type="button" onclick="Reception.generic()" class="gen_button floatright">See output</button>-->
    <button class="gen_button floatright">Create Horse</button>
</form>
<div id="imagepreviews"></div>
<button id="addBlogtagnew" hidden onclick="addNewBlogTag('invisible_blogtags')"></button>
</article>

<?php require_once('../loaders/main_bottom.php'); ?>
</body>
</html>