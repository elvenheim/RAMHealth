<?php require_once('air_technician_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>RAM Health</title>
	<link rel="stylesheet" href="../Air Quality Technician/AQ Tech Design/air_technician.css">
	<link rel="stylesheet" href="../Air Quality Technician/AQ Tech Design/Parameters/aq_content_gas.css">
	<link rel="shortcut icon" href="../favicons/favicon.ico" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">
	<script src="../Air Quality Technician/air_technician.js"></script>
</head>

<body class="aq-technician-main">
	<nav class="navbar">
		<div class="ram-health-logo">
			<div class="ram-health-title" onclick="location.href='../Home/homepage.php';">
				RAM Health
			</div>
		</div>
		<span id="log_out_dropdown" name="log_out_dropdown" class="log-out-symbol fas fa-power-off"
			onselectstart="return false;" onclick="collapse_logout()">
		</span>
	</nav>
	<ul id="btn_logout" class="log-out" style="display: none;">
		<form id="logout" name="logout-form" method="post" action="../Login/session_logout.php">
			<button class="logout-button" type="submit" name="logout">
				<span class="fas fa-power-off"></span>
				Logout
			</button>
		</form>
	</ul>
	<!-- For the Main Interface Contents -->
	<!-- Air Technician Table -->
	<div class="content">
		<nav class="card-header">
			<nav id="param-header" class="card-header-indicator"></nav>
			<a href="air_technician.php" class="card-title">
				<span> Parameter Tables </span>
			</a>
			<nav id="sensor-header" class="card-header-indicator-second"></nav>
			<a href="air_technician_sensor_main.php" class="card-title-second">
				<span> Sensors </span>
			</a>
			<nav id="deleted-sensor-header" class="card-header-indicator-third"></nav>
			<a href="air_technician_deleted_sensor_main.php" class="card-title-third">
				<span> Deleted Sensors </span>
			</a>
		</nav>
		<div id="param-table" class="content-parameter">
			<div class="card">
				<div class="table-button-group">
					<div class="parameter-table-button">
						<button id="gas-level-button" class="dropbtn"
							onclick="location.href='air_tech_general_param_main.php';">Air Quality Table</button>
					</div>
					<div class="parameter-table-button">
						<button id="air-particulate-button" class="dropbtn"
							onclick="location.href='air_tech_particulate_matter_main.php';">Air Particulate Matter</button>
					</div>
					<div class="parameter-table-button">
						<button id="gas-level-button" class="dropbtn"
							onclick="location.href='air_tech_gas_main.php';">Gas Level</button>
					</div>
					<div class="parameter-table-button">
						<button id="indoor-temperature-button" class="dropbtn"
							onclick="location.href='air_tech_indoor_temp_main.php';">Indoor Temperature</button>
					</div>
					<div class="parameter-table-button">
						<button id="outdoor-temperature-button" class="dropbtn"
							onclick="location.href='air_tech_outdoor_temp_main.php';">Outdoor Temperature</button>
					</div>
					<div class="parameter-table-button">
						<button id="relative-humidity-button" class="dropbtn"
							onclick="location.href='air_tech_relative_humidity_main.php';">Relative Humidity</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>