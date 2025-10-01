<?php
require_once('databaseEntity_class.php');
require_once('account_class.php');  //  trainer_class inside here
require_once('file_class.php');

$h_a = [    // horse attributes
    "horse_id","trainer_id","roster_id","horse_type","stat_spark","apt_spark","icon_id"
];
$h_s_a = [  // horse_stats attributes
    "horse_stats_id","horse_id","rating","fans","epiphet","horse_date","major_wins","career_scenario","speed","stamina","power","guts","wit","turf","dirt","sprint","mile","medium","long","front_runner","pace_chaser","late_surger","end_closer"
];

$r_a = [    // race attributes
    "race_id","race_name","grade","distance","racecourse","track_type","direction"
];
$s_a = [    // skill attributes
    "skill_id","skill_name","skill_type","skill_level"
];          // supprt card attributes
$c_a = [
    "support_card_id", "trainee_enum", "card_name", "stat", "rarity"
];
enum HorseType: int {
    case KingHalo = 1;
    case NiceNature = 2;
    case MatikaneFukukitaru = 3;
    case HaruUrara = 4;
    case SakuraBakushinO = 5;
    case WinningTicket = 6;
    case AgnesTachyon = 7;
    case MejiroRyan = 8;
    case SuperCreek = 9;
    case MayanoTopGun = 10;
    case AirGroove = 11;
    case ElCondorPasa = 12;
    case GrassWonder = 13;
    case DaiwaScarlet = 14;
    case Vodka = 15;
    case GoldShip = 16;
    
    case SpecialWeek = 17;
    case SilenceSuzuka = 18;
    case TokaiTeio = 19;
    case Maruzensky = 20;
    case OguriCap = 21;
    case TaikiShuttle = 22;
    case MejiroMcQueen = 23;
    case SymboliRudolf = 24;
    case RiceShower = 25;

    case TMOperaO = 26;
    case MihonoBourbon = 27;
    case BiwaHayahide = 28;
    case McQueenAnime = 29;
    case TeioAnime = 30;
    case CurrenChan = 31;
    case NaritaTaishin = 32;
    case SmartFalcon = 33;
    case NaritaBrian = 34;
    case MayanoWedding = 35;
    case AirGrooveWedding = 36;
    case SeiunSky = 37;
    case HishiAmazon = 38;
}
function GetHorseEnum($integer){
    $enums_array = HorseType::cases();
    foreach($enums_array as $key => $enum) {
        if($enum->value == $integer){
            return $enum;
        }
    } return false;
}
function GetName($horse_enum) {
    $short_name = false;
    $title = false;

    switch($horse_enum) {
        // King Halo
        case (HorseType::KingHalo):
            $title = "King of Emeralds";
            $short_name = "King Halo"; 
            break;
        // Nice Nature
        case (HorseType::NiceNature):
            $title = "Poinsettia Ribbon";
            $short_name = "Nice Nature";
            break;
        // Matikane Fukukitaru
        case (HorseType::MatikaneFukukitaru):
            $title = "Rising Fortune";
            $short_name = "Matikane Fukukitaru";
            break;
        // Haru Urara
        case (HorseType::HaruUrara):
            $title = "Bestest Prize";
            $short_name = "Haru Urara";
            break;
        // Sakura Bakushin O
        case (HorseType::SakuraBakushinO):
            $title = "Blossom in Learning";
            $short_name = "Sakura Bakushin O";
            break;
        // Winning Ticket
        case (HorseType::WinningTicket):
            $title = "Get to Winning";
            $short_name = "Winning Ticket";
            break;
        // Agnes Tachyon
        case (HorseType::AgnesTachyon):
            $title = "tach-nology";
            $short_name = "Agnes Tachyon";
            break;
        // Mejiro Ryan
        case (HorseType::MejiroRyan):
            $title = "Down the Line";
            $short_name = "Mejiro Ryan";
            break;
        // Super Creek
        case (HorseType::SuperCreek):
            $title = "Murmuring Stream";
            $short_name = "Super Creek";
            break;
        // Mayano Top Gun
        case (HorseType::MayanoTopGun):
            $title = "Scramble Zone";
        case (HorseType::MayanoWedding):
            $title = "Sunlight Bouquet";
            $horse_enum = HorseType::MayanoTopGun;
        case (HorseType::MayanoTopGun):
            $short_name = "Mayano Top Gun";
            break;
        // Air Groove
        case (HorseType::AirGroove):
            $title = "Empress Road";
        case (HorseType::AirGrooveWedding):
            $title = "Quercus Civilis";
            $horse_enum = HorseType::AirGroove;
        case (HorseType::AirGroove):
            $short_name = "Air Groove";
            break;
        // El Condor Pasa
        case (HorseType::ElCondorPasa):
            $title = "El Numero 1";
            $short_name = "El Condor Pasa";
            break;
        // Grass Wonder
        case (HorseType::GrassWonder):
            $title = "Stone-Piercing Blue";
            $short_name = "Grass Wonder";
            break;
        // Daiwa Scarlet
        case (HorseType::DaiwaScarlet):
            $title = "Peak Blue";
            $short_name = "Daiwa Scarlet";
            break;
        // Vodka
        case (HorseType::Vodka):
            $title = "Wild Top Gear";
            $short_name = "Vodka";
            break;
        // Gold Ship
        case (HorseType::GoldShip):
            $title = "Red Strife";
            $short_name = "Gold Ship";
            break;
        // to be continued
    }
    return [$short_name,$title];
    // Any other info you want to display or differentiate for the horses
    // use this switch case to return it?
}
function namesAsJavascript() {
    //$result_text = "{";
    $enums_array = HorseType::cases();
    $names_array = array_column(HorseType::cases(),'value');

    $result_array = [];
    foreach($enums_array as $pos => $enum){
        $result_array[$names_array[$pos]] = GetName($enum)[0];
        //$result_text .= "{$names_array[$pos]} : '{GetName($enum)}',";
    }
    //$result_text .= "}";
    return json_encode($result_array);
}

