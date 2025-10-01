<?php
//require_once('../php_classes/horse_classes.php');
require_once('../php_classes/account_class.php');   // trainers in here
$form = json_decode(file_get_contents('php://input'), true);
$params = array();

if(isset($form['username']) && $form['username']){
    $account = new Account($form);
    $result = $account->loadAccount();
    if($result){
        $user_id = $account->account_id;
        $params['account_id'] = $user_id;
    }
}

session_start();

$trainer_array = Trainer::loadTrainers($params);
for($i = 0; $i < count($trainer_array); $i++):
?>
<section class="blogpr blogpreview">
    <div class="blogp">
        <div class="blogpL1 blogpr"></div>
        <div class="blogpM1" style="display:flex; padding-top:8px;">
            <div style="width:50%"><output class="titlesize"><?php echo $trainer_array[$i]->trainer_name; ?></output></div>
            <div id="createprompt" class="textcenter" style="width:50%">
                <a class="titlesize notalink" href="../blogdaily/trainer.php?trainer_id=<?php echo $trainer_array[$i]->trainer_id; ?>">Use Trainer</a>
            </div>
        </div>

        <div class="blogpR1 blogpr"></div>
    </div>
    <div class="blogfoot blogpr"></div>
</section>
<div id="mainbuffer"></div>
<?php endfor; ?>
<?php if(count($trainer_array) == 0): ?>
<section>
    <div><output class="titlesize" style="color:grey">No trainers found</h2></div>
</section>
<?php endif; ?>
