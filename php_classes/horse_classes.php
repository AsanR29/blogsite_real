<?php
require_once('databaseEntity_class.php');
require_once('account_class.php');  //  trainer_class inside here
require_once('file_class.php');

$h_a = [    // horse attributes
    "horse_id","trainer_id","roster_id","horse_type","stat_spark","apt_spark","icon_id","is_guest"
];
$h_s_a = [  // horse_stats attributes
    "horse_stats_id","horse_id","rating","fans","epiphet","horse_date","major_wins","career_scenario","speed","stamina","power","guts","wit","turf","dirt","sprint","mile","medium","long","front_runner","pace_chaser","late_surger","end_closer"
];

$r_a = [    // race attributes
    "race_id","race_name","grade","distance","racecourse","track_type","direction"
];
$s_a = [    // skill attributes
    "skill_id","skill_name","skill_type","skill_level"
];          
$c_a = [    // supprt card attributes
    "support_card_id", "trainee_enum", "card_name", "stat", "rarity"
];

$r_r_a = [  // race ran attributes
    "race_ran_id", "race_id", "horse_id", "weather", "track_conditions", "strategy", "placement"
];
$s_o_a = [  // skill owned
    "skill_owned_id", "skill_id", "horse_id"
];
$c_u_a = [  // card used
    "card_used_id", "support_card_id", "horse_id", "card_level"
];

