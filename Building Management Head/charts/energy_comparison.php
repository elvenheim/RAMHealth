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
    <link rel="stylesheet" href="../Building Management Head/BMH Design/building_head_energy_consume.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        #pmTenChart{
            margin-top: 10px;
        }

        .legend-container {
            position: relative;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            width: 60%;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-right: 20px;
            margin-bottom: 10px;
        }

        .legend-item span {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <span class="consume-title">Energy Consumption Last Week</span>
    <?php if (!isset($_POST['room_number']) && !isset($_SESSION['selected_rooms'])) : ?>
        <br>
        <br>
        <span class="select-room">Please select rooms to show data</span>
    <?php endif; ?>

    <div class="energy-pie-group">
        <canvas id="pmTenChart" class="pie-chart"></canvas>
    </div>

    <div id="legendContainer" class="legend-container"></div>

    <script>
    var ctx = document.getElementById('pmTenChart').getContext('2d');
    var chart;
    var lastWeekData = <?php echo json_encode($lastWeekData); ?>;
    var legendItems = []; // Array to store the legend items

    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    function updateChart() {
        var selectedRooms = <?php echo json_encode(isset($_SESSION['selected_rooms']) ? $_SESSION['selected_rooms'] : []); ?>;

        var filteredData = lastWeekData.filter(function (record) {
            return selectedRooms.includes(record.aq_sensor_room_num);
        });

        var labels = filteredData.map(function (record) {
            return record.aq_sensor_room_num;
        });
        var values = filteredData.map(function (record) {
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
                    backgroundColor: values.map(function () {
                        return getRandomColor(); // Generate random background colors
                    }),
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                // Modify the title text
                                return 'Room: ' + context[0].label;
                            },
                            label: function(context) {
                                // Modify the label text
                                return context.raw;
                            }
                        },
                        titleFontSize: 16,
                        bodyFontSize: 14
                    },
                    legend: {
                        display: false // Hide the default Chart.js legend
                    }
                }
            }
        });

        // Create the HTML legend
        var legendContainer = document.getElementById('legendContainer');
        legendContainer.innerHTML = '';

        labels.forEach(function (label, index) {
            var legendItem = document.createElement('div');
            legendItem.classList.add('legend-item');

            var colorBox = document.createElement('span');
            colorBox.style.backgroundColor = chart.data.datasets[0].backgroundColor[index];
            legendItem.appendChild(colorBox);

            var legendText = document.createElement('span');
            legendText.textContent = label;
            legendItem.appendChild(legendText);

            legendContainer.appendChild(legendItem);

            // Store the legend item for click event
            legendItems.push(legendItem);

            // Add click event listener to toggle data display
            legendItem.addEventListener('click', function () {
                var meta = chart.getDatasetMeta(0);
                var metaIndex = meta.data.findIndex(function (element) {
                    return element._model.label === label;
                });

                // Toggle visibility of the data point
                meta.data[metaIndex].hidden = !meta.data[metaIndex].hidden;

                // Update the legend item style
                if (meta.data[metaIndex].hidden) {
                    colorBox.style.opacity = 0.5;
                    legendText.style.textDecoration = 'line-through';
                } else {
                    colorBox.style.opacity = 1;
                    legendText.style.textDecoration = 'none';
                }

                chart.update();
            });
        });
    }

    updateChart();
</script>

</body>
</html>
