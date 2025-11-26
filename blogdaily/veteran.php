<?php require_once('../loaders/header.php'); ?>
<?php require_once('../php_requests/load_horse_records.php');  ?>
<?php
$horse_id = "";
if(isset($_GET['horse_id'])){
    $horse_id = $_GET['horse_id'];
}
$horse = new Horse($_GET);
$result = $horse->loadHorse();

$IS_GUEST = false;
$result = $horse->loadStats();

if(!$result){
    $IS_GUEST = true;
}
?>
<body onload='pageObj = new CurrentPage([0], "../php_requests/create_career_records.php"); updateCssSize();'>
<script type="text/javascript" src="../javascript_imports/textarea.js"></script>

<?php 
$horse_enum = GetHorseEnum($horse->horse_type);
$pagetitle = GetName($horse_enum)[0]; ?>
<?php require_once('../loaders/horse_top.php'); ?>

<article>
    
<form method="post" action="../php_requests/create_horse.php" enctype="multipart/form-data">    <!-- Change to update_horse.php ?-->
    <div class="horse_stat_sparks_grid">
        <label>stat spark</label><label>apt spark</label>
        <output class="horse_record_output form_output">
            <?php 
            echo OutputSpark(1,$horse->stat_spark);
            ?>
        </output>
        <output class="horse_record_output form_output">
            <?php 
            echo OutputSpark(2, $horse->apt_spark); 
            ?>
        </output>
    </div>
    <?php if(!$IS_GUEST): ?>
    <div class="horse_career_stats_grid">
        <label>rating</label><label>fans</label><label>epiphet</label><label>date</label><label>major wins</label><label>career scenario</label>
        <output name="rating" type="number" class="horse_record_output form_output"><?php echo $horse->rating; ?></output>
        <output name="fans" type="number" class="horse_record_output form_output"><?php echo $horse->fans; ?></output>
        <output name="epiphet" type="text" class="horse_record_output form_output"><?php echo $horse->epiphet; ?></output>
        <output name="horse_date" type="date" class="horse_record_output form_output"><?php echo $horse->horse_date; ?></output>
        <output name="major_wins" type="text" class="horse_record_output form_output"><?php echo $horse->major_wins; ?></output>
        <output name="career_scenario" class="horse_record_output form_output">
            <?php $scenarios = ["The Beginning: URA Finale"];
            echo $scenarios[$horse->career_scenario]; ?>
        </output>
    </div>
    <div class="horse_stat_stats_grid">
        <label>Speed</label><label>Stamina</label><label>Power</label><label>Guts</label><label>Wit</label>
        <output name="speed" type="number" class="horse_record_output form_output"><?php echo $horse->speed; ?></output>
        <output name="stamina" type="number" class="horse_record_output form_output"><?php echo $horse->stamina; ?></output>
        <output name="power" type="number" class="horse_record_output form_output"><?php echo $horse->power; ?></output>
        <output name="guts" type="number" class="horse_record_output form_output"><?php echo $horse->guts; ?></output>
        <output name="wit" type="number" class="horse_record_output form_output"><?php echo $horse->wit; ?></output>
    </div>
    <div class="horse_aptitude_stats_grid">
        <label>turf</label><label>dirt</label><label>sprint</label><label>mile</label><label>medium</label><label>long</label><label>front</label><label>pace</label><label>late</label><label>end</label>
        <?php $letter_grades = ['G','F','E','D','C','B','A','S']; ?>
        <output name="turf" data-horse_record="turf" data-limit="1" type="text" maxlength="1"><?php echo $letter_grades[$horse->turf]; ?></output>
        <output name="dirt" data-horse_record="dirt" data-limit="2" type="text" maxlength="1"><?php echo $letter_grades[$horse->dirt]; ?></output>
        <output name="sprint" data-horse_record="sprint" data-limit="3" type="text" maxlength="1"><?php echo $letter_grades[$horse->sprint]; ?></output>
        <output name="mile" data-horse_record="mile" data-limit="4" type="text" maxlength="1"><?php echo $letter_grades[$horse->mile]; ?></output>
        <output name="medium" data-horse_record="medium" data-limit="5" type="text" maxlength="1"><?php echo $letter_grades[$horse->medium]; ?></output>
        <output name="long" data-horse_record="long" data-limit="6" type="text" maxlength="1"><?php echo $letter_grades[$horse->long]; ?></output>
        <output name="front" data-horse_record="front" data-limit="7" type="text" maxlength="1"><?php echo $letter_grades[$horse->front_runner]; ?></output>
        <output name="pace" data-horse_record="pace" data-limit="8" type="text" maxlength="1"><?php echo $letter_grades[$horse->pace_chaser]; ?></output>
        <output name="late" data-horse_record="late" data-limit="9" type="text" maxlength="1"><?php echo $letter_grades[$horse->late_surger]; ?></output>
        <output name="end" data-horse_record="end" data-limit="10" type="text" maxlength="1"><?php echo $letter_grades[$horse->end_closer]; ?></output>

    </div>
    <?php endif; ?>
    <button class="gen_button floatright">Update Details</button>
