<?php 
    require_once('building_head_connect.php');

    $panelgroupQuery = "SELECT ec_panel_grouping_id FROM ec_panel_grouping";
    $panelgroupResult = mysqli_query($con, $panelgroupQuery);
?>

<form id="panel-group-selection-form">
    <label for="panel_grouping">Panel Group:</label>
    <select id="panel_grouping" name="panel_grouping" class="panel_grouping" required onchange="updatePanelLabelDropdown(this.value)">
    <option value="" disabled selected>-Select Group-</option>
        <?php
        while ($row = mysqli_fetch_assoc($panelgroupResult)) {
            echo '<option value="' . $row['ec_panel_grouping_id'] . '">' . $row['ec_panel_grouping_id'] . '</option>';
        }
        ?>
    </select><br>
</form>