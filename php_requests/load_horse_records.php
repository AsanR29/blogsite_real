<?php
require_once('../php_classes/horse_classes.php');

require_once('../php_classes/account_class.php');


$race_records = Race::loadAllRaces(false);

$skill_records = Skill::loadAllSkills();

$card_records = SupportCard::loadAllCards();


?>