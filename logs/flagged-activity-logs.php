<?php

require '../header.php';

?>

<?php if (isLoggedIn()) { ?>
    <div class="container-fluid pt-3">
        <div class="overlay-inner">
            <h3 class="text-light align-self-left fw-bold">Flagged Activity Logs</h3>
        </div>
        <div class="row d-flex justify-content-center">
            <!--<div class="col-md-3">
                <div class="card content">
                    <div class="card-header">
                        Driver Select
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 100px;">
                        <div class="dropdown">
                            <button type="button" class="btn btn-secondary dropdown-toggle" role="button" id="allDriversDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Select a driver...
                            </button>

                            <ul class="dropdown-menu" id="allDriversDropdown">
                                <li>
                                    <button type="button" class="dropdown-item" id="all">All Drivers</button>
                                </li>
                                <?php
                                /*$allDrivers = $database->getAllDrivers();

                                foreach ($allDrivers as $driver) {
                                    echo '<li><button type="button" class="dropdown-item" id="' . $driver->getFullName() . '">';
                                    echo $driver->getFullName();
                                    echo '</button></li>';
                                }*/
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="driverAverages" class="col-md-8" style="display: none;">
                <div class="card content">
                    <div class="card-header">
                        Flagged Log Statistics
                    </div>
                    <div class="card-body" style="min-height: 100px;">
                        <div class="row pt-2">
                            <div class="col-md-2 text-center" id="averageShipments">0</div>
                            <div class="col-md-2 text-center" id="averageBackhauls">0</div>
                            <div class="col-md-2 text-center" id="averageYardMoves">0</div>
                            <div class="col-md-2 text-center" id="averageShiftTime">0</div>
                            <div class="col-md-2 text-center" id="averageInstructionTime">0</div>
                            <div class="col-md-2 text-center" id="averageUnplannedStops">0</div>
                            <div class="col-md-2 text-center pt-2 fw-bold">Total Flagged Logs</div>
                            <div class="col-md-2 text-center pt-2 fw-bold">Daily Flagged Logs</div>
                            <div class="col-md-2 text-center pt-2 fw-bold">Yard Moves</div>
                            <div class="col-md-2 text-center pt-2 fw-bold">Shift Time</div>
                            <div class="col-md-2 text-center pt-2 fw-bold">Instruction Time</div>
                            <div class="col-md-2 text-center pt-2 fw-bold">Unplanned Stops</div>
                        </div>
                    </div>
                </div>
            </div>-->
            <div class="col-md-11" id="driverActivityLogs">
                <div class="card content">
                    <div class="card-header">
                        <span class="card-header-options"></span>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped" id="flaggedActivityLogsTable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Driver</th>
                                    <th>Location</th>
                                    <th>Reason</th>
                                    <th>Arrival Time</th>
                                    <th>Instructions Received</th>
                                    <th>Instructions Accepted</th>
                                    <th>Departure Time</th>
                                    <th class="text-center">Yard Moves</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else {
    include '../login-form.php';
} ?>

<?php include '../footer.php'; ?>