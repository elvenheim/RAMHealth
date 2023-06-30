<?php
    require_once('building_head_connect.php');

    if (isset($_POST['room_number'])) {
        // Retrieve the selected room numbers
        $selectedRooms = $_POST['room_number'];

        $_SESSION['selected_rooms'] = $selectedRooms;

        // Convert the selected rooms array to a string for the SQL query
        $selectedRoomsStr = implode("','", $selectedRooms);

        $sqlten = "SELECT aqpm.*, aqs.aq_sensor_room_num, aqs.aq_sensor_name
            FROM aq_particulate_matter aqpm
            JOIN aq_sensor aqs ON aqpm.pm_sensor = aqs.aq_sensor_id
            WHERE aqs.aq_sensor_room_num IN ('$selectedRoomsStr')
            AND aqpm.pm_date >= DATE_SUB(NOW(), INTERVAL 7 DAY)";

        $result_table = mysqli_query($con, $sqlten);

        $pmTenData = array();
        while ($row = mysqli_fetch_assoc($result_table)) {
            $pmTenData[] = array(
                'date' => $row['pm_date'],
                'time' => $row['pm_time'],
                'pm_ten' => $row['pm_ten']
            );
        }
    } elseif (empty($_POST['room_number'])) {
        // Clear the selected rooms when no room is selected
        unset($_SESSION['selected_rooms']);
    }

    // Fetch the data for the last week
    $lastWeekSql = "SELECT aqs.aq_sensor_room_num, COUNT(*) AS num_records
                    FROM aq_particulate_matter aqpm
                    JOIN aq_sensor aqs ON aqpm.pm_sensor = aqs.aq_sensor_id
                    WHERE aqpm.pm_date >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                    GROUP BY aqs.aq_sensor_room_num";
    $lastWeekResult = mysqli_query($con, $lastWeekSql);
    $lastWeekData = array();
    while ($row = mysqli_fetch_assoc($lastWeekResult)) {
        $lastWeekData[] = $row;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Last Week's Energy Consumption</title>
    <link rel="stylesheet" href="../Building Management Head/charts/charts.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <span class="chart-title">Last Week's Energy Consumption</span>
    <div class="pm-ten-chart-group">
        <canvas id="pmTenChart" class="chart"></canvas>
    </div>

    <?php if (!isset($_POST['room_number']) && !isset($_SESSION['selected_rooms'])) : ?>
        <p>Please select rooms to show data</p>
    <?php endif; ?>

    <script>
        var ctx = document.getElementById('pmTenChart').getContext('2d');
        var chart;
        var lastWeekData = <?php echo json_encode($lastWeekData); ?>;

        function updateChart() {
            var selectedRooms = <?php echo json_encode(isset($_SESSION['selected_rooms']) ? $_SESSION['selected_rooms'] : []); ?>;

            var filteredData = lastWeekData.filter(function(record) {
                return selectedRooms.includes(record.aq_sensor_room_num);
            });

            var labels = filteredData.map(function(record) {
                return record.aq_sensor_room_num;
            });
            var values = filteredData.map(function(record) {
                return record.num_records;
            });

            if (chart) {
                chart.destroy();
            }

            chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: [
                            '#E7AE41',
                            '#007BFF',
                            '#DC3545',
                            '#28A745',
                            '#FFC107',
                            '#17A2B8',
                            '#6610F2',
                            '#6C757D',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 12
                                }
                            },
                        }
                    }
                }
            });
        }
        updateChart();
    </script>
</body>
</html>
