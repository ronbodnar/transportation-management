<form class="form-arrival" id="arrivalFormDanone" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" novalidate>
    <div id="danoneArrival">
        <label for="arrivalStatus" class="form-label fw-bold">What did you arrive with?</label>
        <select class="form-select select-caret" id="arrivalStatus" name="arrivalStatus">
            <option selected disabled value="">Select...</option>
            <option value="bobtail">Bobtail</option>
            <option value="backhaul">Backhaul</option>
            <option value="chepPallets">Chep Pallets</option>
            <option value="emptyTrailer">Empty Trailer</option>
            <option value="samples">Samples</option>
            <option value="refusedLoad">Refused Load</option>
        </select>
    </div>

    <div id="bobtailArrival" hidden>
        <button type="submit" class="btn btn-mron-fw mt-4">Submit</button>
    </div>

    <div id="backhaulArrival" hidden>
        <label for="referenceNumberBackhaul" class="form-label pt-3 fw-bold">Reference Number</label>
        <div class="input-group">
            <input type="text" class="form-control" id="referenceNumberBackhaul" name="referenceNumberBackhaul" placeholder="5013705532">
            <div class="invalid-feedback">
                Enter a valid reference number
            </div>
        </div>

        <label for="orderNumberBackhaul" class="form-label pt-3 fw-bold">Customer Order Number</label>
        <div class="input-group">
            <input type="text" class="form-control" id="orderNumberBackhaul" name="orderNumberBackhaul" placeholder="4503464432" autofocus>
            <div class="invalid-feedback">
                Enter a valid customer order number
            </div>
        </div>

        <div class="row">
            <div class="col pt-3">
                <label for="palletsBackhaul" class="form-label fw-bold">Pallets</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="palletsBackhaul" name="palletsBackhaul" placeholder="24">
                    <div class="invalid-feedback">
                        Enter the number of pallets
                    </div>
                </div>
            </div>

            <div class="col pt-3">
                <label for="weightBackhaul" class="form-label fw-bold">Weight</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="weightBackhaul" name="weightBackhaul" placeholder="45210">
                    <div class="invalid-feedback">
                        Enter the weight
                    </div>
                </div>
            </div>

            <div class="col pt-3">
                <label for="trailerNumberBackhaul" class="form-label fw-bold">Trailer</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="trailerNumberBackhaul" name="trailerNumberBackhaul" placeholder="50254">
                    <div class="invalid-feedback">
                        Enter a valid trailer number
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-mron-fw mt-4">Submit</button>
    </div>

    <div id="emptyArrival" hidden>
        <label for="trailerNumberEmpty" class="form-label pt-3 fw-bold">Trailer Number</label>
        <div class="input-group">
            <input type="text" class="form-control" id="trailerNumberEmpty" name="trailerNumberEmpty" placeholder="50254">
            <div class="invalid-feedback">
                Enter a valid trailer number
            </div>
        </div>

        <div class="pt-3 pb-1 fw-bold">Select a door for your empty trailer:</small></div>

        <div>
            <label class="checkbox-wrap" id="yesLabel">Door 6
                <input type="checkbox" name="yes" id="yCheck" class="checkbox">
                <span class="checkmark" id="yesCheck"></span>
            </label>
            <label class="checkbox-wrap" id="noLabel">Door 9
                <input type="checkbox" name="no" id="nCheck" class="checkbox">
                <span class="checkmark" id="noCheck"></span>
            </label>
            <label class="checkbox-wrap" id="no2Label">Door 13
                <input type="checkbox" name="no2" id="n2Check" class="checkbox">
                <span class="checkmark" id="no2Check"></span>
            </label>
            <div class="invalid-feedback">
                You must select a door
            </div>
        </div>

        <button class="btn btn-mron-fw mt-3" id="submit-empty-back">Submit</button>
    </div>

    <div id="palletsOrSamples" hidden>
        <div class="row">
            <div class="col pt-3">
                <label for="palletsSamples" class="form-label fw-bold">Pallets</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="palletsSamples" name="palletsSamples" placeholder="406">
                    <div class="invalid-feedback">
                        Enter the number of pallets
                    </div>
                </div>
            </div>

            <div class="col pt-3">
                <label for="trailerNumberSamples" class="form-label fw-bold">Trailer Number</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="trailerNumberSamples" name="trailerNumberSamples" placeholder="50249">
                    <div class="invalid-feedback">
                        Enter a valid trailer number
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-mron-fw mt-4">Submit</button>
    </div>

    <div id="refusedLoadArrival" hidden>
        <label for="orderNumberRefused" class="form-label pt-3 fw-bold">Customer Order Number</label>
        <div class="input-group">
            <input type="text" class="form-control" id="orderNumberRefused" name="orderNumberRefused" placeholder="4503464432" autofocus>
            <div class="invalid-feedback">
                Enter a valid customer order number
            </div>
        </div>

        <label for="referenceNumberRefused" class="form-label pt-3 fw-bold">Shipment Reference Number</label>
        <div class="input-group">
            <input type="text" class="form-control" id="referenceNumberRefused" name="referenceNumberRefused" placeholder="5013705532">
            <div class="invalid-feedback">
                Enter a valid shipment reference number
            </div>
        </div>

        <div class="row">
            <div class="col pt-3">
                <label for="palletsRefused" class="form-label fw-bold">Pallets</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="palletsRefused" name="palletsRefused" placeholder="24">
                    <div class="invalid-feedback">
                        Enter the number of pallets
                    </div>
                </div>
            </div>

            <div class="col pt-3">
                <label for="weightRefused" class="form-label fw-bold">Weight</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="weightRefused" name="weightRefused" placeholder="45210">
                    <div class="invalid-feedback">
                        Enter the weight
                    </div>
                </div>
            </div>

            <div class="col pt-3">
                <label for="trailerNumberRefused" class="form-label fw-bold">Trailer</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="trailerNumberRefused" name="trailerNumberRefused" placeholder="50254">
                    <div class="invalid-feedback">
                        Enter a valid trailer number
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-mron-fw mt-4">Submit</button>
    </div>
</form>

<div id="door-reminder" style="display: none;">

</div>