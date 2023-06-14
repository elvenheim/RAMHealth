<?php require_once('energy_technician_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>RAM Health</title>
	<link rel="stylesheet" href="../Energy Consumption Technician/EC Tech Design/energy_technician.css">
	<link rel="stylesheet" href="../Energy Consumption Technician/EC Tech Design/Sensors/ec_content_sensors.css">
	<link rel="shortcut icon" href="../favicons/favicon.ico" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">
    <script src="../Energy Consumption Technician/scripts/energy_technician.js"></script>
	<script src="../Energy Consumption Technician/scripts/ec_sensor_table_sort.js"></script>
</head>

<body class="ec-technician-main">
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
	<!-- Energy Technician Table -->
	<div class="content">
		<nav class="card-header">
			<nav id="param-header" class="card-header-indicator"></nav>
			<a href="energy_technician.php" class="card-title">
				<span>Parameter Tables</span>
			</a>
			<nav id="sensor-header" class="card-header-indicator-second"></nav>
			<a href="energy_technician_sensor_main.php" class="card-title-second">
				<span>Sensors</span>
			</a>
			<nav id="deleted-sensor-header" class="card-header-indicator-third"></nav>
			<a href="energy_technician_deleted_sensor_main.php" class="card-title-third">
				<span>Deleted Sensors</span>
			</a>
		</nav>
		<div id="sensor-table" class="content-sensor">
			<div class="card">
				<!-- add room pop-up -->
				<div id="adduser-popup" class = "popup" style="opacity: 0; pointer-events: none;">
					<span class = "add-title"> 
						Add Sensor
					</span>
					<span class = "close-popup"> 
						<i id="close-btn" class= "fas fa-x fa-xl close-btn"></i>
					</span>
					<div class = "popup-line">
					</div>
					<form id="add_user" method="POST" class="user-input" action="ec_sensor_fetch_input.php">
						<?php include 'input_panel_group.php'?>
						<?php include 'input_panel_label.php'?>
						<?php include 'input_floor.php'?>
						<?php include 'input_room.php'?>
						<label for="arduino_id">Arduino ID:</label>
						<input type="text" id="arduino_id" name="arduino_id" required><br>
						<label for="sensor_id">Sensor ID:</label>
						<input type="text" id="sensor_id" name="sensor_id" required><br>
						<?php include 'input_sensor.php'?>
						<button class="save-details" type="submit">Add Sensor</button>
					</form>
				</div>
					<div id="adduser-popup-bg" class = "popup-bg" style="opacity: 0; pointer-events: none;">
					</div>
				<div class="table-button">
					<button id="adduser-btn" class="add-user" onclick="adduser_popup()"><span class="fas fa-plus"></span> Add Sensor</button>
					<button class="refresh-table" onclick="location.reload()"><span class="fas fa-arrows-rotate"></span> Refresh</button>                     
				</div>
				<table class="energy-sensors-table">
					<thead>
						<tr>
							<th><a href="#arrange-panel-group" onclick="sortECSensorTable(0)">Panel Grouping<span class="sort-indicator">&#x25BC</span></a></th>
							<th><a href="#arrange-panel-label" onclick="sortECSensorTable(1)">Panel Label<span class="sort-indicator">&#x25BC</span></a></th>
							<th><a href="#arrange-floor" onclick="sortECSensorTable(2)">Floor<span class="sort-indicator">&#x25BC</span></a></th>
							<th><a href="#arrange-room" onclick="sortECSensorTable(3)">Room<span class="sort-indicator">&#x25BC</span></a></th>
							<th><a href="#arrange-arduino-id" onclick="sortECSensorTable(4)">Arduino ID<span class="sort-indicator">&#x25BC</span></a></th>				
							<th><a href="#arrange-sensor-id" onclick="sortECSensorTable(5)">Sensor ID<span class="sort-indicator">&#x25BC</span></a></th>
							<th><a href="#arrange-sensor-type" onclick="sortECSensorTable(6)">Sensor Type<span class="sort-indicator">&#x25BC</span></a></th>
							<th><a href="#arrange-date-added" onclick="sortECSensorTable(7)">Date Added<span class="sort-indicator">&#x25BC</span></a></th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody id="table-body-sensor">
						<?php include '../Energy Consumption Technician/tables/sensors/energy_technician_sensor_table.php'; ?>
					</tbody>
				</table>
				<?php include '../Energy Consumption Technician/EC Tech Design/Pagination/ec_tech_sensor_pagination.php'; ?>
			</div>
        </div>
	</div>
</body>
</html>