</form>

<form>
    <div id="mainbuffer-2">
        <!-- invisible. used by datarecords -->
        <?php require_once("../loaders/veteran_details/datalists.php"); ?>
        <!-- end of datalists -->
    </div>


    <script> tab_ids = ["tab_1","tab_2","tab_3","tab_4"]; </script>
    <?php 
        $tab_ids = ["tab_1","tab_2","tab_3","tab_4"];
        $tab_names = ["Skills", "Sparks", "Support Cards", "Races Ran"];
        require_once("../loaders/veteran_tabs.php"); 
        
    ?>
    <div id="horse_records">
        <input hidden class="form_input" name="horse_id" value="<?php echo $horse->horse_id; ?>"></input>
        <div id="tab_1" style="border-style: solid; border-width: 2px; border-color: blue;">
            <button type="button" id="blogtag_create" class="gen_button" onclick="addNewHorseRecord('horse_skill_records','skillowned')">Add Skill</button>
            <div id="horse_skill_records">

            </div>
            <?php require_once("../loaders/veteran_details/skills.php"); ?>
        </div>
        <div id="tab_2" style="border-style: solid; border-width: 2px; border-color: red; display: none;">
            <div id="createtags" class="inputrow">
                <button type="button" id="blogtag_create" class="gen_button" onclick="addNewHorseRecord('horse_spark_records','racespark')">Add Race Spark</button>
                <button type="button" id="blogtag_create" class="gen_button" onclick="addNewHorseRecord('horse_spark_records','skillspark')">Add Skill Spark</button>
            </div>
            <div id="horse_spark_records">

            </div>
            <?php require_once("../loaders/veteran_details/sparks.php"); ?>
        </div>
        <div id="tab_3" style="border-style: solid; border-width: 2px; border-color: green; display: none;">
            <button type="button" id="blogtag_create" class="gen_button" onclick="addNewHorseRecord('horse_card_records','cardused')">Add Support Card</button>
            <div id="horse_card_records">

            </div>
            <?php require_once("../loaders/veteran_details/cards.php"); ?>
        </div>
        <div id="tab_4" style="border-style: solid; border-width: 2px; border-color: orange; display: none;">
            <button type="button" id="blogtag_create" class="gen_button" onclick="addNewHorseRecord('horse_race_records','raceran')">Add Career Race</button>
            <div id="horse_race_records">

            </div>
            <?php require_once("../loaders/veteran_details/races.php"); ?>
        </div>

        <div id="mainbuffer"></div>
        <div>
            <?php require_once("../loaders/veteran_details/parents.php"); ?>
        </div>

        <div class="vertical_buttons floatright">
            <button type="button" class="gen_button floatright" onclick="sendForm('horse_records')">Submit Records</button>
        </div>
    </div>
</form>
</article>

<?php require_once('../loaders/parent_right.php'); ?>

</body>
</html>
