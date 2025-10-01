<?php $pagetitle = "Veteran Horse"; ?>
<?php require_once('../loaders/header.php'); ?>
<?php require_once('../php_requests/load_horse_records.php');  ?>
<?php
$horse_id = "";
if(isset($_GET['horse_id'])){
    $horse_id = $_GET['horse_id'];
}
$horse = new Horse($_GET);
$result = $horse->loadHorse();
$result = $horse->loadStats();
?>
<body onload='pageObj = new CurrentPage([0], ""); updateCssSize();'>
<script type="text/javascript" src="../javascript_imports/textarea.js"></script>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>

<article>
    
<form method="post" action="../php_requests/create_horse.php" enctype="multipart/form-data">
    <output class="titlesize createblogoutput form_output" name="trainee_enum"> 
        <?php 
        $horse_enum = GetHorseEnum($horse->horse_type);
        echo GetName($horse_enum)[0]; ?>
    </output>
    <div id="mainbuffer"></div>
    <div class="horse_stat_sparks_grid">
        <label>stat spark</label><label>apt spark</label>
        <output class="horse_record_output form_output">
            <?php $stat_names = ["Speed","Stamina","Power","Guts","Wit"];
            $stat_spark = floor($horse->stat_spark / 3);
            $stat_magnitude = $horse->stat_spark % 3;
            echo $stat_names[$stat_spark] . " " . $stat_magnitude; ?>
        </output>
        <output class="horse_record_output form_output">
            <?php $apt_names = ["Turf","Dirt","Sprint","Mile","Medium","Long","Front","Pace","Late","End"]; 
            $apt_spark = floor($horse->apt_spark / 3);
            $apt_magnitude = $horse->apt_spark % 3;
            echo $apt_names[$apt_spark] . " " . $apt_magnitude; ?>
        </output>
    </div>
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

    <button class="gen_button floatright">Create blog post</button>
</form>
<div id="imagepreviews"></div>
<button id="addBlogtagnew" hidden onclick="addNewBlogTag('invisible_blogtags')"></button>
</article>

<?php require_once('../loaders/main_bottom.php'); ?>
</body>
</html>