Class DatabaseUtility {
    // just want to trial adding these
    function unpack($params){
        foreach ($params as $key => $value) {
            if(property_exists($this,$key)) {
                $this->{$key} = $value; } }
        return;
    }
    function loadOffKey($sql_statement, $key){
        $result = false;
        if($key){
            $db = new SQLite3('../data/database.db');

            $stmt = $db->prepare($sql_statement);
            $stmt->bindParam(':primary_key', $key, SQLITE3_INTEGER);
            $result = $stmt->execute();
            if($result){
                $row = $result->fetchArray();
                // Do this with the result: $this->unpack($row);
            }
            $db->close();
            return $row;    //return true
        }
        return $result;
    }
    static function loadAll($sql_statement){
        $db = new SQLite3('../data/database.db');
        $results = $db->query($sql_statement);

        $rows = [];
        while($row = $results->fetchArray()){
            $rows[] = $row;
        }
        return $rows;
    }
}

Class Horse extends DatabaseUtility{
    public $horse_id, $trainer_id, $roster_id, $horse_type, $stat_spark, $apt_spark, $icon_id;
    public $horse_stats_id, $rating, $fans, $epiphet, $horse_date, $major_wins, $career_scenario, 
    $speed, $stamina, $power, $guts, $wit, 
    $turf, $dirt, $sprint, $mile, $medium, $long, $front_runner, $pace_chaser, $late_surger, $end_closer;

    public $skills_owned = [];
    public $races_ran = [];
    public $skill_sparks = [];
    public $race_sparks = [];
    public $cards_used = [];

    function __construct($params){
        $this->unpack($params);
    }

    function loadHorse(){
        $sql = 'SELECT * FROM Horses WHERE horse_id=:horse_id';
        return $this->loadFromHorseId($sql);
    }
    function loadStats(){
        $sql = 'SELECT * FROM HorseStats WHERE horse_id=:horse_id';
        return $this->loadFromHorseId($sql);
    }
    static function loadAllHorses($search_text){    //should really be $parameters. [min,max] for ranges of enum vals
        $horses_array = [];
        if(!$search_text) {
            $sql = 'SELECT * FROM Horses';
            $rows = DatabaseUtility::loadAll($sql);
            foreach($rows as $key => $row){
                $horses_array[] = new Horse($row);
            }
        }
        return $horses_array;
    }
    // load skills, races, support cards
    function loadFromHorseId($sql_statement){
        $result = false;
        if($this->horse_id){
            $db = new SQLite3('../data/database.db');

            $stmt = $db->prepare($sql_statement);
            $stmt->bindParam(':horse_id', $this->horse_id, SQLITE3_INTEGER);
            $result = $stmt->execute();
            if($result){
                $row = $result->fetchArray();
                $this->unpack($row);
            }
            $db->close();
            return true;
        }
        return $result;
    }
    function createHorse(){
        $result = false;
        // 
        $db = new SQLite3('../data/database.db');
        // THIS ROSTER_ID STUFF ISN;T FINISHED FOR THIS CLASS YET
        // make a FileRoster
        $sql = 'INSERT INTO FileRoster DEFAULT VALUES';
        $result = $db->query($sql);
        if($result){
            $this->roster_id = $db->lastInsertRowID();
        }

        
        $sql = 'INSERT INTO Horses(trainer_id,roster_id,horse_type,stat_spark,apt_spark) VALUES(:trainer_id,:roster_id,:horse_type,:stat_spark,:apt_spark)';
        $stmt = $db->prepare($sql);
        
        $h_a = $GLOBALS['h_a'];
        for($i = 1; $i < count($h_a); $i++) {
            // all INTEGERs
            $stmt->bindValue(':' . $h_a[$i],$this->{$h_a[$i]}, SQLITE3_INTEGER);
        }
        $result = $stmt->execute();
        if($result){
            $this->horse_id = $db->lastInsertRowID();
        } $db->close(); return $result;
    }
    function createHorseStats(){
        $result = false;
        //Do i care if they entered valid details
        $db = new SQLite3('../data/database.db');
        $sql = 'INSERT INTO HorseStats(horse_id,rating,fans,epiphet,horse_date,major_wins,career_scenario,speed,stamina,power,guts,wit,turf,dirt,sprint,mile,medium,long,front_runner,pace_chaser,late_surger,end_closer) VALUES(:horse_id,:rating,:fans,:epiphet,date(:horse_date),:major_wins,:career_scenario,:speed,:stamina,:power,:guts,:wit,:turf,:dirt,:sprint,:mile,:medium,:long,:front_runner,:pace_chaser,:late_surger,:end_closer)';
        $stmt = $db->prepare($sql);
        
        $text_vars = ["epiphet","horse_date","major_wins"];
        $h_s_a = $GLOBALS['h_s_a'];

        for($i = 1; $i < count($h_s_a); $i++) {
            if( in_array($h_s_a[$i],$text_vars) ){
                $stmt->bindValue(':' . $h_s_a[$i],$this->{$h_s_a[$i]}, SQLITE3_TEXT);
            } else{
                $stmt->bindValue(':' . $h_s_a[$i],$this->{$h_s_a[$i]}, SQLITE3_INTEGER); }
        }
        $result = $stmt->execute();
        if($result){
            $this->horse_stats_id = $db->lastInsertRowID();
        } $db->close(); return $result;
    }
}

