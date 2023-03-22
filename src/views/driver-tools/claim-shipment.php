<?php

require '../../header.php';

if (!isLoggedIn()) {
    include '../login-form.php';
} else { ?>
    <div class="container-fluid pt-4">
        <div class="overlay-inner">
            <h3 class="text-light text-center fw-bold">Claim Shipment</h3>
        </div>
        <div class="row d-flex align-content-center justify-content-center trip-management">
            <div class="col-md-12">
                <div class="card content d-flex">
                    <div class="card-body chart-container justify-content-center table-responsive">
                        <?php
                        $shipments = $database->getOutboundShipments(6);
                        if (!$shipments || $shipments == null) {
                            echo 'No shipments found';
                        } else {
                        ?>
                            <table class="table" id="claimableShipmentsTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>ID</th>
                                        <th>Trailer</th>
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

<?php
}
include '../../footer.php'; ?>