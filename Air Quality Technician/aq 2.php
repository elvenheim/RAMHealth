                <nav class="card-header-indicator-second">
                </nav>

                <a class = "card-title-second">
                    <span>
                        Air Quality Sensors
                    </span>
                </a>

                <table class = "air-quality-sensors-table">
                    <thead>
                        <tr>
                            <th class = "delete-column"></th>
                            <th>Room Number</th>
                            <th>Sensor ID</th>
                            <th>Sensor Type</th>
                            <th>Date Added</th>
                            <th>Status</th>
                            <th>Date of Update</th>
                        </tr>
                    </thead>
                    <tbody id = "table-body">
                        <!-- <?php include 'air_technician_parameter_table.php'; ?> -->
                    </tbody>
                </table>

                <div id="addroom-popup" class = "popup">
                        <span class = "add-title"> 
                            AQ Sensor Panel
                        </span>
                        <div class = "popup-line">
                        </div>
                        <form id="add-room" method="POST" class="user-input" action="housekeep_fetch_input.php">
                        
                        <label for="building_floor">Building Floor:</label>
                        <input type="number" id="building-floor" name="building-floor" required><br>

                        <label for="room-number">Room Number:</label>
                        <input type="text" id="room-number" name="room-number" required><br>
                    
                        <label for="room-name">Sensor Type:</label>
                        <input type="text" id="room-name" name="room-name" required><br>

                        <label for="room-type">Sensor Name:</label>
                        <input type="text" id="room-type" name="room-type" required><br>

                        <button class="save-details" type="submit">Add Room</button>
                        </form>
                </div>