Class Race extends DatabaseUtility{
    public $race_id, $race_name, $grade, $distance, $racecourse, $track_type, $direction;
    function __construct($params){
        $this->unpack($params);
    }

    function loadRace(){
        $sql = 'SELECT * FROM RacesTable WHERE race_id=:primary_key';
        $row = $this->loadOffKey($sql,$this->race_id); //$this->loadFromHorseId($sql);
        if($row){ $this->unpack($row); return true; }
        else{ return false; }
    }
    static function loadAllRaces($search_text){
        $races_array = [];
        if(!$search_text) {
            $sql = 'SELECT * FROM RacesTable';
            $rows = DatabaseUtility::loadAll($sql);
            
            foreach($rows as $key => $row){
                $new_race = new Race($row);
                if($new_race->race_id){
                    $races_array[] = $new_race; }
            }
        } else {    // using search_text on the race's name
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM RacesTable WHERE instr(lower(race_name), lower(:race_name))';
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':race_name', $search_text, SQLITE3_TEXT);
            $results = $stmt->execute();

            while($row = $results->fetchArray()){
                $races_array[] = new Race($row);
            } $db->close();
        }
        return $races_array;
    }
    function createRace(){
        $result = false;
        //
        $db = new SQLite3('../data/database.db');
        $sql = 'INSERT INTO RacesTable(race_name,grade,distance,racecourse,track_type,direction) VALUES(:race_name,:grade,:distance,:racecourse,:track_type,:direction)';
        $stmt = $db->prepare($sql);

        $r_a = $GLOBALS['r_a'];
        for($i = 1; $i < count($r_a); $i++) {
            if($r_a[$i] == "race_name"){
                $stmt->bindValue(':' . $r_a[$i],$this->{$r_a[$i]}, SQLITE3_TEXT);
            } else {
                $stmt->bindValue(':' . $r_a[$i],$this->{$r_a[$i]}, SQLITE3_INTEGER); }
        }
        $result = $stmt->execute();
        if($result){
            $this->race_id = $db->lastInsertRowID();
        } $db->close(); return $result;
    }
}

