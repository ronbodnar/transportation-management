<?php

require '../header.php';

?>

<?php if (isLoggedIn()) { ?>
    <div class="container-fluid pt-3">
        <div class="overlay-inner">
            <h3 class="text-light align-self-left fw-bold">Administration</h3>
        </div>

        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-md-10">
                <div class="card content d-flex">
                    <div class="card-header">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-body">
                                <h5 class="text-start fw-bold">General</h5>
                                <fieldset class="row mb-3">
                                    <legend class="col-form-label col-sm-4 pt-0">Allow Drivers to drop in open doors when arriving?</legend>
                                    <div class="col-sm-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="allowDropOnArrival" onclick="" checked>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="row mb-3">
                                    <legend class="col-form-label col-sm-4 pt-0">Broadcast notification to drivers?</legend>
                                    <div class="col-sm-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="allowDropOnArrival" onclick="">
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card-body">
                                <h5 class="text-start fw-bold">Doors / Yard</h5>
                                Add/remove door from OOS (when broken/repaired)<br />
                                Modify trailer numbers in case of error<br />
                                Assign / unassign shipments from trailer<br />
                                Put trailer OOS or return to service (eg: tires were fixed on-site)<br />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card-body">
                                <h5 class="text-start fw-bold">Drivers</h5>
                                Update driver name in case of error<br />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card-body">
                                <h5 class="text-start fw-bold">Shipments</h5>
                                Assign or unassign trailer<br />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else {
    include 'login-form.php';
} ?>

<?php include '../footer.php'; ?>