<?php
    require_once('building_head_connect.php');

    $sql_zero_one = "SELECT aqpm.*, aqs.aq_sensor_room_num, aqs.aq_sensor_name
        FROM aq_particulate_matter aqpm
        JOIN aq_sensor aqs ON aqpm.pm_sensor = aqs.aq_sensor_id";

    $result_table = mysqli_query($con, $sql_zero_one);

    $zeroOneData = array();
    while ($row = mysqli_fetch_assoc($result_table)) {
        $zeroOneData[] = array(
            'date' => $row['pm_date'],
            'time' => $row['pm_time'],
            'pm_zero_one' => $row['pm_zero_one']
        );
    }

    // Fetch the past 24 hours data
    $zeroonepast24hoursSql = "SELECT DATE_FORMAT(pm_time, '%H:00') AS zero_one_datetime, MAX(pm_zero_one) AS peak_zero_one FROM aq_particulate_matter WHERE pm_date >= DATE_SUB(NOW(), INTERVAL 24 HOUR) GROUP BY zero_one_datetime";
    $zeroonepast24hoursResult = mysqli_query($con, $zeroonepast24hoursSql);
    $zeroonepast24hoursData = array();
    while ($row = mysqli_fetch_assoc($zeroonepast24hoursResult)) {
        $zeroonepast24hoursData[] = $row;
    }

    // Fetch the past 7 days data
    $zeroonepast7daysSql = "SELECT DATE_FORMAT(pm_date, '%m/%d') AS zero_one_date, MAX(pm_zero_one) AS peak_zero_one FROM aq_particulate_matter WHERE pm_date >= DATE_SUB(NOW(), INTERVAL 7 DAY) GROUP BY zero_one_date";
    $zeroonepast7daysResult = mysqli_query($con, $zeroonepast7daysSql);
    $zeroonepast7daysData = array();
    while ($row = mysqli_fetch_assoc($zeroonepast7daysResult)) {
        $zeroonepast7daysData[] = $row;
    }

    // Fetch the past 30 days data
    $zeroonepast30daysSql = "SELECT DATE_FORMAT(pm_date, '%m/%d') AS zero_one_date, MAX(pm_zero_one) AS peak_zero_one FROM aq_particulate_matter WHERE pm_date >= DATE_SUB(NOW(), INTERVAL 30 DAY) GROUP BY zero_one_date";
    $zeroonepast30daysResult = mysqli_query($con, $zeroonepast30daysSql);
    $zeroonepast30daysData = array();
    while ($row = mysqli_fetch_assoc($zeroonepast30daysResult)) {
        $zeroonepast30daysData[] = $row;
    }

    // Fetch the past 12 months data
    $zeroonepast12monthsSql = "SELECT DATE_FORMAT(pm_date, '%m/%Y') AS zero_one_month, MAX(pm_zero_one) AS peak_zero_one FROM aq_particulate_matter WHERE pm_date >= DATE_SUB(NOW(), INTERVAL 12 MONTH) GROUP BY zero_one_month";
    $zeroonepast12monthsResult = mysqli_query($con, $zeroonepast12monthsSql);
    $zeroonepast12monthsData = array();
    while ($row = mysqli_fetch_assoc($zeroonepast12monthsResult)) {
        $zeroonepast12monthsData[] = $row;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>PM Zero One Chart Example</title>
    <link rel="stylesheet" href="../Building Management Head/charts/charts.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <span class="chart-title">General Air Particulate Matter 0.1 Level</span>
    <div class="chart-button">
        <label for="timeRangeZeroOne">Time Range:</label>
        <select id="timeRangeZeroOne" onchange="updateZeroOneChart()">
            <option value="zeroonepast24hours" selected>Past 24 Hours</option>
            <option value="zeroonepast7days">Past 7 Days</option>
            <option value="zeroonepast30days">Past 30 Days</option>
            <option value="zeroonepast12months">Past 12 Months</option>
        </select>
    </div>
    <div class="pm-zero-one-chart-group">
        <canvas id="pmZeroOneChart" class="chart"></canvas>
    </div>

    <script>
        var pmZeroOneCtx = document.getElementById('pmZeroOneChart').getContext('2d');
        var pmZeroOneChart;
        var zeroonepast24hoursData = <?php echo json_encode($zeroonepast24hoursData); ?>;
        var zeroonepast7daysData = <?php echo json_encode($zeroonepast7daysData); ?>;
        var zeroonepast30daysData = <?php echo json_encode($zeroonepast30daysData); ?>;
        var zeroonepast12monthsData = <?php echo json_encode($zeroonepast12monthsData); ?>;

        function processZeroOneData(selectedRange, rawData) {
            var processedData = {
                dates: [],
                pmZeroOneValues: []
            };

            rawData.forEach(function(row) {
                processedData.dates.push(row.zero_one_datetime || row.zero_one_date || row.zero_one_month);
                processedData.pmZeroOneValues.push(row.peak_zero_one);
            });

            return processedData;
        }

        function updateZeroOneChart() {
            var selectedRange = document.getElementById('timeRangeZeroOne').value;
            var rawData;

            if (selectedRange === 'zeroonepast24hours') {
                rawData = zeroonepast24hoursData;
            } else if (selectedRange === 'zeroonepast7days') {
                rawData = zeroonepast7daysData;
            } else if (selectedRange === 'zeroonepast30days') {
                rawData = zeroonepast30daysData;
            } else if (selectedRange === 'zeroonepast12months') {
                rawData = zeroonepast12monthsData;
            }

            var data = processZeroOneData(selectedRange, rawData);

            if (pmZeroOneChart) {
                pmZeroOneChart.destroy();
            }

            pmZeroOneChart = new Chart(pmZeroOneCtx, {
                type: 'bar',
                data: {
                    labels: data.dates,
                    datasets: [{
                        label: 'PM Zero One',
                        data: data.pmZeroOneValues,
                        borderColor: 'black',
                        borderWidth: 1,
                        backgroundColor: '#E7AE41',
                    }]
                },
                options: {
                    scales: {
                        x: {
                            ticks: {
                                font: {
                                    size: 15, // Specify the desired label font size
                                },
                            },
                            grid: {
                                display: false,
                                color: 'rgba(0, 0, 0, 1)',
                                borderDash: [5, 5],
                                borderWidth: 1,
                                drawBorder: true,
                                drawOnChartArea: true,
                                drawTicks: true,
                                tickColor: 'rgba(0, 0, 0, 1)',
                                tickLength: 10,
                                lineWidth: 1,
                            },
                        },
                        y: {ticks: {
                                font: {
                                    size: 15, // Specify the desired label font size and color
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 1)',
                                borderDash: [5, 5],
                                borderWidth: 1,
                                drawBorder: true,
                                drawOnChartArea: true,
                                drawTicks: true,
                                tickColor: 'rgba(0, 0, 0, 1)',
                                tickLength: 10,
                                lineWidth: 1,
                            },
                            beginAtZero: true,
                            suggestedMin: 0,
                            suggestedMax: 45,
                            title: {
                                display: false,
                                text: 'PM 2.5'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        updateZeroOneChart();
    </script>
</body>
</html>