Class Skill extends DatabaseUtility{
    public $skill_id, $skill_name, $skill_type, $skill_level;
    function __construct($params){
        $this->unpack($params);
    }

    function loadSkill(){
        $sql = 'SELECT * FROM SkillsTable WHERE skill_id=:primary_key';
        $row = $this->loadOffKey($sql,$this->skill_id); //$this->loadFromHorseId($sql);
        if($row){ $this->unpack($row); return true; }
        else{ return false; }
    }
    static function loadAllSkills(){
        $sql = 'SELECT * FROM SkillsTable';
        $rows = DatabaseUtility::loadAll($sql);

        $skills_array = [];
        foreach($rows as $key => $row){
            $new_skill = new Skill($row);
            if($new_skill->skill_id){
                $skills_array[] = $new_skill; }
        }
        return $skills_array;
    }
    function createSkill(){
        $result = false;
        //
        $db = new SQLite3('../data/database.db');
        $sql = 'INSERT INTO SkillsTable(skill_name,skill_type,skill_level) VALUES(:skill_name,:skill_type,:skill_level)';
        $stmt = $db->prepare($sql);
        $s_a = $GLOBALS['s_a'];
        
        for($i = 1; $i < count($s_a); $i+=1) {
            $param_name = ':' . $s_a[$i];
            $param_value = $this->{$s_a[$i]};
            if($s_a[$i] == "skill_name"){
                $stmt->bindValue($param_name,$param_value, SQLITE3_TEXT);
            } else {
                $stmt->bindValue($param_name,$param_value, SQLITE3_INTEGER); }
        }
        $result = $stmt->execute();
        if($result){
            $this->skill_id = $db->lastInsertRowID();
        } $db->close(); return $result;
    }
}

Class SupportCard extends DatabaseUtility{
    public $support_card_id, $trainee_enum, $card_name, $stat, $rarity;
    function __construct($params){
        $this->unpack($params);
    }

    function loadCard(){
        $sql = 'SELECT * FROM SupportCardsTable WHERE support_card_id=:primary_key';
        $row = $this->loadOffKey($sql,$this->support_card_id);
        if($row){ $this->unpack($row); return true; }
        else{ return false; }
    }
    static function loadAllCards(){
        $sql = 'SELECT * FROM SupportCardsTable';
        $rows = DatabaseUtility::loadAll($sql);

        $cards_array = [];
        foreach($rows as $key => $row){
            $new_card = new SupportCard($row);
            if($new_card->support_card_id){
                $cards_array[] = $new_card; }
        }
        return $cards_array;
    }
    function createCard(){
        $result = false;
        //
        $db = new SQLite3('../data/database.db');
        $sql = 'INSERT INTO SupportCardsTable(trainee_enum, card_name, stat, rarity) VALUES(:trainee_enum, :card_name, :stat, :rarity)';
        $stmt = $db->prepare($sql);
        $c_a = $GLOBALS['c_a'];
        
        for($i = 1; $i < count($c_a); $i+=1) {
            $param_name = ':' . $c_a[$i];
            $param_value = $this->{$c_a[$i]};
            if($c_a[$i] == "card_name"){
                $stmt->bindValue($param_name,$param_value, SQLITE3_TEXT);
            } else {
                $stmt->bindValue($param_name,$param_value, SQLITE3_INTEGER); }
        }
        $result = $stmt->execute();
        if($result){
            $this->card_id = $db->lastInsertRowID();
        } $db->close(); return $result;
    }
    function displayName(){
        $enum = HorseType::from($this->trainee_enum);
        return GetName($enum)[0];
    }
}




?>