$s_s_a = [  // skill spark 
    "skill_spark_id", "skill_id", "horse_id", "stars"
];
$r_s_a = [  // race spark
    "race_spark_id", "race_id", "horse_id", "stars"
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
    case GrassCleric = 39;
    case ElWarrior = 40;
    case FujiKiseki = 41;
    case GoldCity = 42;

    // because of the cards
    case AgnesDigital = 43;
    case TamamoCross = 44;
    case FineMotion = 45;
    case ManhattanCafe = 46;
    case YukinoBijin = 47;
    case InesFujin = 48;
    case AirShakur = 49;
    case EishinFlash = 50;
    case SweepTosho = 51;
    case ZennoRobRoy = 52;
    case NishinoFlower = 53;
    case MarvelousSunday = 54;
    case MeishiDoto = 55;
    case MejiroDober = 56;
    case Matikanetannhauser = 57;
    case IkunoDictus = 58;
    case MejiroPalmer = 59;
    case DaitakuHelios = 60;
    case TwinTurbo = 61;
    case SatonoDiamond = 62;
    case KitasanBlack = 63;
    case YaenoMuteki = 64;
    case TazunaHayakawa = 65;   //not a horse...
    case AoiKiryuin = 66;       //
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
    $title = "";
    $icon_dir = "";

    switch($horse_enum) {
        // King Halo
        case (HorseType::KingHalo):
            $title = "King of Emeralds";
            $short_name = "King Halo"; 
            $icon_dir = "../css/horse/king halo.png";
            break;
        // Nice Nature
        case (HorseType::NiceNature):
            $title = "Poinsettia Ribbon";
            $short_name = "Nice Nature";
            $icon_dir = "../css/horse/nice nature.png";
            break;
        // Matikane Fukukitaru
        case (HorseType::MatikaneFukukitaru):
            $title = "Rising Fortune";
            $short_name = "Matikane Fukukitaru";
            $icon_dir = "";
            break;
        // Haru Urara
        case (HorseType::HaruUrara):
            $title = "Bestest Prize";
            $short_name = "Haru Urara";
            $icon_dir = "../css/horse/haru urara.png";
            break;
        // Sakura Bakushin O
        case (HorseType::SakuraBakushinO):
            $title = "Blossom in Learning";
            $short_name = "Sakura Bakushin O";
            $icon_dir = "../css/horse/sakura bakushin o.png";
            break;
        // Winning Ticket
        case (HorseType::WinningTicket):
            $title = "Get to Winning";
            $short_name = "Winning Ticket";
            $icon_dir = "../css/horse/winning ticket.png";
            break;
        // Agnes Tachyon
        case (HorseType::AgnesTachyon):
            $title = "tach-nology";
            $short_name = "Agnes Tachyon";
            $icon_dir = "../css/horse/agnes tachyon.png";
            break;
        // Mejiro Ryan
        case (HorseType::MejiroRyan):
            $title = "Down the Line";
            $short_name = "Mejiro Ryan";
            $icon_dir = "../css/horse/mejiro ryan.png";
            break;
        // Super Creek
        case (HorseType::SuperCreek):
            $title = "Murmuring Stream";
            $short_name = "Super Creek";
            $icon_dir = "../css/horse/super creek.png";
            break;
        // Mayano Top Gun
        case (HorseType::MayanoTopGun):
        case (HorseType::MayanoWedding):
            [$title,$icon_dir] = match($horse_enum) {
                HorseType::MayanoTopGun => ["Scramble Zone","../css/horse/mayano top gun.png"],
                HorseType::MayanoWedding => ["Sunlight Bouquet",""],
            };
            $short_name = "Mayano Top Gun";
            break;
        // Air Groove
        case (HorseType::AirGroove):
        case (HorseType::AirGrooveWedding):
            [$title,$icon_dir] = match($horse_enum) {
                HorseType::AirGroove => ["Empress Road","../css/horse/air groove.png"],
                HorseType::AirGrooveWedding => ["Quercus Civilis",""],
            };
            $short_name = "Air Groove";
            break;
        // El Condor Pasa
        case (HorseType::ElCondorPasa):
        case (HorseType::ElWarrior):
            [$title,$icon_dir] = match($horse_enum) {
                HorseType::ElCondorPasa => ["El Numero 1","../css/horse/el condor pasa.png"],
                HorseType::ElWarrior => ["Kukulkan Warrior","../css/horse/umaquest el condor pasa.png"],
            };
            $short_name = "El Condor Pasa";
            break;
        // Grass Wonder
        case (HorseType::GrassWonder):
        case (HorseType::GrassCleric):
            [$title,$icon_dir] = match($horse_enum) {
                HorseType::GrassWonder => ["Stone-Piercing Blue","../css/horse/grass wonder.png"],
                HorseType::GrassCleric => ["Saintly Jade Cleric",""],
            };
            $short_name = "Grass Wonder";
            break;
        // Daiwa Scarlet
        case (HorseType::DaiwaScarlet):
            $title = "Peak Blue";
            $short_name = "Daiwa Scarlet";
            $icon_dir = "../css/horse/daiwa scarlet.png";
            break;
        // Vodka
        case (HorseType::Vodka):
            $title = "Wild Top Gear";
            $short_name = "Vodka";
            $icon_dir = "../css/horse/vodka.png";
            break;
        // Gold Ship
        case (HorseType::GoldShip):
            $title = "Red Strife";
            $short_name = "Gold Ship";
            $icon_dir = "../css/horse/gold ship.png";
            break;
        case (HorseType::SpecialWeek):
            $title = "Special Dreamer";
            $short_name = "Special Week";
            $icon_dir = "";
            break;
        case (HorseType::SilenceSuzuka):
            $title = "Innocent Silence";
            $short_name = "Silence Suzuka";
            $icon_dir = "../css/horse/silence suzuka.png";
            break;
        // Tokai Teio
        case (HorseType::TokaiTeio):
        case (HorseType::TeioAnime):
            [$title, $icon_dir] = match($horse_enum) {
                HorseType::TokaiTeio => ["Peak Joy","../css/horse/tokai teio.png"],
                HorseType::TeioAnime => ["Beyond the Horizon",""],
            };
            $short_name = "Tokai Teio";
            break;
        // Maruzensky
        case (HorseType::Maruzensky):
            $title = "Formula R";
            $short_name = "Maruzensky";
            $icon_dir = "../css/horse/summer maruzensky.png";
            break;
        case (HorseType::OguriCap):
            $title = "Starlight Beat";
            $short_name = "Oguri Cap";
            $icon_dir = "../css/horse/oguri cap.png";
            break;
        case (HorseType::TaikiShuttle):
            $title = "Wild Frontier";
            $short_name = "Taiki Shuttle";
            $icon_dir = "";
            break;
        // Mejiro McQueen
        case (HorseType::MejiroMcQueen):
        case (HorseType::McQueenAnime):
            $title = match($horse_enum) {
                HorseType::MejiroMcQueen => "Frontline Elegance",
                HorseType::McQueenAnime => "End of the Skies",
            };
            $short_name = "Mejiro McQueen";
            break;
        // Symboli Rudolf
        case (HorseType::SymboliRudolf):
            $title = "Emperor's Path";
            $short_name = "Symboli Rudolf";
            $icon_dir = "";
            break;
        case (HorseType::RiceShower):
            $title = "Rosy Dreams";
            $short_name = "Rice Shower";
            $icon_dir = "";
            break;
        case (HorseType::TMOperaO):
            $title = "O Sole Suo!";
            $short_name = "T.M. Opera O";
            $icon_dir = "";
            break;
        case (HorseType::MihonoBourbon):
            $title = "MB-19890425";
            $short_name = "Mihono Bourbon";
            $icon_dir = "";
            break;
        case (HorseType::BiwaHayahide):
            $title = "pf. Winning Equation...";
            $short_name = "Biwa Hayahide";
            $icon_dir = "";
            break;
        case (HorseType::CurrenChan):
            $title = "Fille Éclair";
            $short_name = "Curren Chan";
            $icon_dir = "";
            break;
        case (HorseType::NaritaTaishin):
            $title = "Nevertheless";
            $short_name = "Narita Taishin";
            $icon_dir = "";
            break;
        case (HorseType::SmartFalcon):
            $title = "LOVE☆4EVER";
            $short_name = "Smart Falcon";
            $icon_dir = "../css/horse/smart falcon.png";
            break;
        case (HorseType::NaritaBrian):
            $title = "Maverick";
            $short_name = "Narita Brian";
            $icon_dir = "";
            break;
        case (HorseType::SeiunSky):
            $title = "Reeling in the Big One";
            $short_name = "Seiun Sky";
            $icon_dir = "../css/horse/seiun sky.png";
            break;
        case (HorseType::HishiAmazon):
            $title = "Azure Amazon";
            $short_name = "Hishi Amazon";
            $icon_dir = "../css/horse/hishi amazon.png";
            break;
        case (HorseType::FujiKiseki):
            $short_name = "Fuji Kiseki";
            $icon_dir = "";
            break;
        case (HorseType::GoldCity):
            $short_name = "Gold City";
            $icon_dir = "";
            break;
        case (HorseType::AgnesDigital):
            $short_name = "Agnes Digital";
            $icon_dir = "";
            break;
        case (HorseType::TamamoCross):
            $short_name = "Tamamo Cross";
            $icon_dir = "";
            break;
        case (HorseType::FineMotion):
            $short_name = "Fine Motion";
            $icon_dir = "";
            break;
        case (HorseType::ManhattanCafe):
            $short_name = "Manhattan Cafe";
            $icon_dir = "";
            break;
        case (HorseType::YukinoBijin):
            $short_name = "Yukino Bijin";
            $icon_dir = "";
            break;
        case (HorseType::InesFujin):
            $short_name = "Ines Fujin";
            $icon_dir = "";
            break;
        case (HorseType::AirShakur):
            $short_name = "Air Shakur";
            $icon_dir = "";
            break;
        case (HorseType::EishinFlash):
            $short_name = "Eishin Flash";
            $icon_dir = "";
            break;
        case (HorseType::SweepTosho):
            $short_name = "Sweep Tosho";
            $icon_dir = "";
            break;
        case (HorseType::ZennoRobRoy):
            $short_name = "Zenno Rob Roy";
            break;
        case (HorseType::NishinoFlower):
            $short_name = "Nishino Flower";
            break;
        case (HorseType::MarvelousSunday):
            $short_name = "Marvelous Sunday";
            break;
        case (HorseType::MeishiDoto):
            $short_name = "Meishi Doto";
            $icon_dir = "../css/horse/meishi doto.png";
            break;
        case (HorseType::MejiroDober):
            $short_name = "Mejiro Dober";
            break;
        case (HorseType::Matikanetannhauser):
            $short_name = "Matikanetannhauser";
            break;
        case (HorseType::IkunoDictus):
            $short_name = "Ikuno Dictus";
            break;
        case (HorseType::MejiroPalmer):
            $short_name = "Mejiro Palmer";
            break;
        case (HorseType::DaitakuHelios):
            $short_name = "Daitaku Helios";
            break;
        case (HorseType::TwinTurbo):
            $short_name = "Twin Turbo";
            break;
        case (HorseType::SatonoDiamond):
            $short_name = "Satono Diamond";
            break;
        case (HorseType::KitasanBlack):
            $short_name = "Kitasan Black";
            break;
        case (HorseType::YaenoMuteki):
            $short_name = "Yaeno Muteki";
            break;
        case (HorseType::TazunaHayakawa):
            $short_name = "Tazuna Hayakawa";
            break;
        case (HorseType::AoiKiryuin):
            $short_name = "Aoi Kiryuin";
            break;
        // to be continued
    }
    return [$short_name,$title, $icon_dir];
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

$racecourse_names = ["Sapporo","Hakodate","Fukushima","Niigata","Tokyo","Nakayama","Chukyo","Kyoto","Hanshin","Kokura","Oi"];
$race_grades = ["DEBUT","MAIDEN","PRE-OP","OP","G3","G2","G1","EX"];
$track_types = ["Turf","Dirt"];
$track_directions = ["Left","Right"];
$weather_names = ["Sunny","Cloudy","Rainy","Snowy"];
$track_conditions = ["Firm","Good","Soft","Heavy"];
$race_strategies = ["Front","Pace","Late","End"];
function FormatPlacement($placement) {
    $result= "";
    switch($placement) {
        case 11: case 12: case 13:
            $result = $placement . "th"; break;
        case ($placement % 10 == 1):
            $result = $placement . "st"; break;
        case ($placement % 10 == 2):
            $result = $placement . "nd"; break;
        case ($placement % 10 == 3):
            $result = $placement . "rd"; break;
        default:
            $result = $placement . "th"; break;
    }   return $result;
}

$stat_names = ["Speed","Stamina","Power","Guts","Wit", "Friendship"];
$apt_names = ["Turf","Dirt","Sprint","Mile","Medium","Long","Front","Pace","Late","End"]; 
$rarity_names = ["R","SR","SSR"];

$abbreviated_stat_names = ["SPD", "STAM", "PWR", "GUTS", "WIT", "FREN"];
$abbreviated_apt_names = ["TURF", "DIRT", "SPRN", "MILE", "MED", "LONG", "FRNT", "PACE", "LATE", "END"];

function OutputSpark($type, $spark_num) {
    $names_array = [];
    
    switch($type) {
        case 1: // plain name STAT
            $names_array = $GLOBALS["stat_names"]; break;
        case 3: // abbreviated STAT
            $names_array = $GLOBALS["abbreviated_stat_names"]; break;
        case 2: // plain name APT
            $names_array = $GLOBALS["apt_names"]; break;
        case 4: // abbreviated APT
            $names_array = $GLOBALS["abbreviated_apt_names"]; break;
    }

    $chosen_spark = floor($spark_num / 3);
    $spark_magnitude = ($spark_num % 3)+1;

    return $names_array[$chosen_spark] . " " . $spark_magnitude;
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
            $results = $stmt->execute();

            $rows = [];
            while($row = $results->fetchArray()){
                $rows[] = $row;
            }
            if(count($rows) == 1){
                $result = $rows[0];
            } else{ $result = $rows; }

            $db->close();
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
    public $is_guest = 0;   // DEFAULT = 0
    public $trainer_name;
    public $parent_ids = [];    // hold 2 horse_ids. no particular order.

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
            $sql = 'SELECT Horses.* , HorseStats.rating FROM Horses INNER JOIN HorseStats ON Horses.horse_id = HorseStats.horse_id WHERE Horses.is_guest = 0';
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
                if($row){ $this->unpack($row); $result = true; }
                else{ $result = false; }
            } else{ $result = false; }
            $db->close();
            
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

        
        $sql = 'INSERT INTO Horses(trainer_id,roster_id,horse_type,stat_spark,apt_spark,is_guest) VALUES(:trainer_id,:roster_id,:horse_type,:stat_spark,:apt_spark,:is_guest)';
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
    function loadSkills(){
        $sql = 'SELECT SkillsTable.* FROM SkillsTable INNER JOIN SkillsOwned WHERE SkillsTable.skill_id = SkillsOwned.skill_id AND SkillsOwned.horse_id=:primary_key';
        $rows = DatabaseUtility::loadOffKey($sql,$this->horse_id);

        $skills_array = [];
        if( isset($rows["skill_id"]) ) { $rows = [$rows]; }
        foreach($rows as $key => $row){
            $new_skill = new Skill($row);
            if($new_skill->skill_id){
                $skills_array[] = $new_skill; }
        }
        return $skills_array;
    }
    function loadRaceSparks(){
        $sql = 'SELECT RacesTable.*, RaceSparks.stars FROM RacesTable INNER JOIN RaceSparks WHERE RacesTable.race_id = RaceSparks.race_id AND RaceSparks.horse_id=:primary_key';
        $rows = DatabaseUtility::loadOffKey($sql,$this->horse_id);
        $sparks_array = [];
        if( isset($rows["race_id"]) ) { $rows = [$rows]; }
        foreach($rows as $key => $row){
            $new_spark = new RaceSpark($row);
            if($new_spark->race_id){
                $sparks_array[] = $new_spark; }
        }
        return $sparks_array;
    }
    function loadSkillSparks(){
        $sql = 'SELECT SkillsTable.*, SkillSparks.stars FROM SkillsTable INNER JOIN SkillSparks WHERE SkillsTable.skill_id = SkillSparks.skill_id AND SkillSparks.horse_id=:primary_key';
        $rows = DatabaseUtility::loadOffKey($sql,$this->horse_id);
        $sparks_array = [];
        if( isset($rows["skill_id"]) ) { $rows = [$rows]; }
        foreach($rows as $key => $row){
            $new_spark = new SkillSpark($row);
            if($new_spark->skill_id){
                $sparks_array[] = $new_spark; }
        }
        return $sparks_array;
    }
    function loadSupportCards(){
        $sql = 'SELECT SupportCardsTable.*, CardsUsed.card_level FROM SupportCardsTable INNER JOIN CardsUsed WHERE SupportCardsTable.support_card_id = CardsUsed.support_card_id AND CardsUsed.horse_id=:primary_key';
        $rows = DatabaseUtility::loadOffKey($sql,$this->horse_id);
        $cards_array = [];
        if( isset($rows["skill_id"]) ) { $rows = [$rows]; }
        foreach($rows as $key => $row){
            $new_card = new SupportCard($row);
            //$new_card["card_level"] = $row["card_level"];
            if($new_card->support_card_id){
                $cards_array[] = $new_card; }
        }
        return $cards_array;
    }
    function loadRaces(){
        $sql = 'SELECT RacesTable.*, RacesRan.weather, RacesRan.track_conditions, RacesRan.placement, RacesRan.strategy FROM RacesTable INNER JOIN RacesRan WHERE RacesTable.race_id = RacesRan.race_id AND RacesRan.horse_id=:primary_key';
        $rows = DatabaseUtility::loadOffKey($sql,$this->horse_id);
        $races_array = [];
        if( isset($rows["race_id"]) ) { $rows = [$rows]; }
        foreach($rows as $key => $row){
            $new_race = new Race($row);
            if($new_race->race_id){
                $races_array[] = $new_race; }
        }
        return $races_array;
    }
    function loadInspirations(){
        $sql = 'SELECT Inspirations.parent_id FROM Inspirations WHERE Inspirations.child_id = :primary_key';
        $rows = DatabaseUtility::loadOffKey($sql,$this->horse_id);
        $parents_array = [];
        if( isset($rows["parent_id"]) ) { $rows = [$rows]; }
        foreach($rows as $key => $row){
            $parent = new Horse(["horse_id"=>$row["parent_id"]]);
            $result = $parent->loadHorse();
            #$result = $parent->loadStats();
            if($result){ $parents_array[] = $parent; }
        }
        return $parents_array;
    }
    function createInspiration($params){
        // 
        $db = new SQLite3('../data/database.db');
        $sql = 'INSERT INTO Inspirations(child_id, parent_id) VALUES(:child_id, :parent_id)';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':child_id' , $this->horse_id, SQLITE3_INTEGER);
        $stmt->bindValue(':parent_id' , $params["parent_id"], SQLITE3_INTEGER);
        $result = $stmt->execute();
        if($result) {
            $this->parent_ids[] = $params["parent_id"];
        }
        return $result;
    }
    static function loadAllGuests($search_text){    //should really be $parameters. [min,max] for ranges of enum vals
        $horses_array = [];
        if(!$search_text) {
            $sql = 'SELECT Horses.* , TrainersTable.trainer_name FROM Horses INNER JOIN TrainersTable ON Horses.trainer_id = TrainersTable.trainer_id WHERE Horses.is_guest = 1';
            $rows = DatabaseUtility::loadAll($sql);
            foreach($rows as $key => $row){
                $horse = new Horse($row);
                $horse->trainer_name = $row["trainer_name"];
                $horses_array[] = $horse;
            }
        }
        return $horses_array;
    }
}

