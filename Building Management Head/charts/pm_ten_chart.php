<?php
    require_once('building_head_connect.php');

    $sqlten = "SELECT aqpm.*, aqs.aq_sensor_room_num, aqs.aq_sensor_name
        FROM aq_particulate_matter aqpm
        JOIN aq_sensor aqs ON aqpm.pm_sensor = aqs.aq_sensor_id";

    $result_table = mysqli_query($con, $sqlten);

    $pmTenData = array();
    while ($row = mysqli_fetch_assoc($result_table)) {
        $pmTenData[] = array(
            'date' => $row['pm_date'],
            'time' => $row['pm_time'],
            'pm_ten' => $row['pm_ten']
        );
    }

    // Fetch the past 24 hours data
    $tenpast24hoursSql = "SELECT DATE_FORMAT(pm_time, '%H:00') AS pm_datetime, MAX(pm_ten) AS peak_pm_ten FROM aq_particulate_matter WHERE pm_date >= DATE_SUB(NOW(), INTERVAL 24 HOUR) GROUP BY pm_datetime";
    $tenpast24hoursResult = mysqli_query($con, $tenpast24hoursSql);
    $tenpast24hoursData = array();
    while ($row = mysqli_fetch_assoc($tenpast24hoursResult)) {
        $tenpast24hoursData[] = $row;
    }

    // Fetch the past 7 days data
    $tenpast7DaysSql = "SELECT DATE_FORMAT(pm_date, '%m/%d') AS pm_date, MAX(pm_ten) AS peak_pm_ten FROM aq_particulate_matter WHERE pm_date >= DATE_SUB(NOW(), INTERVAL 7 DAY) GROUP BY pm_date";
    $tenpast7DaysResult = mysqli_query($con, $tenpast7DaysSql);
    $tenpast7DaysData = array();
    while ($row = mysqli_fetch_assoc($tenpast7DaysResult)) {
        $tenpast7DaysData[] = $row;
    }

    // Fetch the past 30 days data
    $tenpast30DaysSql = "SELECT DATE_FORMAT(pm_date, '%m/%d') AS pm_date, MAX(pm_ten) AS peak_pm_ten FROM aq_particulate_matter WHERE pm_date >= DATE_SUB(NOW(), INTERVAL 30 DAY) GROUP BY pm_date";
    $tenpast30DaysResult = mysqli_query($con, $tenpast30DaysSql);
    $tenpast30DaysData = array();
    while ($row = mysqli_fetch_assoc($tenpast30DaysResult)) {
        $tenpast30DaysData[] = $row;
    }

    // Fetch the past 12 months data
    $tenpast12MonthsSql = "SELECT DATE_FORMAT(pm_date, '%m/%Y') AS pm_month, MAX(pm_ten) AS peak_pm_ten FROM aq_particulate_matter WHERE pm_date >= DATE_SUB(NOW(), INTERVAL 12 MONTH) GROUP BY pm_month";
    $tenpast12MonthsResult = mysqli_query($con, $tenpast12MonthsSql);
    $tenpast12MonthsData = array();
    while ($row = mysqli_fetch_assoc($tenpast12MonthsResult)) {
        $tenpast12MonthsData[] = $row;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>PM Ten Chart Example</title>
    <link rel="stylesheet" href="../Building Management Head/charts/charts.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <span class="chart-title">General Air Particulate Matter 10 Level</span>
    <div class="chart-button">
        <label for="timeRange">Time Range:</label>
        <select id="timeRange" onchange="updateChart()">
            <option value="tenpast24hours" selected>Past 24 Hours</option>
            <option value="tenpast7Days">Past 7 Days</option>
            <option value="tenpast30Days">Past 30 Days</option>
            <option value="tenpast12Months">Past 12 Months</option>
        </select>
    </div>
    <div class="pm-ten-chart-group">
        <canvas id="pmTenChart" class="chart"></canvas>
    </div>

    <script>
        var ctx = document.getElementById('pmTenChart').getContext('2d');
        var chart;
        var tenpast24hoursData = <?php echo json_encode($tenpast24hoursData); ?>;
        var tenpast7DaysData = <?php echo json_encode($tenpast7DaysData); ?>;
        var tenpast30DaysData = <?php echo json_encode($tenpast30DaysData); ?>;
        var tenpast12MonthsData = <?php echo json_encode($tenpast12MonthsData); ?>;

        function processData(selectedRange, rawData) {
            var processedData = {
                dates: [],
                pmTenValues: []
            };

            rawData.forEach(function(row) {
                processedData.dates.push(row.pm_datetime || row.pm_date || row.pm_month);
                processedData.pmTenValues.push(row.peak_pm_ten);
            });

            return processedData;
        }

        function updateChart() {
            var selectedRange = document.getElementById('timeRange').value;
            var rawData;

            if (selectedRange === 'tenpast24hours') {
                rawData = tenpast24hoursData;
            } else if (selectedRange === 'tenpast7Days') {
                rawData = tenpast7DaysData;
            } else if (selectedRange === 'tenpast30Days') {
                rawData = tenpast30DaysData;
            } else if (selectedRange === 'tenpast12Months') {
                rawData = tenpast12MonthsData;
            }

            var data = processData(selectedRange, rawData);

            if (chart) {
                chart.destroy();
            }

            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.dates,
                    datasets: [{
                        label: 'PM Ten',
                        data: data.pmTenValues,
                        borderColor: 'black',
                        borderWidth: 2,
                        backgroundColor: '#E7AE41',
                        fill: 'origin'
                    }]
                },
                options: {
                    scales: {
                        x: {ticks: {
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
                            display: true,
                            title: {
                                display: false,
                                text: selectedRange === 'tenpast24hours' ? 'Time' : 'Date'
                            }
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
                            title: {
                                display: false,
                                text: 'PM Ten'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false,
                            position: 'top'
                        }
                    }
                }
            });
        }
        updateChart();
    </script>
</body>
</html>
