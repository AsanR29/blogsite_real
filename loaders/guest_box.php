<div class="horse_icon_box menu_gaps">
    <img src="<?php
        $params = array(
            'roster_id'=>$horse_records[$i]->roster_id,
            'file_use'=>"horse_icon"
        );
        $pfp_file = new UserFile($params);
        $result = $pfp_file->loadFile();
        if($result){
            $result = $pfp_file->getUrl();
            echo $result;
        }
        if($result == false){
            //echo "../css/defaultpfp.png";
            echo GetName(GetHorseEnum($horse_records[$i]->horse_type))[2];
        }
    ?>"><br>
    <a href="../blogdaily/veteran.php?horse_id=<?php echo $horse_records[$i]->horse_id; ?>">
        <?php $horse_enum = GetHorseEnum($horse_records[$i]->horse_type);
        echo GetName($horse_enum)[0]; ?>
    </a>
    <output style="padding-right:10px;"><?php echo $horse_records[$i]->trainer_name; ?></output><br>
    <div style="width:auto;">
        <output style="width:50%; background-color:#9988DD; white-space: nowrap;"><?php echo OutputSpark(3,$horse_records[$i]->stat_spark); ?></output>
        <output style="width:50%; background-color:#DD88BB; white-space: nowrap;"><?php echo OutputSpark(4,$horse_records[$i]->apt_spark); ?></output>
    </div>
</div>