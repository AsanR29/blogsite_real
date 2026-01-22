<?php
$horse_races = $horse->loadRaces();
for($i = 0; $i < count($horse_races); $i++): ?>
    <div class="seventy_thirty">
        <div>
            <div class="horse_race_head">
                <output> <?php echo $horse_races[$i]->race_name; ?> </output>
                <output> <?php echo $race_grades[$horse_races[$i]->grade]; ?> </output>
            </div>
            <div class="horse_racesran_grid">
                <output> <?php echo $racecourse_names[$horse_races[$i]->racecourse]; ?> </output>
                <output> <?php echo $track_types[$horse_races[$i]->track_type]; ?> </output>
                <output> <?php echo $horse_races[$i]->distance . "m"; ?> </output>
                <output> <?php echo $track_directions[$horse_races[$i]->direction]; ?> </output>

                <output> <?php echo $weather_names[$horse_races[$i]->weather]; ?> </output>
                <output> <?php echo $track_conditions[$horse_races[$i]->track_conditions]; ?> </output>
                <output> <?php echo $race_strategies[$horse_races[$i]->strategy]; ?> </output>
            </div>
        </div>
        <output><?php echo 
            FormatPlacement($horse_races[$i]->placement);
        ?></output>
    </div>
<?php endfor; ?>