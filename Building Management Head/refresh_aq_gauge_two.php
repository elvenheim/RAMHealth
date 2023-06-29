<?php
    echo '<div class="gauge-box-two-card">';
        echo '<div class="indoor-temp-gauge-group">';
        include('../Building Management Head/gauges/indoor_temperature_gauge.php');
        echo '</div>';
        echo '<div class="outdoor-temp-gauge-group">';
        include('../Building Management Head/gauges/outdoor_temperature_gauge.php');
        echo '</div>';
        echo '<div class="humidity-gauge-group">';
        include('../Building Management Head/gauges/humidity_gauge.php');
        echo '</div>';
        echo '<div class="aq-summary-group">';
        include('../Building Management Head/aq_summary.php');
        echo '</div>';
    echo '</div>';
?>
