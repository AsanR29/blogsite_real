<?php $pagetitle = "New Horse"; ?>
<?php require_once('../loaders/header.php'); ?>
<?php require_once('../php_requests/load_horse_records.php');  ?>
<body onload='pageObj = new CurrentPage([0], ""); updateCssSize();'>
<script type="text/javascript" src="../javascript_imports/textarea.js"></script>

<?php require_once('../loaders/horse_top.php'); ?>

<article>
    
<form method="post" action="../php_requests/create_horse.php" enctype="multipart/form-data">
    <input required type="text" class="titlesize createbloginput form_input" name="trainee_enum" list="trainee_options"></input>
    <datalist id="trainee_options">
        <?php
            $enums_array = HorseType::cases();
            $names_array = array_column(HorseType::cases(),'value');

            foreach($enums_array as $pos => $enum): ?>
                <option value="<?php echo $names_array[$pos]; ?>"><?php echo GetName($enum)[0]; ?></option>
            <?php endforeach; ?>
    </datalist>
    <div id="mainbuffer"></div>
    <div class="horse_stat_sparks_grid">
        <label>stat spark</label><label>apt spark</label>
        <select name="stat_spark" class="horse_create_input form_input">
            <?php $stat_names = ["Speed","Stamina","Power","Guts","Wit","Friend"];
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
    <input hidden name="is_guest" type="number" value=1 class="form_input"></input>


    <button class="gen_button floatright">Create Guest</button>
</form>
<div id="imagepreviews"></div>
<button id="addBlogtagnew" hidden onclick="addNewBlogTag('invisible_blogtags')"></button>
</article>

<?php require_once('../loaders/main_bottom.php'); ?>
</body>
</html>