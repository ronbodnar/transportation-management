<?php

require '../header.php';

?>

<?php if (isLoggedIn()) { ?>
    <?php if (isset($_GET['shipment'])) { ?>
        <div class="container-fluid pt-3">
            <div class="overlay-inner">
                <h3 class="text-light align-self-left fw-bold">Shipments</h3>
            </div>
            <div class="row d-flex align-content-center justify-content-center">
                <div class="col-md-12">
                    <div class="card content d-flex">
                        <div class="card-header">
                            Shipment Details
                            <div class="card-header-search">
                                <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input type="text" class="form-control" name="shipment" id="shipment-search" placeholder="Search shipment id">
                                </form>
                            </div>
                        </div>
                        <div class="card-body justify-content-center table-responsive">
                            <?php
                            $shipment = $database->getShipment($_GET['shipment']);
                            if (!$shipment || $shipment == null) {
                                echo 'No shipment found';
                            } else {
                            ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Shipment ID</th>
                                            <th>Purchase Order</th>
                                            <th>Pallets</th>
                                            <th>Net Weight</th>
                                            <th>Gross Weight</th>
                                            <th>Trailer</th>
                                            <th>Driver</th>
                                            <th>Facility</th>
                                            <th>Drop Location</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <?php
                                            $shipment = $database->getShipment($_GET['shipment']);
                                            $timestamp = $shipment->getTimestamp();

                                            $backgroundColor = '#276E05';
                                            if (strpos($shipment->getStatus(), "LOADING") !== false) {
                                                $backgroundColor = '#E49B0F';
                                            } else if (strpos($shipment->getStatus(), "READY") !== false) {
                                                $backgroundColor = '#3BA608';
                                            } else if (strpos($shipment->getStatus(), "IN_TRANSIT") !== false) {
                                                $backgroundColor = '#DA70D6';
                                            }

                                            echo '<td>' . date("n/j/Y", strtotime($timestamp)) . '</td>';
                                            echo '<td>' . date("g:i a", strtotime($timestamp)) . '</td>';
                                            echo '<td>' . $shipment->getId() . '</td>';
                                            echo '<td>' . $shipment->getOrderNumber() . '</td>';
                                            echo '<td>' . $shipment->getPalletCount() . '</td>';
                                            echo '<td>' . number_format($shipment->getNetWeight()) . '</td>';
                                            echo '<td>' . number_format($shipment->getGrossWeight()) . '</td>';
                                            echo '<td>' . $shipment->getTrailerId() . '</td>';
                                            echo '<td>' . (strlen($shipment->getDriver()->getFullName()) <= 1 ? 'Unassigned' : $shipment->getDriver()->getFullName()) . '</td>';
                                            echo '<td>' . $shipment->getFacility() . '</td>';
                                            echo '<td>' . (rand(0, 20) === 0 ? 'S/B' : 'Door ' . rand(1, 34)) . '</td>';
                                            echo '<td>';
                                            echo '<span class="badge rounded-pill" style="background-color: ' . $backgroundColor . '">' . $shipment->getStatus(true) . '</span>';
                                            echo '</td>';
                                            ?>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php } ?>

                            <?php if ($shipment && $shipment != null) { ?>
                                <div class="row justify-content-center">
                                    <div class="col-md-8" style="max-height: 400px; overflow-y: scroll;">
                                        <table class="table table-sm table-borderless">
                                            <thead>
                                                <tr>
                                                    <th>Product Code</th>
                                                    <th>Description</th>
                                                    <th>Cases</th>
                                                    <th>Batch</th>
                                                    <th>Expiration</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                for ($i = 0; $i < $shipment->getPalletCount(); $i++) {
                                                    echo '<tr>';
                                                    echo '<td>136972</td>';
                                                    echo '<td>HO ORG UP MILK 2% 64OZ 6CT CA</td>';
                                                    echo '<td>80</td>';
                                                    echo '<td>2022.08.14</td>';
                                                    echo '<td>08/14/2022</td>';
                                                    echo '</tr>';
                                                }
                                                ?>
                                                <tr>
                                                    <td>10022066</td>
                                                    <td>CHEP Pallet</td>
                                                    <td><?php echo $shipment->getPalletCount(); ?></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="container-fluid pt-3">
            <div class="overlay-inner">
                <h3 class="text-light align-self-left fw-bold">Shipments</h3>
                <a class="btn create-shipment-button" href="create.php">Create Shipment</a>
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
                                    All Shipments
                                    <div class="dropdown">
                                        <span class="card-header-options" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></span>
                                        <ul class="dropdown-menu text-small shadow">
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-download" style="padding-right: 15px;"></i>Export CSV</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body justify-content-center table-responsive">
                                    <?php
                                    $shipments = $database->getOutboundShipments('ALL');
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
                                                    <th>Facility</th>
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
                                    $shipments = $database->getOutboundShipments(Status::SHIPMENT_READY);
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
                                                    <th>Facility</th>
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
                                    $shipments = $database->getOutboundShipments(Status::SHIPMENT_FORFEITED);
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
                                                    <th>Facility</th>
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
                                    $shipments = $database->getOutboundShipments(Status::SHIPMENT_COMPLETE);
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
                                                    <th>Facility</th>
                                                    <th>Door</th>
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
<?php }
} else {
    include '../login-form.php';
} ?>
</div>

<?php include '../footer.php'; ?>