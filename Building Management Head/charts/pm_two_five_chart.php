<?php
    require_once('building_head_connect.php');

    $sqltwo_five = "SELECT aqpm.*, aqs.aq_sensor_room_num, aqs.aq_sensor_name
        FROM aq_particulate_matter aqpm
        JOIN aq_sensor aqs ON aqpm.pm_sensor = aqs.aq_sensor_id";

    $result_table = mysqli_query($con, $sqltwo_five);

    $pmTwoFiveData = array();
    while ($row = mysqli_fetch_assoc($result_table)) {
        $pmTwoFiveData[] = array(
            'date' => $row['pm_date'],
            'time' => $row['pm_time'],
            'pm_two_five' => $row['pm_two_five']
        );
    }

    // Fetch the past 24 hours data
    $twofivepast24hoursSql = "SELECT DATE_FORMAT(pm_time, '%H:00') AS pm_datetime, MAX(pm_two_five) AS peak_pm_two_five FROM aq_particulate_matter WHERE pm_date >= DATE_SUB(NOW(), INTERVAL 24 HOUR) GROUP BY pm_datetime";
    $twofivepast24hoursResult = mysqli_query($con, $twofivepast24hoursSql);
    $twofivepast24hoursData = array();
    while ($row = mysqli_fetch_assoc($twofivepast24hoursResult)) {
        $twofivepast24hoursData[] = $row;
    }

    // Fetch the past 7 days data
    $twofivepast7daysSql = "SELECT DATE_FORMAT(pm_date, '%m/%d') AS pm_date, MAX(pm_two_five) AS peak_pm_two_five FROM aq_particulate_matter WHERE pm_date >= DATE_SUB(NOW(), INTERVAL 7 DAY) GROUP BY pm_date";
    $twofivepast7daysResult = mysqli_query($con, $twofivepast7daysSql);
    $twofivepast7daysData = array();
    while ($row = mysqli_fetch_assoc($twofivepast7daysResult)) {
        $twofivepast7daysData[] = $row;
    }

    // Fetch the past 30 days data
    $twofivepast30daysSql = "SELECT DATE_FORMAT(pm_date, '%m/%d') AS pm_date, MAX(pm_two_five) AS peak_pm_two_five FROM aq_particulate_matter WHERE pm_date >= DATE_SUB(NOW(), INTERVAL 30 DAY) GROUP BY pm_date";
    $twofivepast30daysResult = mysqli_query($con, $twofivepast30daysSql);
    $twofivepast30daysData = array();
    while ($row = mysqli_fetch_assoc($twofivepast30daysResult)) {
        $twofivepast30daysData[] = $row;
    }

    // Fetch the past 12 months data
    $twofivepast12monthsSql = "SELECT DATE_FORMAT(pm_date, '%m/%Y') AS pm_month, MAX(pm_two_five) AS peak_pm_two_five FROM aq_particulate_matter WHERE pm_date >= DATE_SUB(NOW(), INTERVAL 12 MONTH) GROUP BY pm_month";
    $twofivepast12monthsResult = mysqli_query($con, $twofivepast12monthsSql);
    $twofivepast12monthsData = array();
    while ($row = mysqli_fetch_assoc($twofivepast12monthsResult)) {
        $twofivepast12monthsData[] = $row;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>PM Two Five Chart Example</title>
    <link rel="stylesheet" href="../Building Management Head/charts/charts.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <span class="chart-title">General Air Particulate Matter 2.5 Level</span>
    <div class="chart-button">
        <label for="timeRangeTwoFive">Time Range:</label>
        <select id="timeRangeTwoFive" onchange="updateTwoFiveChart()">
            <option value="twofivepast24hours" selected>Past 24 Hours</option>
            <option value="twofivepast7days">Past 7 Days</option>
            <option value="twofivepast30days">Past 30 Days</option>
            <option value="twofivepast12months">Past 12 Months</option>
        </select>
    </div>
    <div class="pm-two-five-chart-group">
        <canvas id="pmTwoFiveChart" class="chart"></canvas>
    </div>

    <script>
        var pmTwoFiveCtx = document.getElementById('pmTwoFiveChart').getContext('2d');
        var pmTwoFiveChart;
        var twofivepast24hoursData = <?php echo json_encode($twofivepast24hoursData); ?>;
        var twofivepast7daysData = <?php echo json_encode($twofivepast7daysData); ?>;
        var twofivepast30daysData = <?php echo json_encode($twofivepast30daysData); ?>;
        var twofivepast12monthsData = <?php echo json_encode($twofivepast12monthsData); ?>;

        function processTwoFiveData(selectedRange, rawData) {
            var processedData = {
                dates: [],
                pmTwoFiveValues: []
            };

            rawData.forEach(function(row) {
                processedData.dates.push(row.pm_datetime || row.pm_date || row.pm_month);
                processedData.pmTwoFiveValues.push(row.peak_pm_two_five);
            });

            return processedData;
        }

        function updateTwoFiveChart() {
            var selectedRange = document.getElementById('timeRangeTwoFive').value;
            var rawData;

            if (selectedRange === 'twofivepast24hours') {
                rawData = twofivepast24hoursData;
            } else if (selectedRange === 'twofivepast7days') {
                rawData = twofivepast7daysData;
            } else if (selectedRange === 'twofivepast30days') {
                rawData = twofivepast30daysData;
            } else if (selectedRange === 'twofivepast12months') {
                rawData = twofivepast12monthsData;
            }

            var data = processTwoFiveData(selectedRange, rawData);

            if (pmTwoFiveChart) {
                pmTwoFiveChart.destroy();
            }

            pmTwoFiveChart = new Chart(pmTwoFiveCtx, {
                type: 'line',
                data: {
                    labels: data.dates,
                    datasets: [{
                        label: 'PM Two Five',
                        data: data.pmTwoFiveValues,
                        borderColor: 'black',
                        borderWidth: 2,
                        backgroundColor: '#E7AE41',
                        fill: 'origin'
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
                                color: 'rgba(0, 0, 0, 1)',
                                borderDash: [5, 5],
                                borderWidth: 1,
                                drawBorder: true,
                                drawOnChartArea: true,
                                drawTicks: true,
                                tickColor: 'rgba(0, 0, 0, 1)',
                                tickLength: 20,
                                lineWidth: 1,
                            },
                        },
                        y: {ticks: {
                            font: {
                            size: 15, // Specify the desired label font size
                                },
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
                            display: true,
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
        updateTwoFiveChart();
    </script>
</body>
</html>
