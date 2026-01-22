<?php
$horse_cards = $horse->loadSupportCards();
for($i = 0; $i < count($horse_cards); $i++): ?>
    <div class="skillowned_record_grid">
        <output class="horse_record_input form_input"><?php echo $horse_cards[$i]->card_name . " " . GetName(GetHorseEnum($horse_cards[$i]->trainee_enum))[0] . " " . $stat_names[$horse_cards[$i]->stat] . " " . $rarity_names[$horse_cards[$i]->rarity] . " " . "Lv" . $horse_cards[$i]->card_level; ?></output>
    </div>
<?php endfor; ?>