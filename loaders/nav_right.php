<div id="rightgap"></div>
<div id="navbox">
    <div id="searchlink" class="textcenter">
        <a class="titlesize notalink" href="../blogdaily/search.php">Search</a>
    </div>
    <div id="taglist">
        <ul>Tags:
            
        </ul>
    </div>
    <div id="profilelink" class="textcenter">
        <?php if(isset($account_id) && $account_id): ?>
            <a class="titlesize notalink" href="../blogdaily/profile.php">Profile</a>
        <?php else: ?>
            <a class="titlesize notalink" href="../blogdaily/login.php">Log in</a>
        <?php endif; ?>
    </div>
    <div id="settingslink" class="textcenter">
        <?php if(isset($account_id) && $account_id): ?>
            <a class="titlesize notalink" href="../blogdaily/settings.php">Settings</a>
        <?php else: ?>
            <a class="titlesize notalink" href="../blogdaily/signup.php">Sign up</a>
        <?php endif; ?>
    </div>
</div>