<?php

require '../../../header.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $loggedIn = true;
    $_SESSION['username'] = $username;
}

if (isset($_POST['loadNumber']) && isset($_POST['startTime'])) {
    $_SESSION['LOAD_NUMBER'] = 'C' . $_POST['loadNumber'];
    $_SESSION['START_TIME'] = $_POST['startTime'];
    $_SESSION['STATUS'] = 'PRE-TRIP';
}

// Unavailable reason
if (isset($_POST['reason'])) {
    $_SESSION['unavailableReason'] = $_POST['reason'];
}

if (isset($_POST['status'])) {
    if ($_POST['status'] == 'READY') {
        if (isset($_SESSION['PREVIOUS_STATUS']) && strlen($_SESSION['PREVIOUS_STATUS']) > 0) {
            $_SESSION['STATUS'] = $_SESSION['PREVIOUS_STATUS'];
            unset($_SESSION['PREVIOUS_STATUS']);
        } else {
            $_SESSION['STATUS'] = 'READY';
        }
    } else if ($_POST['status'] == 'LEFT_DANONE') {
        $_SESSION['STATUS'] = 'LEFT_DANONE';
    } else if ($_POST['status'] == 'ARRIVED_AT_DANONE') {
        $_SESSION['STATUS'] = 'ARRIVED_AT_DANONE';
    } else if ($_POST['status'] == 'LEFT_FACILITY') {
        $_SESSION['STATUS'] = 'LEFT_FACILITY';
    } else if ($_POST['status'] == 'ARRIVED_AT_FACILITY') {
        $_SESSION['STATUS'] = 'ARRIVED_AT_FACILITY';
    } else if ($_POST['status'] == 'INSTRUCTIONS_REFUSED') {
        $_SESSION['STATUS'] = 'INSTRUCTIONS_REFUSED';
    } else if ($_POST['status'] == 'DRIVER_UNAVAILABLE') {
        $_SESSION['PREVIOUS_STATUS'] = $_SESSION['STATUS'];
        $_SESSION['STATUS'] = 'DRIVER_UNAVAILABLE';
    } else if ($_POST['status'] == 'FORFEIT_SHIPMENT') {
        $_SESSION['STATUS'] = 'FORFEIT_SHIPMENT';
    } else if ($_POST['status'] == 'WAITING') {
        //$_SESSION['STATUS'] = 'WAITING';
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
        exit();
    } else {
        die('Unhandled status change: ' . $_POST['status']);
    }
    $_COOKIE['status'] = $_SESSION['status'];
}

