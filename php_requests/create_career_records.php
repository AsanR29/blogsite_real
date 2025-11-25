<?php
require_once('../php_classes/horse_classes.php');

require_once('../php_classes/account_class.php');
session_start();
$form = json_decode(file_get_contents('php://input'), true);

if( !(isset($_SESSION["trainer_id"]) && isset($form["horse_id"])) ){ echo json_encode(['request_outcome'=>false]); return; }
// else
$horse = new Horse(["horse_id" => $form["horse_id"]]);
$result = $horse->loadHorse();
if(!$result) { echo json_encode(['request_outcome'=>false]); return; }
// else, We're probably good!

foreach($form as $key=>$value){
    if(!is_array($form[$key])){
        $form[$key] = [$value];
    }
}

$results_array = [];
$result;

$error_holder = ["form_Details"=>$form];    // remove this
try{
    if( isset($form["skill_owned[]"]) ) {
        $length = count($form["skill_owned[]"]);
        for($i = 0; $i < $length; $i++) {
            $params = [
                "skill_id" => $form["skill_owned[]"][$i],
                "horse_id" => $horse->horse_id
            ];

            $new_skill = new SkillOwned($params);
            $result = $new_skill->createSkillOwned();
            $results_array[] = $result;
        }
    }
    if( isset($form["race_spark[]"]) ) {
        $length = count($form["race_spark[]"]);
        for($i = 0; $i < $length; $i++) {
            $params = [
                "race_id" => $form["race_spark[]"][$i],
                "horse_id" => $horse->horse_id,
                "stars" => $form["race_stars[]"][$i]
            ];

            $new_spark = new RaceSpark($params);
            $result = $new_spark->createRaceSpark();
            $results_array[] = $result;
        }
    }
    if( isset($form["skill_spark[]"]) ) {
        $length = count($form["skill_spark[]"]);
        for($i = 0; $i < $length; $i++) {
            $params = [
                "skill_id" => $form["skill_spark[]"][$i],
                "horse_id" => $horse->horse_id,
                "stars" => $form["skill_stars[]"][$i]
            ];

            $new_spark = new SkillSpark($params);
            $result = $new_spark->createSkillSpark();
            $results_array[] = $result;
        }
    }
    if( isset($form["card_used[]"]) ) {
        $length = count($form["card_used[]"]);
        for($i = 0; $i < $length; $i++) {
            $params = [
                "support_card_id" => $form["card_used[]"][$i],
                "horse_id" => $horse->horse_id,
                "card_level" => $form["card_level[]"][$i]
            ];

            $new_card = new CardUsed($params);
            $result = $new_card->createCardUsed();
            $results_array[] = $result;
        }
    }
    if( isset($form["race_ran[]"]) ) {
        $length = count($form["race_ran[]"]);
        for($i = 0; $i < $length; $i++) {
            $params = [
                "race_id" => $form["race_ran[]"][$i],
                "horse_id" => $horse->horse_id,
                "weather" => $form["weather[]"][$i],
                "track_conditions" => $form["track_conditions[]"][$i],
                "strategy" => $form["strategy[]"][$i],
                "placement" => $form["placement[]"][$i]
            ];

            $new_race = new RaceRan($params);
            $result = $new_race->createRaceRan();
            $results_array[] = $result;
        }
    }
} catch(Exception $e) {
    $error_holder["results_array"] = $results_array;
    $error_holder["exception"] = $e;
    echo json_encode(['request_outcome'=>false, 'class'=>$error_holder]);
}
echo json_encode(['request_outcome'=>true, 'class'=>$error_holder]);

?>