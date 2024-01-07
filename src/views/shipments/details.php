<?php require '../../header.php'; ?>

<?php
    $shipment = $database->shipmentRepository->getShipment($_GET['id']);
    if ($shipment == null || !$shipment) {
        $shipment = $database->shipmentRepository->getInboundShipment($_GET['id']);
    }
?>
<div class="container-fluid pt-3">
    <div class="overlay-inner">
        <h3 class="text-light align-self-left fw-bold pt-3">Shipment Details</h3>
    </div>

    <div class="card content mt-5">
        <div class="card-header-options-no-header">
            <a href="/src/views/shipments/edit.php?id=<?php echo $shipment->getId(); ?>" class="btn btn-sm btn-secondary mt-2" disabled><i class="bi bi-pencil"></i> Edit Shipment</a>
        </div>

        <div class="card-body table-responsive">
            <?php
            if ($shipment == null || !$shipment) {
                echo '<h1 class="text-center pt-3">Shipment not found</h1>';
            } else {
                $backgroundColor = '#276E05';
                if (strpos($shipment->getStatus(), "LOADING") !== false) {
                    $backgroundColor = '#E49B0F';
                } else if (strpos($shipment->getStatus(), "READY") !== false) {
                    $backgroundColor = '#3BA608';
                } else if (strpos($shipment->getStatus(), "IN_TRANSIT") !== false) {
                    $backgroundColor = '#DA70D6';
                } ?>
                <div class="pt-2">
                    <div class="row g-0">
                        <div class="col-sm-1 text-center"><i class="bi bi-truck" style="font-size: 3rem;"></i></div>
                        <div class="col-sm-2">
                            <h4 class="fw-bold"><?php echo ($shipment == null || !$shipment ? "-" : $shipment->getId()); ?> </h4>
                            <p style="font-size: 1rem;">SHIPMENT</p>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-between align-items-center pt-1">
                    <div class="col text-center" style="font-size: 0.9rem;">Status</div>
                    <div class="col text-center" style="font-size: 0.9rem;">Date Created</div>
                    <div class="col text-center" style="font-size: 0.9rem;">Time Created</div>
                    <div class="col text-center" style="font-size: 0.9rem;">Shipment ID</div>
                    <div class="col text-center" style="font-size: 0.9rem;">Purchase Order</div>
                    <div class="col text-center" style="font-size: 0.9rem;">Warehouse</div>
                </div>

                <div class="row d-flex justify-content-between align-items-center pb-4" style="border-bottom: 1px solid var(--separator-line-color);">
                    <div class="col text-center text-success"><span class="badge rounded-pill" style="background: <?php echo $backgroundColor; ?>;"><?php echo $shipment->getStatus(); ?></span></div>
                    <div class="col text-center"><?php echo date("n/j/Y", strtotime($shipment->getTimestamp())); ?></div>
                    <div class="col text-center"><?php echo date("g:i A", strtotime($shipment->getTimestamp())); ?></div>
                    <div class="col text-center"><?php echo $shipment->getId(); ?></div>
                    <div class="col text-center"><?php echo $shipment->getOrderNumber(); ?></div>
                    <div class="col text-center"><?php echo $shipment->getFacility(); ?></div>
                </div>

                <div class="pt-3 pb-3">
                    <ul class="nav nav-tabs user-tabs shipment-tabs d-flex justify-content-center align-items-center text-center" role="tablist">
                        <li class="nav-item user-tab" role="presentation">
                            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">Overview</button>
                        </li>
                        <li class="nav-item user-tab ps-5" role="presentation">
                            <button class="nav-link" id="activity-logs-tab" data-bs-toggle="tab" data-bs-target="#activity-logs" type="button" role="tab" aria-controls="activity-logs" aria-selected="true">Product List</button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                        <div class="row pt-2 d-flex justify-content-center">
                            <div class="col-md-10">
                                <p class="fw-bold fs-5 text-center">Shipment Information</p>
                                <div class="row pt-2 pb-3 d-flex justify-content-around align-items-center">
                                    <div class="col-md-3 offset-md-1 pt-2 pb-2 fw-bold" style="font-size: 0.9rem;">Date Delivered</div>
                                    <div class="col-md-3 offset-md-1 pt-2 pb-2 fw-bold" style="font-size: 0.9rem;">Time Delivered</div>
                                    <div class="col-md-3 offset-md-1 fw-bold pb-2 pt-2" style="font-size: 0.9rem;">Drop Location</div>
                                    <div class="col-md-3 offset-md-1 pb-2" id="averageShipments" style="border-bottom: 1px solid var(--separator-line-color);"><?php echo date("n/j/Y", strtotime($shipment->getTimestamp() . ' + ' . rand(0, 2) . ' days')); ?></div>
                                    <div class="col-md-3 offset-md-1 pb-2" id="averageBackhauls" style="border-bottom: 1px solid var(--separator-line-color);"><?php echo date("g:i A", strtotime($shipment->getTimestamp() . ' + ' . rand(2, 600) . ' minutes')); ?></div>
                                    <div class="col-md-3 offset-md-1 pb-2" id="averageUnplannedStops" style="border-bottom: 1px solid var(--separator-line-color);"><?php echo ($shipment->getDropLocation() == 0 ? '-' : ($shipment->getDropLocation() == 100 ? 'Yard' : 'Door ' . $shipment->getDropLocation())) ?></div>

                                    <div class="col-md-3 offset-md-1 fw-bold pb-2 pt-2" style="font-size: 0.9rem;">Pallets</div>
                                    <div class="col-md-3 offset-md-1 fw-bold pb-2 pt-2" style="font-size: 0.9rem;">Net Weight</div>
                                    <div class="col-md-3 offset-md-1 fw-bold pb-2 pt-2" style="font-size: 0.9rem;">Product Quantity</div>
                                    <div class="col-md-3 offset-md-1 pb-2" id="averageYardMoves" style="border-bottom: 1px solid var(--separator-line-color);"><?php echo $shipment->getPalletCount(); ?></div>
                                    <div class="col-md-3 offset-md-1 pb-2" id="averageShiftTime" style="border-bottom: 1px solid var(--separator-line-color);"><?php echo number_format($shipment->getNetWeight()); ?> lbs</div>
                                    <div class="col-md-3 offset-md-1 pb-2" id="averageShiftTime" style="border-bottom: 1px solid var(--separator-line-color);">30,492</div>

                                    <div class="col-md-3 offset-md-1 fw-bold pb-2 pt-2" style="font-size: 0.9rem;">Trailer Number</div>
                                    <div class="col-md-3 offset-md-1 fw-bold pb-2 pt-2" style="font-size: 0.9rem;">Driver</div>
                                    <div class="col-md-3 offset-md-1 fw-bold pb-2 pt-2" style="font-size: 0.9rem;">Carrier</div>
                                    <div class="col-md-3 offset-md-1 pb-2" id="averageShiftTime" style="border-bottom: 1px solid var(--separator-line-color);"><?php echo $shipment->getTrailerId(); ?></div>
                                    <div class="col-md-3 offset-md-1 pb-2" id="averageInstructionTime" style="border-bottom: 1px solid var(--separator-line-color);"><?php echo (strlen($shipment->getDriver()->getFullName()) <= 1 ? 'Unassigned' : '<a href="/src/views/drivers/details.php?id=' . $shipment->getDriver()->getId() . '" class="text-mron">' . $shipment->getDriver()->getFullName() . '</a>'); ?></div>
                                    <div class="col-md-3 offset-md-1 pb-2" id="averageInstructionTime" style="border-bottom: 1px solid var(--separator-line-color);"><?php echo $shipment->getCarrier(); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="activity-logs" role="tabpanel" aria-labelledby="activity-logs-tab">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped" id="shipmentProductListTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Product Code</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Batch</th>
                                        <th>Expiration</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php include '../../footer.php'; ?>