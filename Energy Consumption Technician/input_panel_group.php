<?php 
    require_once('energy_technician_connect.php');

    $panelgroupQuery = "SELECT ec_panel_grouping_id FROM ec_panel_grouping";
    $panelgroupResult = mysqli_query($con, $panelgroupQuery);
    
    echo '<label for="panel_grouping">Panel Group:</label>';
    echo '<select id="panel_grouping" name="panel_grouping" class="panel_grouping" required>';
    echo '<option value="" disabled selected>-Select Panel Group-</option>';
    while ($row = mysqli_fetch_assoc($panelgroupResult)) {
        echo '<option value="' . $row['ec_panel_grouping_id'] . '">' . $row['ec_panel_grouping_id'] . '</option>';
    }
    echo '</select><br>';
?>