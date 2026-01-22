<?php

    ?> <section class="squares_menu" style="position: absolute; height: 100vh; overflow-y: scroll;"> <?php 
    $search_text = "";
    $horse_records = Horse::loadAllHorses($search_text);
    for($i = 0; $i < count($horse_records); $i++): ?>
        <button onclick="queueParent(this,<?php echo $horse_records[$i]->horse_id; ?>)" class="nostylebutton"><?php require("veteran_box.php"); ?></button>
    <?php endfor; ?>
    <?php if(count($horse_records) == 0): ?>
        <section>
            <div><output class="titlesize" style="color:grey">No Horses found</h2></div>
        </section>
    <?php endif;

    // split this into 2 tabs later.
    $horse_records = Horse::loadAllGuests($search_text);
    for($i = 0; $i < count($horse_records); $i++): ?>
        <button onclick="queueParent(this,<?php echo $horse_records[$i]->horse_id; ?>)" class="nostylebutton"><?php require("guest_box.php"); ?></button>
    <?php endfor; ?>
    <?php if(count($horse_records) == 0): ?>
        <section>
            <div><output class="titlesize" style="color:grey">No Guests found</h2></div>
        </section>
    <?php endif;
?>