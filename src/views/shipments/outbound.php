<?php

require '../../header.php';

?>

<?php if (isLoggedIn()) { ?>
    <div class="container-fluid pt-3">
        <div class="overlay-inner">
            <h3 class="text-light align-self-left fw-bold">Outbound Shipments</h3>
            <a class="btn create-shipment-button" href="create">Create Shipment</a>
        </div>

        <div class="shipment-tabs rowz d-flexz justify-content-centerz">
            <div class="col-md-6">
                <ul class="nav nav-tabs d-flexz justify-content-centerz" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="all-shipments-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">All Shipments</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="awaiting-shipment-tab" data-bs-toggle="tab" data-bs-target="#awaiting" type="button" role="tab" aria-controls="awaiting" aria-selected="false">Awaiting Shipment</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="forfeited-shipments-tab" data-bs-toggle="tab" data-bs-target="#forfeited" type="button" role="tab" aria-controls="forfeited" aria-selected="false">Forfeited Shipments</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="completed-shipments-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab" aria-controls="completed" aria-selected="false">Completed Shipments</button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-shipments-tab">
                <div class="row d-flex align-content-center justify-content-center">
                    <div class="col-md-12">
                        <div class="card content d-flex">
                            <div class="card-header">
                                All Outbound Shipments
                                <div class="dropdown">
                                    <span class="card-header-options" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></span>
                                    <ul class="dropdown-menu text-small shadow">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-download" style="padding-right: 15px;"></i>Export CSV</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body justify-content-center table-responsive">
                                <?php
                                $shipments = $database->shipmentRepository->getOutboundShipments('ALL');
                                if (!$shipments || $shipments == null) {
                                    echo 'No shipments found';
                                } else {
                                ?>
                                    <table class="table table-sm table-striped" id="allShipmentsTable">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Shipment ID</th>
                                                <th>Purchase Order</th>
                                                <th>Pallets</th>
                                                <th>Net Weight</th>
                                                <th>Gross Weight</th>
                                                <th>Trailer</th>
                                                <th>Driver</th>
                                                <th>Warehouse</th>
                                                <th>Images</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                    </table>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="awaiting" role="tabpanel" aria-labelledby="awaiting-shipment-tab">
                <div class="row d-flex align-content-center justify-content-center">
                    <div class="col-md-12">
                        <div class="card content d-flex">
                            <div class="card-header">
                                Awaiting Shipment
                                <div class="dropdown">
                                    <span class="card-header-options" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></span>
                                    <ul class="dropdown-menu text-small shadow">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-download" style="padding-right: 15px;"></i>Export CSV</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body justify-content-center table-responsive">
                                <?php
                                $shipments = $database->shipmentRepository->getOutboundShipments(3);
                                if (!$shipments || $shipments == null) {
                                    echo 'No shipments found';
                                } else {
                                ?>
                                    <table class="table table-sm table-striped" id="awaitingShipmentTable">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Shipment ID</th>
                                                <th>Purchase Order</th>
                                                <th>Pallets</th>
                                                <th>Net Weight</th>
                                                <th>Gross Weight</th>
                                                <th>Trailer</th>
                                                <th>Driver</th>
                                                <th>Warehouse</th>
                                            </tr>
                                        </thead>
                                    </table>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show" id="forfeited" role="tabpanel" aria-labelledby="forfeited-shipments-tab">
                <div class="row d-flex align-content-center justify-content-center">
                    <div class="col-md-12">
                        <div class="card content d-flex">
                            <div class="card-header">
                                Forfeited Shipments
                                <div class="dropdown">
                                    <span class="card-header-options" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></span>
                                    <ul class="dropdown-menu text-small shadow">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-download" style="padding-right: 15px;"></i>Export CSV</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body justify-content-center table-responsive">
                                <?php
                                $shipments = $database->shipmentRepository->getOutboundShipments(6);
                                if (!$shipments || $shipments == null) {
                                    echo 'No shipments found';
                                } else {
                                ?>
                                    <table class="table table-sm table-striped" id="forfeitedShipmentsTable">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Shipment ID</th>
                                                <th>Purchase Order</th>
                                                <th>Pallets</th>
                                                <th>Net Weight</th>
                                                <th>Gross Weight</th>
                                                <th>Trailer</th>
                                                <th>Forfeited By</th>
                                                <th>Warehouse</th>
                                                <th>Images</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show" id="completed" role="tabpanel" aria-labelledby="completed-shipments-tab">
                <div class="row d-flex align-content-center justify-content-center">
                    <div class="col-md-12">
                        <div class="card content d-flex">
                            <div class="card-header">
                                Completed Shipments
                                <div class="dropdown">
                                    <span class="card-header-options" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></span>
                                    <ul class="dropdown-menu text-small shadow">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-download" style="padding-right: 15px;"></i>Export CSV</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body justify-content-center table-responsive">
                                <?php
                                $shipments = $database->shipmentRepository->getOutboundShipments(5);
                                if (!$shipments || $shipments == null) {
                                    echo 'No shipments found';
                                } else {
                                ?>
                                    <table class="table table-sm table-striped" id="completedShipmentsTable">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Shipment ID</th>
                                                <th>Purchase Order</th>
                                                <th>Pallets</th>
                                                <th>Net Weight</th>
                                                <th>Gross Weight</th>
                                                <th>Trailer</th>
                                                <th>Driver</th>
                                                <th>Warehouse</th>
                                                <th>Drop Location</th>
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

<?php include '../../footer.php'; ?>