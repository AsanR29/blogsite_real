<?php
require_once('../php_classes/horse_classes.php');

require_once('../php_classes/account_class.php');
session_start();
$form = json_decode(file_get_contents('php://input'), true);

//$account_id = $_SESSION['accoount_id'];


$horse_records = [];
foreach($form as $key=>$value){
    if(!is_array($form[$key])){
        $form[$key] = [$value];
    }
}

$results_array = [];
$result;


$error_holder = ["hello"=>"world"];
try{
    if($form && isset($form["race_name[]"])) {
        // make race records
        $length = count($form["race_name[]"]);
        //$error_holder["race_length"] = $length;
        for($i = 0; $i < $length; $i++) {
            $params = [
                "race_name" => $form["race_name[]"][$i],
                "grade" => $form["race_grade[]"][$i],
                "distance" =>$form["race_distance[]"][$i],
                "racecourse" =>$form["racecourse[]"][$i],
                "track_type" =>$form["race_track_type[]"][$i],
                "direction" =>$form["race_direction[]"][$i]
            ];
            $new_race = new Race($params);
            $result = $new_race->createRace();
            $results_array[$new_race->race_name] = $result;
            //$error_holder["race_result"] = $result;
        }
    }
    if($form && isset($form["skill_name[]"])) {
        // make skill records
        //$error_holder["skill_error_source"] = $form;
        $length = count($form["skill_name[]"]);

        //$error_holder["skill_length"] = $length;
        
        for($i = 0; $i < $length; $i++) {
            $params = [
                "skill_name" => $form["skill_name[]"][$i],
                "skill_type" => (int)$form["skill_type[]"][$i],
                "skill_level" => (int)$form["skill_level[]"][$i]
            ];
            //$error_holder["skill_params"] = $params;
            
            $new_skill = new Skill($params);
            //$error_holder["skill_instance"] = $new_skill;
            $result = $new_skill->createSkill();
            $results_array[$new_skill->skill_name] = $result;
            //$error_holder["skill_result"] = $result;
        }
    }
    if($form && isset($form["card_name[]"])) {
        $length = count($form["card_name[]"]);
        for($i = 0; $i < $length; $i++) {
            $params = [
                "card_name" => $form["card_name[]"][$i],
                "trainee_enum" => $form["trainee_enum[]"][$i],
                "stat" => $form["stat[]"][$i],
                "rarity" => $form["rarity[]"][$i]
            ];

            $new_card = new SupportCard($params);
            $result = $new_card->createCard();
            $results_array[$new_skill->skill_name] = $result;
        }
    }
    echo json_encode(['request_outcome'=>false, 'class'=>$error_holder]);
}
catch(Exception $e){ echo json_encode(['request_outcome'=>false, 'class'=>$error_holder]);}



?>