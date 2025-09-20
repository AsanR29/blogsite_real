<?php 
if(isset($account_type) && $account_type == 3):
    require_once('../loaders/admin_left.php');
else: ?>
    

<div id="historybox">
    <div id="historylist">
        <ul class="simplelist"><label id="wordhistory"class="navsize">History:</label>
            <?php
                if(!isset($_SESSION['history'])){
                    $_SESSION['history'] = array(
                        'url'=>array(),
                        'title'=>array()
                    );
                }
                for($i = count($_SESSION['history']['url']) -1; $i > -1; $i -=1):
            ?>
            <li class="listitem">
                <a href="../blogdaily/read.php?blog_url=<?php echo $_SESSION['history']['url'][$i]; ?>">
                    <?php echo $_SESSION['history']['title'][$i]; ?>
                </a>
            </li>
            <?php endfor; ?>
        </ul>
    </div>
</div>
<div id="leftgap"></div>
<?php endif; ?>
