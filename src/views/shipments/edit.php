<?php

require '../../../header.php';

?>

<?php if (isLoggedIn()) {
    $shipment = $database->getShipment($_GET['id']);
    if ($shipment == null || !$shipment) {
        $shipment = $database->getInboundShipment($_GET['id']);
    }
?>
    <div class="container-fluid pt-3">
        <div class="overlay-inner">
            <h3 class="text-light align-self-left fw-bold pt-3">Edit Shipment</h3>
        </div>

        <div class="card content mt-5">
            <div class="card-body table-responsive">
                <h4 class="text-center pt-2">Editing Shipment: <?php echo $shipment->getId(); ?></h4>
                <form class="create-shipment-form" id="edit-shipment-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" novalidate>
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-4">
                            <label for="referenceNumberBackhaul" class="form-label pt-3">Shipment ID</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="referenceNumberBackhaul" name="referenceNumberBackhaul" value="<?php echo $shipment->getId(); ?>">
                                <div class="invalid-feedback">
                                    Enter a valid shipment ID
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="orderNumberBackhaul" class="form-label pt-3">Purchase Order Number</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="orderNumberBackhaul" name="orderNumberBackhaul" value="<?php echo $shipment->getOrderNumber(); ?>">
                                <div class="invalid-feedback">
                                    Enter a valid customer order number
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-between pt-3">
                        <div class="col-md-4">
                            <label for="palletsBackhaul" class="form-label">Pallets</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="palletsBackhaul" name="palletsBackhaul" value="<?php echo $shipment->getPalletCount(); ?>">
                                <div class="invalid-feedback">
                                    Enter the number of pallets
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="weightBackhaul" class="form-label">Weight</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="weightBackhaul" name="weightBackhaul" value="<?php echo $shipment->getNetWeight(); ?>">
                                <div class="invalid-feedback">
                                    Enter the weight
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-between pt-3">
                        <div class="col-md-4">
                            <label for="palletsBackhaul" class="form-label">Trailer Number</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="palletsBackhaul" name="palletsBackhaul" value="<?php echo $shipment->getTrailerId(); ?>">
                                <div class="invalid-feedback">
                                    Enter a valid trailer number
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="weightBackhaul" class="form-label">Warehouse</label>
                            <div class="input-group">
                                <select class="form-control select-caret" id="weightBacere">
                                    <option value="" disabled>Select a warehouse</option>
                                    <option value="">Danone COI</option>
                                    <option value="">Americold COI</option>
                                    <option value="">Americold Ontario</option>
                                    <option value="">Lineage Riverside</option>
                                </select>
                                <div class="invalid-feedback">
                                    Select a valid warehouse
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center pt-3">
                        <button type="button" class="btn btn-mron btn-save-shipment mt-5 mx-5">Submit Changes</button>
                        <button type="button" class="btn btn-secondary mt-5 mx-5" onclick="window.location.href='https\://ronbodnar.com/projects/logistics-management/shipments/details?id=<?php echo $shipment->getId(); ?>'">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
} else {
    include '../login-form.php';
} ?>
</div>

<?php include '../../../footer.php'; ?>