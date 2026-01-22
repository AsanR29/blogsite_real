<?php
$horse_sparks = $horse->loadRaceSparks();
for($i = 0; $i < count($horse_sparks); $i++): ?>
    <div class="skillowned_record_grid">
        <output class="horse_record_input form_input"><?php echo $horse_sparks[$i]->race_name . " " . $horse_sparks[$i]->stars; ?></output>
    </div>
<?php endfor; 
$horse_sparks = $horse->loadSkillSparks();
for($i = 0; $i < count($horse_sparks); $i++): ?>
    <div class="skillowned_record_grid">
        <output class="horse_record_input form_input"><?php echo $horse_sparks[$i]->skill_name . " " . $horse_sparks[$i]->stars; ?></output>
    </div>
<?php endfor; ?>