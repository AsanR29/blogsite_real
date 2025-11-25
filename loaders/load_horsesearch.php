<div id="mainbuffer"></div>
<?php
session_start();
$trainer_id = false;
if(isset($_SESSION['trainer_id']) && $_SESSION['trainer_id']){
    $trainer_id = $_SESSION['trainer_id'];
}
require_once('../php_classes/horse_classes.php');
$form = json_decode(file_get_contents('php://input'), true);
$params = array();

//
//$skill_records = Skill::loadAllSkills();
//
//

if(isset($form['horse_search'])){
    switch($form['search_type']) {
        case 'race':
            $race_records = Race::loadAllRaces($form['horse_search']);
            //echo json_encode(["request_outcome"=>false,$race_records]);
            for($i = 0; $i < count($race_records); $i++): ?>
                <section class="blogpr blogpreview">
                    <div class="blogp">
                        <div class="blogpL1 blogpr"></div>
                        <div class="blogpM1" style="display:flex; padding-top:8px;">
                            <div class="blogt">
                                <span class="b_text"><?php echo $race_records[$i]->race_name; ?></span>
                                <span class="b_text"><?php echo $race_records[$i]->grade; ?></span>
                                <span class="b_text"><?php echo $race_records[$i]->distance; ?></span>
                                <span class="b_text"><?php echo $race_records[$i]->racecourse; ?></span>
                                <span class="b_text"><?php echo $race_records[$i]->track_type; ?></span>
                                <span class="b_text"><?php echo $race_records[$i]->direction; ?></span>

                            </div>
                        </div>
                        <div class="blogpR1 blogpr"></div>
                    </div>
                    <div class="blogfoot blogpr"></div>
                </section>
                <div id="mainbuffer"></div>
            <?php endfor; ?>
            <?php if(count($race_records) == 0): ?>
                <section>
                    <div><output class="titlesize" style="color:grey">No Races found</h2></div>
                </section>
            <?php endif;
            break;
        case 'skill':
            break;
        case 'card':
            $card_records = SupportCard::loadAllCards($form['horse_search']);
            for($i = 0; $i < count($card_records); $i++): ?>
                <section class="blogpr blogpreview">
                    <div class="blogp">
                        <div class="blogpL1 blogpr"></div>
                        <div class="blogpM1" style="display:flex; padding-top:8px;">
                            <div class="blogt">
                                <span class="b_text"><?php echo $card_records[$i]->card_name; ?></span>
                                <span class="b_text"><?php echo GetName(GetHorseEnum($card_records[$i]->trainee_enum))[0]; ?></span>
                                <span class="b_text"><?php echo $stat_names[$card_records[$i]->stat]; ?></span>
                                <span class="b_text"><?php echo $rarity_names[$card_records[$i]->rarity]; ?></span>
                            </div>
                        </div>
                        <div class="blogpR1 blogpr"></div>
                    </div>
                    <div class="blogfoot blogpr"></div>
                </section>
                <div id="mainbuffer"></div>
            <?php endfor; ?>
            <?php if(count($card_records) == 0): ?>
                <section>
                    <div><output class="titlesize" style="color:grey">No Support Cards found</h2></div>
                </section>
            <?php endif;
            break;
        case 'trainee':
            ?> <section class="squares_menu"> <?php 
            $horse_records = Horse::loadAllHorses($form['horse_search']);
            for($i = 0; $i < count($horse_records); $i++): ?>
                <?php require("veteran_box.php"); ?>
            <?php endfor; ?>
            <?php if(count($horse_records) == 0): ?>
                <section>
                    <div><output class="titlesize" style="color:grey">No Horses found</h2></div>
                </section>
            <?php endif;
            break;
    }
}
