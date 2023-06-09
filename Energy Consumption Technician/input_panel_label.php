<?php 
    require_once('energy_technician_connect.php');

    $panellabelQuery = "SELECT ec_panel_label_id FROM ec_panel_label";
    $panellabelResult = mysqli_query($con, $panellabelQuery);
    
    echo '<label for="panel_label">Panel Label:</label>';
    echo '<select id="panel_label" name="panel_label" class="panel_label" required>';
    echo '<option value="" disabled selected>-Select Panel Label-</option>';
    while ($row = mysqli_fetch_assoc($panellabelResult)) {
        echo '<option value="' . $row['ec_panel_label_id'] . '">' . $row['ec_panel_label_id'] . '</option>';
    }
    echo '</select><br>';
?>