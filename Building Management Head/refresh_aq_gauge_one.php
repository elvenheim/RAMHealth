<?php
    echo '<div class="gauge-box-one-card">';
        echo '<div class="pm-ten-gauge-group">';
        include('../Building Management Head/gauges/pm_ten_gauge.php');
        echo '</div>';
        echo '<div class="pm-two-five-gauge-group">';
        include('../Building Management Head/gauges/pm_two_five_gauge.php');
        echo '</div>';
        echo '<div class="pm-zero-one-gauge-group">';
        include('../Building Management Head/gauges/pm_zero_one_gauge.php');
        echo '</div>';
        echo '<div class="gas-gauge-group">';
        include('../Building Management Head/gauges/gas_gauge.php');
        echo '</div>';
    echo '</div>';
?>
