<div class="content">
    <div class="nav-grid">
        <div class="brow nav-cell"><a class="notalink" href="
            <?php 
                if(isset($blog)){
                    echo '../blogdaily/user.php?username=';
                    require_once('../php_requests/account_username.php');
                }
                else{
                    echo '../blogdaily/search.php';
                }
            ?>
        "><button class="nobutton">
            <?php
                if(isset($blog)){
                    echo "Feed";
                }
                else{
                    echo "Home";
                }
            ?>
            </button></a>
        </div>
        <div class="brow nav-cell searchbar">
            <div class="fillheight">
            <form class="weirdform" method="post" action="search.php">
                <input class="form_input" id="searchbox" name="title"></input>
                </div>
            </div>
            <div class="brow nav-cell"><button class="nobutton">Search</button></div>
        </form>
        <div class="brow nav-cell">
            <?php if(isset($account_id) && $account_id): ?>
                <a class="notalink" href="../blogdaily/profile.php"><button class="nobutton">Profile</button></a>
            <?php else: ?>
                <a class="notalink" href="../blogdaily/login.php"><button class="nobutton">Log in</button></a>
            <?php endif; ?>
        </div>
        <div class="brow nav-cell">
            <?php if(isset($account_id) && $account_id): ?>
                <a class="notalink" href="../blogdaily/settings.php"><button class="nobutton">Settings</button></a>
            <?php else: ?>
                <a class="notalink" href="../blogdaily/signup.php"><button class="nobutton">Sign up</button></a>
            <?php endif; ?>
        </div>
        <?php if(isset($account_id) && $account_id): ?>
        <div class="brow nav-cell">
            <a class="notalink" href="../blogdaily/trainer_menu.php"><button class="nobutton">🐴</button></a>
        </div> <?php endif; ?>
    </div>
</div>
<div id="mainbuffer"></div>