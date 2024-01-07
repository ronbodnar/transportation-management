<?php

require '../../../header.php';

?>

<?php if (isLoggedIn()) { ?>
    <div class="container-fluid pt-3">
        <div class="overlay-inner">
            <h3 class="text-light align-self-left fw-bold">Inbound Shipments</h3>
        </div>

        <div class="shipment-tabs">
            <div class="col-md-6">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="in-transit-tab" data-bs-toggle="tab" data-bs-target="#in-transit" type="button" role="tab" aria-controls="all" aria-selected="true">In-Transit Shipments</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="received-tab" data-bs-toggle="tab" data-bs-target="#received" type="button" role="tab" aria-controls="awaiting" aria-selected="false">Received Shipments</button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="in-transit" role="tabpanel" aria-labelledby="in-transit-tab">
                <div class="row d-flex align-content-center justify-content-center">
                    <div class="col-md-12">
                        <div class="card content d-flex">
                            <div class="card-header">
                                In-Transit Shipments
                                <div class="dropdown">
                                    <span class="card-header-options" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></span>
                                    <ul class="dropdown-menu text-small shadow">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-download" style="padding-right: 15px;"></i>Export CSV</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body justify-content-center table-responsive">
                                <?php
                                $shipments = $database->getInboundShipments(1);
                                if (!$shipments || $shipments == null) {
                                    echo 'No shipments found';
                                } else {
                                ?>
                                    <table class="table table-sm table-striped" id="inTransitInboundShipmentsTable">
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
                                                <th>Driver</th>
                                                <th>Carrier</th>
                                                <th>Images</th>
                                            </tr>
                                        </thead>
                                    </table>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="received" role="tabpanel" aria-labelledby="received-tab">
                <div class="row d-flex align-content-center justify-content-center">
                    <div class="col-md-12">
                        <div class="card content d-flex">
                            <div class="card-header">
                                Received Shipments
                                <div class="dropdown">
                                    <span class="card-header-options" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></span>
                                    <ul class="dropdown-menu text-small shadow">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-download" style="padding-right: 15px;"></i>Export CSV</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body justify-content-center table-responsive">
                                <?php
                                $shipments = $database->getInboundShipments(2);
                                if (!$shipments || $shipments == null) {
                                    echo 'No shipments found';
                                } else {
                                ?>
                                    <table class="table table-sm table-striped" id="receivedInboundShipmentsTable">
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
                                                <th>Driver</th>
                                                <th>Carrier</th>
                                                <th>Images</th>
                                            </tr>
                                        </thead>
                                    </table>
                                <?php } ?>
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
</div>

<?php include '../../../footer.php'; ?>