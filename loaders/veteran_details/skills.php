<?php
$horse_skills = $horse->loadSkills();
for($i = 0; $i < count($horse_skills); $i++): ?>
    <div class="skillowned_record_grid">
        <output class="horse_record_input form_input"><?php echo $horse_skills[$i]->skill_name; ?></output>
    </div>
<?php endfor; ?>