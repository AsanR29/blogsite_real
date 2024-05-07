<div id="historybox">
    <div id="arrowsbox">
        <div id="leftarrow" class="arrow"></div>
        <div id="rightarrow" class="arrow"></div>
    </div>
    <div id="historylist">
        <ul>History:
            <?php
                if(!isset($_SESSION['history'])){
                    $_SESSION['history'] = array(
                        'url'=>array(),
                        'title'=>array()
                    );
                }
                for($i = count($_SESSION['history']['url']) -1; $i > -1; $i -=1):
            ?>
            <li>
                <a href="../blogdaily/read.php?blog_url=<?php echo $_SESSION['history']['url'][$i]; ?>">
                    <?php echo $_SESSION['history']['title'][$i]; ?>
                </a>
            </li>
            <?php endfor; ?>
        </ul>
    </div>
</div>
<div id="leftgap"></div>