Class Race extends DatabaseUtility{
    public $race_id, $race_name, $grade, $distance, $racecourse, $track_type, $direction;
    public $weather, $track_conditions, $strategy, $placement;
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
Class RaceRan extends DatabaseUtility{
    public $race_ran_id, $race_id, $horse_id, $weather, $track_conditions, $strategy, $placement;
    function __construct($params){
        $this->unpack($params);
    }
    function loadRaceRan(){ // Maybe never getting used
        $sql = 'SELECT * FROM RacesRan WHERE race_ran_id=:primary_key';
        $row = $this->loadOffKey($sql,$this->race_ran_id); //$this->loadFromHorseId($sql);
        if($row){ $this->unpack($row); return true; }
        else{ return false; }
    }
    static function loadRacesRan($params){
        $races_array = [];
        if( !isset($params["race_id"]) || !isset($params["horse_id"])) { return $races_array; }

        $db = new SQLite3('../data/database.db');
        $results = false;
        if(isset($params["race_id"]) && isset($params["horse_id"])) {
            $sql = 'SELECT * FROM RacesRan WHERE race_id=:race_id AND horse_id=:horse_id';
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':race_id', $params["race_id"], SQLITE3_INTEGER);
            $stmt->bindValue(':horse_id', $params["horse_id"], SQLITE3_INTEGER);
            $results = $stmt->execute();
        } elseif (isset($params["race_id"])) {
            $sql = 'SELECT * FROM RacesRan WHERE race_id=:race_id';
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':race_id', $params["race_id"], SQLITE3_INTEGER);
            $results = $stmt->execute();
        } elseif (isset($params["horse_id"])) {
            $sql = 'SELECT * FROM RacesRan WHERE horse_id=:horse_id';
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':horse_id', $params["horse_id"], SQLITE3_INTEGER);
            $results = $stmt->execute();
        } else{ $db->close(); return $races_array; }
        // something happened....
        while($row = $results->fetchArray()){
            $races_array[] = new RaceRan($row);
        } $db->close();
        return $races_array;
    }
    function createRaceRan(){
        $result = false;
        //
        $db = new SQLite3('../data/database.db');
        $sql = 'INSERT INTO RacesRan(race_id, horse_id, weather, track_conditions, strategy, placement) VALUES(:race_id, :horse_id, :weather, :track_conditions, :strategy, :placement)';
        $stmt = $db->prepare($sql);

        $r_r_a = $GLOBALS['r_r_a'];
        for($i = 1; $i < count($r_r_a); $i++) {
            $stmt->bindValue(':' . $r_r_a[$i],$this->{$r_r_a[$i]}, SQLITE3_INTEGER);
        }
        $result = $stmt->execute();
        if($result){
            $this->race_ran_id = $db->lastInsertRowID();
        } $db->close(); return $result;
    }
}
Class RaceSpark extends DatabaseUtility{
    public $race_spark_id, $race_id, $horse_id, $stars;
    public $race_name, $grade, $distance, $racecourse, $track_type, $direction;
    function __construct($params){
        $this->unpack($params);
    }
    function loadSkillSpark(){}

    static function loadRaceSparks($params){
        $sparks_array = [];

        if (isset($params["horse_id"])) {
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM RaceSparks WHERE horse_id=:horse_id';
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':horse_id', $params["horse_id"], SQLITE3_INTEGER);
            $results = $stmt->execute();
            while($row = $results->fetchArray()){
                $sparks_array[] = new RaceSpark($row);
            } $db->close();
        }
        return $sparks_array;
    }
    function createRaceSpark(){
        $result = false;
        //
        $db = new SQLite3('../data/database.db');
        $sql = 'INSERT INTO RaceSparks(race_id, horse_id, stars) VALUES(:race_id, :horse_id, :stars)';
        $stmt = $db->prepare($sql);

        $r_s_a = $GLOBALS['r_s_a'];
        for($i = 1; $i < count($r_s_a); $i++) {
            $stmt->bindValue(':' . $r_s_a[$i],$this->{$r_s_a[$i]}, SQLITE3_INTEGER);
        }
        $result = $stmt->execute();
        if($result){
            $this->race_spark_id = $db->lastInsertRowID();
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
Class SkillOwned extends DatabaseUtility{
    public $skill_owned_id, $skill_id, $horse_id;
    function __construct($params){
        $this->unpack($params);
    }
    function loadSkillOwned(){ // Maybe never getting used
        $sql = 'SELECT * FROM SkillsOwned WHERE skill_owned_id=:primary_key';
        $row = $this->loadOffKey($sql,$this->skill_owned_id); //$this->loadFromHorseId($sql);
        if($row){ $this->unpack($row); return true; }
        else{ return false; }
    }
    static function loadSkillsOwned($params){
        $skills_array = [];

        if (isset($params["horse_id"])) {
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM SkillsOwned WHERE horse_id=:horse_id';
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':horse_id', $params["horse_id"], SQLITE3_INTEGER);
            $results = $stmt->execute();
            while($row = $results->fetchArray()){
                $skills_array[] = new SkillOwned($row);
            } $db->close();
        }
        return $skills_array;
    }
    function createSkillOwned(){
        $result = false;
        //
        $db = new SQLite3('../data/database.db');
        $sql = 'INSERT INTO SkillsOwned(skill_id, horse_id) VALUES(:skill_id, :horse_id)';
        $stmt = $db->prepare($sql);

        $s_o_a = $GLOBALS['s_o_a'];
        for($i = 1; $i < count($s_o_a); $i++) {
            $stmt->bindValue(':' . $s_o_a[$i],$this->{$s_o_a[$i]}, SQLITE3_INTEGER);
        }
        $result = $stmt->execute();
        if($result){
            $this->skill_owned_id = $db->lastInsertRowID();
        } $db->close(); return $result;
    }
}
Class SkillSpark extends DatabaseUtility{
    public $skill_spark_id, $skill_id, $horse_id, $stars;
    public $skill_name, $skill_type, $skill_level;
    function __construct($params){
        $this->unpack($params);
    }
    function loadSkillSpark(){}

    static function loadSkillSparks($params){
        $sparks_array = [];

        if (isset($params["horse_id"])) {
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM SkillSparks WHERE horse_id=:horse_id';
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':horse_id', $params["horse_id"], SQLITE3_INTEGER);
            $results = $stmt->execute();
            while($row = $results->fetchArray()){
                $sparks_array[] = new SkillSpark($row);
            } $db->close();
        }
        return $sparks_array;
    }
    function createSkillSpark(){
        $result = false;
        //
        $db = new SQLite3('../data/database.db');
        $sql = 'INSERT INTO SkillSparks(skill_id, horse_id, stars) VALUES(:skill_id, :horse_id, :stars)';
        $stmt = $db->prepare($sql);

        $s_s_a = $GLOBALS['s_s_a'];
        for($i = 1; $i < count($s_s_a); $i++) {
            $stmt->bindValue(':' . $s_s_a[$i],$this->{$s_s_a[$i]}, SQLITE3_INTEGER);
        }
        $result = $stmt->execute();
        if($result){
            $this->skill_spark_id = $db->lastInsertRowID();
        } $db->close(); return $result;
    }
}

