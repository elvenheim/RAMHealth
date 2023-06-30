<?php
    require_once('building_head_connect.php');

    if (isset($_POST['room_number'])) {
        // Retrieve the selected room numbers
        $selectedRooms = $_POST['room_number'];

        $_SESSION['selected_rooms'] = $selectedRooms;

        // Convert the selected rooms array to a string for the SQL query
        $selectedRoomsStr = implode("','", $selectedRooms);

        $sqltenten = "SELECT aqpm.*, aqs.aq_sensor_room_num, aqs.aq_sensor_name
            FROM aq_particulate_matter aqpm
            JOIN aq_sensor aqs ON aqpm.pm_sensor = aqs.aq_sensor_id
            WHERE aqs.aq_sensor_room_num IN ('$selectedRoomsStr')
            AND aqpm.pm_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)";

        $result_table = mysqli_query($con, $sqltenten);

        $pmTenTenData = array();
        while ($row = mysqli_fetch_assoc($result_table)) {
            $pmTenTenData[] = array(
                'date' => $row['pm_date'],
                'time' => $row['pm_time'],
                'pm_ten' => $row['pm_ten']
            );
        }
    } elseif (empty($_POST['room_number'])) {
        // Clear the selected rooms when no room is selected
        unset($_SESSION['selected_rooms']);
    }

    // Fetch the data for the current month
    $currentMonthSql = "SELECT aqs.aq_sensor_room_num, COUNT(*) AS num_records
                    FROM aq_particulate_matter aqpm
                    JOIN aq_sensor aqs ON aqpm.pm_sensor = aqs.aq_sensor_id
                    WHERE aqpm.pm_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                    GROUP BY aqs.aq_sensor_room_num";
    $currentMonthResult = mysqli_query($con, $currentMonthSql);
    $currentMonthData = array();
    while ($row = mysqli_fetch_assoc($currentMonthResult)) {
        $currentMonthData[] = $row;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Current Month Total Energy Consumption</title>
    <link rel="stylesheet" href="../Building Management Head/charts/charts.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <span class="tentenchart-title">Current Month Total Energy Consumption</span>
    <div class="pm-ten-tentenchart-group">
        <canvas id="pmTenTenChart" class="tentenchart"></canvas>
        <div id="message" class="message"></div>
    </div>

    <script>
        var TenTenctx = document.getElementById('pmTenTenChart').getContext('2d');
        var tentenchart;
        var currentMonthData = <?php echo json_encode($currentMonthData); ?>;

        function updateChart() {
            var selectedRooms = <?php echo json_encode(isset($_SESSION['selected_rooms']) ? 
            $_SESSION['selected_rooms'] : []); ?>;

            var filteredData = currentMonthData.filter(function(record) {
                return selectedRooms.includes(record.aq_sensor_room_num);
            });

            var labels = filteredData.map(function(record) {
                return record.aq_sensor_room_num;
            });
            var values = filteredData.map(function(record) {
                return record.num_records;
            });

            if (tentenchart) {
                tentenchart.destroy();
            }

            if (selectedRooms.length === 0) {
                document.getElementById('message').innerText = "Please select rooms to show data";
            } else {
                document.getElementById('message').innerText = "";

                tentenchart = new Chart(TenTenctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: '#007BFF',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                max: Math.max(...values) + 1,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }
        }
        updateChart();

        // Reset the chart when the page is refreshed or left
        window.addEventListener('unload', function() {
            if (tentenchart) {
                tentenchart.destroy();
            }
        });
    </script>
</body>
</html>
