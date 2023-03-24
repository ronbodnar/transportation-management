<?php

require '../header.php';

?>

<?php if (isLoggedIn()) { ?>
    <div class="container-fluid pt-3">
        <div class="overlay-inner">
            <h3 class="text-light align-self-left pt-3">Create a Shipment</h3>
        </div>
        <div class="row d-flex align-content-center justify-content-center pt-5">
            <div class="col-md-10">
                <form class="create-shipment-form" id="create-shipment-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" novalidate>
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-4">
                            <label for="referenceNumberBackhaul" class="form-label pt-3">Shipment ID</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="referenceNumberBackhaul" name="referenceNumberBackhaul" placeholder="5013705532">
                                <div class="invalid-feedback">
                                    Enter a valid shipment ID
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="orderNumberBackhaul" class="form-label pt-3">Purchase Order Number</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="orderNumberBackhaul" name="orderNumberBackhaul" placeholder="4503464432" autofocus>
                                <div class="invalid-feedback">
                                    Enter a valid customer order number
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-between pt-3">
                        <div class="col-md-3">
                            <label for="palletsBackhaul" class="form-label">Pallets</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="palletsBackhaul" name="palletsBackhaul" placeholder="24">
                                <div class="invalid-feedback">
                                    Enter the number of pallets
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="weightBackhaul" class="form-label">Weight</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="weightBackhaul" name="weightBackhaul" placeholder="45,210">
                                <div class="invalid-feedback">
                                    Enter the weight
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="fw-bold pt-3 pb-2">Assign shipment to a door / trailer?</div>

                    <div>
                        <label class="checkbox-wrap" id="yesLabel">Yes
                            <input type="checkbox" name="yes" id="assign-to-door-yes" class="checkbox">
                            <span class="checkmark" id="assign-to-door-yes-cm"></span>
                        </label>
                        <label class="checkbox-wrap" id="noLabel">No
                            <input type="checkbox" name="no" id="assign-to-door-no" class="checkbox">
                            <span class="checkmark" id="assign-to-door-no-cm"></span>
                        </label>
                        <div class="invalid-feedback">
                            You must select an option
                        </div>
                    </div>

                    <div id="door-selection" style="display: none;">
                        <div class="fw-bold pt-3 pb-2">Assign to what door / trailer?</div>

                        <select class="form-select" id="door-or-trailer" name="door-or-trailer" style="width: 40%;">
                            <option selected disabled value="">Select a door...</option>
                            <?php
                            $availableDoors = $database->getDoorsWithEmptyTrailer();

                            echo 'erere<pre>';
                            print_r($availableDoors);
                            echo '</pre>';

                            foreach ($availableDoors as $availableDoor) {
                                if ($availableDoor['id'] > 15) {
                                    break;
                                }
                                echo '<option value="' . $availableDoor['id'] . '">Door ' . $availableDoor['id'] . ' - Trailer ' . $availableDoor['trailerId'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="row text-center d-flex justify-content-center pt-5">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-mron mt-3">Create Shipment</button>
                        </div>
                        <div class="col-md-3">
                            <a class="btn btn-secondary mt-3" role="button">Clear</a>
                        </div>
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

<?php include '../footer.php'; ?>