Class SupportCard extends DatabaseUtility{
    public $support_card_id, $trainee_enum, $card_name, $stat, $rarity;
    public $card_level;     // only added when loading using a JOIN
    function __construct($params){
        $this->unpack($params);
    }

    function loadCard(){
        $sql = 'SELECT * FROM SupportCardsTable WHERE support_card_id=:primary_key';
        $row = $this->loadOffKey($sql,$this->support_card_id);
        if($row){ $this->unpack($row); return true; }
        else{ return false; }
    }
    static function loadAllCards($search_text){
        $db = new SQLite3('../data/database.db');
        $cards_array = [];
        if(!$search_text){
            $sql = 'SELECT * FROM SupportCardsTable';
            $rows = DatabaseUtility::loadAll($sql);

            foreach($rows as $key => $row){
                $new_card = new SupportCard($row);
                if($new_card->support_card_id){
                    $cards_array[] = $new_card; }
            }
        } else {    // Have fun searching [Tracen Academy] ...
            $sql = 'SELECT * FROM SupportCardsTable WHERE instr(lower(card_name), lower(:card_name))';
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':card_name', $search_text, SQLITE3_TEXT);
            $results = $stmt->execute();

            while($row = $results->fetchArray()){
                $cards_array[] = new SupportCard($row); }
        } $db->close();
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
            $this->support_card_id = $db->lastInsertRowID();
        } $db->close(); return $result;
    }
    function displayName(){
        $enum = HorseType::from($this->trainee_enum);
        return GetName($enum)[0];
    }
}

