<?php

require '../../header.php';

?>

<?php if (isLoggedIn()) {
    if (isset($_GET['id'])) {
        $driver = $database->userRepository->getUserData($_GET['id']);
?>
        <div class="container-fluid pt-3">
            <div class="overlay-inner">
                <h3 class="text-light align-self-left fw-bold pt-3">Driver Details</h3>
            </div>
            <div class="card content mt-5">
                <div class="card-body table-responsive">

                    <div class="pt-2">
                        <div class="row g-0">
                            <div class="col-sm-1 text-center"><i class="bi bi-person-circle" style="font-size: 3rem;"></i></div>
                            <div class="col-sm-2">
                                <h4 class="fw-bold"><?php echo $driver->getFullName(); ?></h4>
                                <p style="font-size: 1rem;"><?php echo $driver->getAccessRole(); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-between align-items-center pt-4">
                        <div class="col text-center" style="font-size: 0.9rem;">Status</div>
                        <div class="col text-center" style="font-size: 0.9rem;">Phone #</div>
                        <div class="col text-center" style="font-size: 0.9rem;">Company</div>
                    </div>

                    <div class="row d-flex justify-content-between align-items-center pb-4" style="border-bottom: 1px solid var(--separator-line-color);">
                        <div class="col text-center text-success"><span class="badge rounded-pill bg-success">Available</span></div>
                        <div class="col text-center"><?php echo $driver->getPhoneNumber(); ?></div>
                        <div class="col text-center"><a href="" class="text-mron">Northern Refrigerated Transportation</a></div>
                    </div>

                    <div class="pt-3 pb-3">
                        <ul class="nav nav-tabs user-tabs d-flex justify-content-center align-items-center text-center" role="tablist">
                            <li class="nav-item user-tab" role="presentation">
                                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">Overview</button>
                            </li>
                            <li class="nav-item user-tab ps-5" role="presentation">
                                <button class="nav-link" id="activity-logs-tab" data-bs-toggle="tab" data-bs-target="#activity-logs" type="button" role="tab" aria-controls="activity-logs" aria-selected="true">Activity Logs</button>
                            </li>
                            <li class="nav-item user-tab px-5" role="presentation">
                                <button class="nav-link" id="shipments-tab" data-bs-toggle="tab" data-bs-target="#shipments" type="button" role="tab" aria-controls="shipments" aria-selected="false">Shipments</button>
                            </li>
                            <li class="nav-item user-tab" role="presentation">
                                <button class="nav-link" id="flagged-tab" data-bs-toggle="tab" data-bs-target="#flagged" type="button" role="tab" aria-controls="flagged" aria-selected="false">Flagged</button>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                            <div class="row pt-2">
                                <?php
                                $shipmentCount       = $database->shipmentRepository->getOutboundShipmentCountByDriverId($driver->getId());
                                $backhaulCount       = rand(10, 25);
                                $yardMoveCount       = $database->driverRepository->getYardMovesByDriverId($driver->getId());
                                $flaggedLogCount     = $database->driverRepository->getFlaggedActivityLogsByDriverId($driver->getId());
                                $unplannedStopCount  = rand(15, 50);
                                $truckBreakdownCount = rand(15, 50);
                                ?>
                                <div class="col-md-6" style="border-right: 2px solid var(--separator-line-color);">
                                    <p class="fw-bold fs-5 text-center">Daily Averages</p>
                                    <div class="row pt-2 d-flex justify-content-around align-items-center">
                                        <div class="col-md-5 pt-2 pb-2 fw-bold" style="font-size: 0.9rem;">Shipments</div>
                                        <div class="col-md-5 pt-2 pb-2 fw-bold" style="font-size: 0.9rem;">Backhauls</div>
                                        <div class="col-md-5 pb-3" id="averageShipments" style="border-bottom: 1px solid var(--separator-line-color);"><?php echo number_format(($shipmentCount / 16), 2); ?></div>
                                        <div class="col-md-5 pb-3" id="averageBackhauls" style="border-bottom: 1px solid var(--separator-line-color);"><?php echo number_format(($backhaulCount / 16), 2); ?></div>

                                        <div class="col-md-5 fw-bold pb-2 pt-2" style="font-size: 0.9rem;">Yard Moves</div>
                                        <div class="col-md-5 fw-bold pb-2 pt-2" style="font-size: 0.9rem;">Active Hours</div>
                                        <div class="col-md-5 pb-3" id="averageYardMoves" style="border-bottom: 1px solid var(--separator-line-color);"><?php echo number_format(($yardMoveCount / 16), 2); ?></div>
                                        <div class="col-md-5 pb-3" id="averageShiftTime" style="border-bottom: 1px solid var(--separator-line-color);">11h <?php echo rand(1, 59); ?>m</div>

                                        <div class="col-md-5 fw-bold pb-2 pt-2" style="font-size: 0.9rem;">Time Completing Instructions</div>
                                        <div class="col-md-5 fw-bold pb-2 pt-2" style="font-size: 0.9rem;">Unplanned Stops</div>
                                        <div class="col-md-5 pb-3" id="averageInstructionTime" style="border-bottom: 1px solid var(--separator-line-color);"><?php echo rand(15, 59); ?>m</div>
                                        <div class="col-md-5 pb-3" id="averageUnplannedStops" style="border-bottom: 1px solid var(--separator-line-color);"><?php echo number_format(($unplannedStopCount / 16), 2); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p class="fw-bold fs-5 text-center">Lifetime</p>
                                    <div class="row pt-2 d-flex justify-content-center">
                                        <div class="col-md-5 pt-2 pb-2 fw-bold" style="font-size: 0.9rem;">Shipments</div>
                                        <div class="col-md-5 pt-2 pb-2 fw-bold" style="font-size: 0.9rem;">Backhauls</div>
                                        <div class="col-md-5 pb-3" id="averageShipments" style="border-bottom: 1px solid var(--separator-line-color);"><?php echo $database->shipmentRepository->getOutboundShipmentCountByDriverId($driver->getId()); ?></div>
                                        <div class="col-md-5 pb-3" id="averageBackhauls" style="border-bottom: 1px solid var(--separator-line-color);"><?php echo rand(10, 25); ?></div>

                                        <div class="col-md-5 fw-bold pb-2 pt-2" style="font-size: 0.9rem;">Yard Moves</div>
                                        <div class="col-md-5 fw-bold pb-2 pt-2" style="font-size: 0.9rem;">Flagged Logs</div>
                                        <div class="col-md-5 pb-3" id="averageYardMoves" style="border-bottom: 1px solid var(--separator-line-color);"><?php echo $database->driverRepository->getYardMovesByDriverId($driver->getId()); ?></div>
                                        <div class="col-md-5 pb-3" id="averageShiftTime" style="border-bottom: 1px solid var(--separator-line-color);"><?php echo $database->driverRepository->getFlaggedActivityLogsByDriverId($driver->getId()); ?></div>

                                        <div class="col-md-5 fw-bold pb-2 pt-2" style="font-size: 0.9rem;">Unplanned Stops</div>
                                        <div class="col-md-5 fw-bold pb-2 pt-2" style="font-size: 0.9rem;">Truck Breakdowns</div>
                                        <div class="col-md-5 pb-3" id="averageInstructionTime" style="border-bottom: 1px solid var(--separator-line-color);"><?php echo rand(15, 50); ?></div>
                                        <div class="col-md-5 pb-3" id="averageUnplannedStops" style="border-bottom: 1px solid var(--separator-line-color);"><?php echo rand(1, 10); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="activity-logs" role="tabpanel" aria-labelledby="activity-logs-tab">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped" id="driverPersonalActivityLogTable" class="display" style="width:100%">
                                    <thead>
                                        <!--<tr>
                                    <th></th>
                                    <th>Date</th>
                                    <th class="text-center">Schedule</th>
                                    <th class="text-center">Clock-in Time</th>
                                    <th class="text-center">Clock-out Time</th>
                                    <th class="text-center">Shipments</th>
                                    <th class="text-center">Backhauls</th>
                                    <th class="text-center">Yard Moves</th>
                                    <th class="text-center">Unplanned Stops</th>
                                </tr>-->
                                        <tr>
                                            <th>Date</th>
                                            <th>Location</th>
                                            <th>Arrival Time</th>
                                            <th>Instructions Received</th>
                                            <th>Instructions Accepted</th>
                                            <th>Departure Time</th>
                                            <th>Reason</th>
                                            <th>Trailer</th>
                                            <th>Yard Moves</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="shipments" role="tabpanel" aria-labelledby="shipments-tab">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped" id="driverCompletedShipmentsTable">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Reference</th>
                                            <th>Purchase Order</th>
                                            <th>Pallets</th>
                                            <th>Net Weight</th>
                                            <th>Gross Weight</th>
                                            <th>Trailer</th>
                                            <th>Warehouse</th>
                                            <th>Drop Location</th>
                                            <th>Images</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="flagged" role="tabpanel" aria-labelledby="flagged-tab">
                            <table class="table table-sm table-striped" id="driverPersonalFlaggedActivityLogTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Location</th>
                                        <th>Arrival Time</th>
                                        <th>Instructions Received</th>
                                        <th>Instructions Accepted</th>
                                        <th>Departure Time</th>
                                        <th>Reason</th>
                                        <th>Trailer</th>
                                        <th>Yard Moves</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="container-fluid pt-3">
                <div class="overlay-inner">
                    <h3 class="text-light align-self-left fw-bold">Driver List</h3>
                </div>
                <div class="shipment-tabs">
                    <div class="col-md-6">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">All Drivers</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab" aria-controls="active" aria-selected="false">Active Drivers</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="all-tab">
                        <div class="row d-flex align-content-center justify-content-center">
                            <div class="col-md-12">
                                <div class="card content d-flex">
                                    <div class="card-header">
                                        All Drivers
                                    </div>
                                    <div class="card-body justify-content-center table-responsive">
                                        <?php
                                        $shipments = $database->shipmentRepository->getInboundShipments(1);
                                        if (!$shipments || $shipments == null) {
                                            echo 'No shipments found';
                                        } else {
                                        ?>
                                            <table class="table table-sm table-striped" id="allDriverTable">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                        <div class="row d-flex align-content-center justify-content-center">
                            <div class="col-md-12">
                                <div class="card content d-flex">
                                    <div class="card-header">
                                        Active Drivers (<?php echo $database->driverRepository->getActiveDriverCount(); ?>)
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table class="table table-striped" id="activeDriverTable" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Name</th>
                                                    <th>Start Time</th>
                                                    <th>Location</th>
                                                    <th>Shipment</th>
                                                    <th>Status</th>
                                                    <th>Last Update</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php }
} else {
    include '../login-form.php';
} ?>

    <?php include '../../footer.php'; ?>