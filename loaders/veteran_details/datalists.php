<datalist id="trainee_options">
    <?php
        $enums_array = HorseType::cases();
        $names_array = array_column(HorseType::cases(),'value');

        foreach($enums_array as $pos => $enum): ?>
            <option value="<?php echo $names_array[$pos]; ?>"><?php $two_names = GetName($enum); echo $two_names[0] . " " . $two_names[1]; ?></option>
        <?php endforeach; ?>
</datalist>
<datalist id="skill_options"><?php foreach($skill_records as $key=>$record): ?>
    <option value="<?php echo $record->skill_id; ?>"> <?php echo $record->skill_name . " " . $record->skill_level; ?></option>
<?php endforeach; ?></datalist>
<datalist id="race_options"><?php foreach($race_records as $key=>$record): ?>
    <option value="<?php echo $record->race_id; ?>"> 
        <?php echo $record->race_name;
        if($record->grade <= 1 || $record->grade == 7){
            echo "\n " . $racecourse_names[$record->racecourse] . " " . $record->distance . "m " . $track_types[$record->track_type] . " " . $track_directions[$record->direction];  
        } ?>
        </option>
<?php endforeach; ?></datalist>
<datalist id="card_options"><?php foreach($card_records as $key=>$record): ?>
    <option value="<?php echo $record->support_card_id; ?>"> <?php echo $record->card_name . " " . GetName(GetHorseEnum($record->trainee_enum))[0]; ?></option>
<?php endforeach; ?></datalist>
<datalist id="racespark_options"><?php foreach($race_records as $key=>$record):
    if($record->grade > 5): ?>  <!-- 5 : G1, 6 : EX -->
        <option value="<?php echo $record->race_id; ?>"> <?php echo $record->race_name; ?></option>
<?php endif; endforeach; ?></datalist>   