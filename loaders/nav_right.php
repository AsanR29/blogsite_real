<?php
require_once('../php_classes/account_class.php');
require_once('../php_classes/file_class.php');
?>
<div id="rightgap"></div>
<div id="navbox">
    <div id="searchlink" class="textcenter">
        <a class="titlesize notalink" href="../blogdaily/search.php">Homepage</a>
    </div>
    <?php
    $target = 0;
    if(isset($blog)){
        $target = $blog->account_id;
        $account_info = new Account(array('account_id'=>$target));
        $result = $account_info->loadAccount();
        if(!$result){
            $target = 0;
        }
    }
    else if(isset($username)){
        $account_info = new Account(array('username'=>$username));
        $result = $account_info->loadAccount();
        if($result){
            $target = $account_info->account_id;
            $result = $account_info->loadAccount();
        }
    }
    if($target):?>
    <div class="aboutmearea">
        <section class="aboutmepicarea">
            <a href="../blogdaily/user.php?username=<?php echo $account_info->username; ?>"><img class="pfp" src="
            <?php
                $params = array(
                    'account_id'=>$account_info->account_id,
                    'file_use'=>"pfp"
                );
                $pfp_file = new UserFile($params);
                $result = $pfp_file->loadFile();
                if($result){
                    echo $pfp_file->getUrl();
                }
                else{
                    echo "../css/defaultpfp.png";
                }
            ?>
            "></a> 
        </section>
        <section class="aboutmetext">
            <div class="linebreak"><label class="labelusername"><?php echo $account_info->username; ?></label></div>
            <div class="aboutmepart">
                <label class="b_text">About me</label><br>
                <output class="b_text"><?php echo $account_info->bio; ?></output>
            </div>
        </section>
    </div>
    <?php endif; ?>
    <div id="blogtagarea">
        <?php require_once('../loaders/blogtag_box.php'); ?>
        <?php
            if(!isset($_SESSION['blogtags'])){
                $_SESSION['blogtags'] = array();
            }
            for($i = count($_SESSION['blogtags']) -1; $i > -1; $i -=1):
        ?>
        <div id=<?php echo '"blogtag_' . $i . '"'; ?> class="blogtagdiv"><span name=<?php echo '"blogtag_' . $i . '"'; ?> class="blog_tag">
            <?php echo $_SESSION['blogtags'][$i]; ?>
        </span><button onclick="removeBlogtag(<?php echo $i; ?>)" class="gen_button blogtagbutton unround">X</button></div>
        <?php endfor; ?>
    </div>
    <div id="profilelink" class="textcenter">
        <a class="titlesize notalink" onclick="clearTags()">Clear Tags</a>
    </div>
</div>