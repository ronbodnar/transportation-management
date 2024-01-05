<?php

require '../../header.php';

?>

<?php if (isLoggedIn()) { ?>
    <div class="container-fluid pt-3">
        <div class="overlay-inner">
            <h3 class="text-light align-self-left fw-bold">Active Driver List</h3>
        </div>
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-md-10">
                <div class="card content">
                    <div class="card-header">
                        Active Drivers (<?php echo $database->getActiveDriverCount(); ?>)
                        <span class="card-header-options"></span>
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
<?php
} else {
    include '../login-form.php';
} ?>

<?php include '../../footer.php'; ?>