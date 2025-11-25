<!-- $tab_ids = ["tab_1", "tab_2", "tab_3", "tab_4", "tab_5"]; 
 $tab_names = ["Races Ran", "Race Sparks", "Inspirations", etc]; -->
<script>
// tab_ids = ["tab_1", "tab_2", "tab_3", "tab_4", "tab_5"];
function ChangeTab(id){
    for(let i = 0; i < tab_ids.length; i++) {
        //console.log(tab_ids, id, tab_ids.length, (tab_ids[i] == id));
        if(tab_ids[i] == id) {
            document.getElementById(id).style.display = "block";
        } else{ document.getElementById(tab_ids[i]).style.display = "none"; }
    }
}
</script>
<div class="content">
    <div class="nav-grid">
        <?php for($i = 0; $i < count($tab_ids); $i++): ?>
            <div class="brow nav-cell" style="width: 100%;">
                <button type="button" class="nobutton" 
                    onclick="ChangeTab('<?php echo $tab_ids[$i]; ?>')">
                    <?php echo $tab_names[$i]; ?>
                </button>
            </div>
        <?php endfor; ?>
    </div>
</div>
<div id="mainbuffer"></div>