Class CardUsed extends DatabaseUtility{
    public $card_used_id, $support_card_id, $horse_id, $card_level;
    function __construct($params){
        $this->unpack($params);
    }
    function loadCardUsed(){} // Here, I bet on this never being required

    static function loadCardsUsed($params){
        $cards_array = [];

        if (isset($params["horse_id"])) {
            $db = new SQLite3('../data/database.db');
            $sql = 'SELECT * FROM CardsUsed WHERE horse_id=:horse_id';
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':horse_id', $params["horse_id"], SQLITE3_INTEGER);
            $results = $stmt->execute();
            while($row = $results->fetchArray()){
                $cards_array[] = new CardUsed($row);
            } $db->close();
        }
        return $cards_array;
    }
    function createCardUsed(){
        $result = false;
        //
        $db = new SQLite3('../data/database.db');
        $sql = 'INSERT INTO CardsUsed(support_card_id, horse_id, card_level) VALUES(:support_card_id, :horse_id, :card_level)';
        $stmt = $db->prepare($sql);

        $c_u_a = $GLOBALS['c_u_a'];
        for($i = 1; $i < count($c_u_a); $i++) {
            $stmt->bindValue(':' . $c_u_a[$i],$this->{$c_u_a[$i]}, SQLITE3_INTEGER);
        }
        $result = $stmt->execute();
        if($result){
            $this->card_used_id = $db->lastInsertRowID();
        } $db->close(); return $result;
    }
}


?>