if (!isLoggedIn()) {
    include '../../../views/login-form.php';
} else { ?>
    <div class="container-fluid pt-4">
        <div class="overlay-inner">
            <h3 class="text-light text-center fw-bold display-5">Danone Workflow</h3>
        </div>
        <div class="row d-flex align-content-center justify-content-center trip-management">
            <div class="col-md-12">
                <div class="card content d-flex">
                    <div class="card-body justify-content-center">
                        <div id="main">
                            <?php
                            if (!isset($_SESSION['LOAD_NUMBER'])) {
                                include 'status/startofday.php';
                            } else {
                                $status = $_SESSION['STATUS'];
                                if ($status == 'PRE-TRIP') {
                                    include 'status/pretrip.php';
                                } else if ($status == 'READY') {
                                    include 'status/standby.php';
                                } else if ($status == 'LEFT_DANONE') {
                                    include 'status/driving.php';
                                } else if ($status == 'LEFT_FACILITY') {
                                    include 'status/driving2.php';
                                } else if ($status == 'ARRIVED_AT_DANONE') {
                                    include 'status/arrival-danone.php';
                                } else if ($status == 'ARRIVED_AT_FACILITY') {
                                    include 'status/arrival-shipment.php';
                                } else if ($status == 'WAITING') {
                                    include 'status/departure.php';
                                } else if ($status == "INSTRUCTIONS_REFUSED") {
                                    include 'status/refused.php';
                                } else if ($status == "DRIVER_UNAVAILABLE") {
                                    include 'status/unavailable.php';
                                } else if ($status == "FORFEIT_SHIPMENT") {
                                    include 'status/forfeit.php';
                                } else {
                                    echo '<div class="text-center">Unknown status: "' . $status . '"</div>';
                                }
                            }
                            ?>
                        </div>

                        <div id="issuePrompt" style="display: none;">
                            <div class="driver-unavailable">
                                <form id="unavailable-form" method="post" action=".">
                                    <label for="unavailable-reason" class="form-label fw-bold small">What's going on?</label>
                                    <div class="form-group">
                                        <select class="form-select select-caret" id="unavailable-reason" name="unavailable-reason">
                                            <option selected disabled value="">Select an option...</option>
                                            <option value="lunch">I'm going on lunch break</option>
                                            <option value="stop">I had to make a stop</option>
                                            <option value="mechanical">I have a mechanical issue</option>
                                            <option value="other" disabled>Other</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Select an option
                                        </div>
                                    </div>

                                    <div class="form-group pt-3" id="stop-locations-prompt" style="display: none;">
                                        <label for="unavailable-reason" class="form-label fw-bold small">Where did you stop?</label>
                                        <select class="form-select select-caret" id="stop-locations" name="stop-locations">
                                            <option selected disabled value="">Select a location...</option>
                                            <option value="wash">Truck Wash</option>
                                            <option value="fuel">Fuel Station</option>
                                            <option value="nrt">Northern Yard</option>
                                            <option value="other" disabled>Other</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Select a location
                                        </div>
                                    </div>

                                    <div class="pt-4" id="nrtYardReason" style="display: none;">
                                        <div class="form-group">
                                            <textarea class="form-control" id="nrtYardDescription" name="nrtYardDescription" placeholder="Briefly explain why you are stopping at the yard." style="width: 100%;" rows="3"></textarea>
                                            <div class="invalid-feedback">
                                                You must enter a valid explanation<br /><small>(min 10 chars)</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group pt-3" id="mechanical-issue-prompt" style="display: none;">
                                        <label for="unavailable-reason" class="form-label fw-bold small">Are you able to drive to the shop?</label>
                                        <select class="form-select select-caret" id="canDriveToShop" name="canDriveToShop">
                                            <option selected disabled value="">Select a response...</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Select a response
                                        </div>
                                    </div>

                                    <div class="form-group pt-3" id="mechanical-issue-rescue-prompt" style="display: none;">
                                        <label for="unavailable-reason" class="form-label fw-bold small">Do you want need a driver to rescue your shipment?<br /><em class="small">You can always request a rescue later if you are not sure.</em></label>
                                        <select class="form-select select-caret" id="rescue-needed" name="rescue-needed">
                                            <option selected disabled value="">Select a response...</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Select a response
                                        </div>
                                    </div>

                                    <div class="pt-4" id="mechanicalDescription" style="display: none;">
                                        <div class="form-group">
                                            <textarea class="form-control" id="mechanicalIssueDescription" name="mechanicalIssueDescription" placeholder="Briefly explain what issue you are having with your tractor." style="width: 100%;" rows="3"></textarea>
                                            <div class="invalid-feedback">
                                                You must enter a valid explanation<br /><small>(min 10 chars)</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group pt-3" id="fuel-stations-prompt" style="display: none;">
                                        <label for="fuel-stations" class="form-label fw-bold small">Which fuel station are you at?</label>
                                        <select class="form-select select-caret" id="fuel-stations" name="fuel-stations">
                                            <option selected disabled value="">Select a fuel station...</option>
                                            <option value="scfuelscoi">SC Fuels - COI / San Jose</option>
                                            <option value="scfuelshh">SC Fuels - Hacienda Heights / Gale</option>
                                            <option value="scfuelsfontana">SC Fuels - Fontana</option>
                                            <option value="scfuelschino">SC Fuels - Chino</option>
                                            <option value="scfuelsont">SC Fuels - Ontario</option>
                                            <option value="flyersont">Flyers - Ontario</option>
                                            <option value="flyersriverside">Flyers - Riverside</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Select a fuel station location
                                        </div>
                                    </div>

                                    <div class="pt-4" id="other-unavailable" style="display: none;">
                                        <div class="form-group">
                                            <textarea class="form-control" id="unavailable-other" name="unavailable-other" placeholder="Explain why you are unavailable to work." style="width: 100%;" rows="3"></textarea>
                                            <div class="invalid-feedback">
                                                You must enter a valid explanation<br /><small>(min 10 chars)</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-mron mt-3 disabled" id="sendIssueForm" style="width: 45%;">Submit</button>
                                        <button type="submit" class="btn btn-secondary mt-3" id="cancelIssueForm" style="width: 45%;">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
}
include '../../../footer.php'; ?>