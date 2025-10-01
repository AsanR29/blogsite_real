<div class="content">
    <div id="horse_search_area" class="nav-grid">
        <div class="brow nav-cell">
            <a class="notalink" href="<?php echo '../blogdaily/trainer.php'; ?>">
                <button class="nobutton">Home</button>
            </a>
        </div>
        <div class="brow nav-cell searchbar">
            <div class="fillheight">
            <form class="weirdform">
                <input class="form_input" id="searchbox" name="horse_search"></input>
                </div>
            </div>
            <div class="brow nav-cell"><button type="button" class="nobutton" onclick="sendForm('horse_search_area')">Search</button></div>
        </form>
        <div class="brow nav-cell" style="width:160px;">
            <select class="form_input notalink nobutton" name="search_type">
                <option value="race">race</option>
                <option value="skill">skill</option>
                <option value="card">support card</option>
                <option value="trainee">trainee</option>
            </select>
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
<div id="horse_searchresults">
    
</div>
<div id="mainbuffer"></div>