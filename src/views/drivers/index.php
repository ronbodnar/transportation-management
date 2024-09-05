<?php

require '../../header.php';

?>

<?php if (isLoggedIn()) { ?>
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
<?php
} else {
    include '../login-form.php';
} ?>

<?php include '../../footer.php'; ?>