<form class="form-arrival" id="arrivalForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" novalidate>
    <input type="hidden" id="status" name="status" value="WAITING">
    <label for="facilityName" class="form-label mt-3">Which facility are you at?</label>
    <select class="form-select" id="facilityName" name="facilityName">
        <option selected disabled value="">Select Facility...</option>
        <option value="accoi">Americold - COI</option>
        <option value="acont">Americold - ONT</option>
        <option value="danone">Danone Plant - COI</option>
        <option value="lineage">Lineage - Riverside</option>
        <option value="northern">Northern Yard - ONT</option>
        <option value="flyers" disabled>Flyers</option>
        <option value="scfuels" disabled>SC Fuels</option>
    </select>
    <div id="normalArrival" hidden>
        <label for="orderNumber" class="form-label pt-3">Customer Order Number</label>
        <div class="input-group">
            <input type="text" class="form-control" id="orderNumber" name="orderNumber" placeholder="4503464432" autofocus>
            <div class="invalid-feedback">
                Enter a valid customer order number
            </div>
        </div>

        <label for="referenceNumber" class="form-label pt-3">Shipment Reference Number</label>
        <div class="input-group">
            <input type="text" class="form-control" id="referenceNumber" name="referenceNumber" placeholder="5013705532">
            <div class="invalid-feedback">
                Enter a valid shipment reference number
            </div>
        </div>

        <div class="row">
            <div class="col pt-3">
                <label for="pallets" class="form-label">Pallets</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="pallets" name="pallets" placeholder="24">
                    <div class="invalid-feedback">
                        Enter the number of pallets
                    </div>
                </div>
            </div>

            <div class="col pt-3">
                <label for="weight" class="form-label">Weight</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="weight" name="weight" placeholder="45,210">
                    <div class="invalid-feedback">
                        Enter the load weight
                    </div>
                </div>
            </div>

            <div class="col pt-3">
                <label for="trailerNumber" class="form-label">Trailer #</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="trailerNumber" name="trailerNumber" placeholder="50254">
                    <div class="invalid-feedback">
                        Enter the trailer number
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-mron mt-3">Submit</button>
    </div>
    <div id="danoneArrival" hidden>
        <label for="arrivalStatus" class="form-label mt-3">What did you arrive with?</label>
        <select class="form-select" id="arrivalStatus" name="arrivalStatus">
            <option selected disabled value="">Select...</option>
            <option value="bobtail">Bobtail</option>
            <option value="backhaul">Backhaul</option>
            <option value="chepPallets">Chep Pallets</option>
            <option value="emptyTrailer">Empty Trailer</option>
            <option value="samples">Samples</option>
            <option value="refusedLoad">Refused Load</option>
        </select>
    </div>

    <div id="northernArrival" hidden>
        <label for="reason" class="form-label mt-3">What is the purpose for stopping here?</label>
        <select class="form-select" id="reason" name="reason">
            <option selected disabled value="">Select...</option>
            <option value="break">Break</option>
            <option value="mechanics">Mechanics</option>
            <option value="other">Other</option>
        </select>

        <div id="other" hidden>
            <label for="otherReason" class="form-label pt-3">Specify Reason</label>
            <div class="input-group">
                <input type="text" class="form-control" id="otherReason" name="otherReason" placeholder="Swapping trucks">
                <div class="invalid-feedback">
                    Provide a reason for stopping at the yard
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-mron mt-3">Submit</button>
    </div>

    <div id="fuelArrival" hidden>
        <label for="reason" class="form-label mt-3">Which fuel station are you at?</label>
        <select class="form-select" id="reason" name="reason">
            <option selected disabled value="">Select...</option>
            <option value="scfuelscoi">SC Fuels - COI</option>
            <option value="scfuelshh">SC Fuels - Hacienda Heights</option>
            <option value="scfuelsfontana">SC Fuels - Fontana</option>
            <option value="scfuelschino">SC Fuels - Chino</option>
            <option value="scfuelsont">SC Fuels - Ontario</option>
            <option value="flyersont">Flyers - Ontario</option>
            <option value="flyersriverside">Flyers - Riverside</option>
        </select>

        <button type="submit" class="btn btn-mron mt-3">Submit</button>
    </div>

    <div id="bobtailArrival" hidden>
        <button type="submit" class="btn btn-mron mt-3">Submit</button>
    </div>

    <div id="backhaulArrival" hidden>
        <label for="orderNumberBackhaul" class="form-label pt-3">Customer Order Number</label>
        <div class="input-group">
            <input type="text" class="form-control" id="orderNumberBackhaul" name="orderNumberBackhaul" placeholder="4503464432" autofocus>
            <div class="invalid-feedback">
                Enter a valid customer order number
            </div>
        </div>

        <label for="referenceNumberBackhaul" class="form-label pt-3">Shipment Reference Number</label>
        <div class="input-group">
            <input type="text" class="form-control" id="referenceNumberBackhaul" name="referenceNumberBackhaul" placeholder="5013705532">
            <div class="invalid-feedback">
                Enter a valid shipment reference number
            </div>
        </div>

        <div class="row">
            <div class="col pt-3">
                <label for="palletsBackhaul" class="form-label">Pallets</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="palletsBackhaul" name="palletsBackhaul" placeholder="24">
                    <div class="invalid-feedback">
                        Enter the number of pallets
                    </div>
                </div>
            </div>

            <div class="col pt-3">
                <label for="weightBackhaul" class="form-label">Weight</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="weightBackhaul" name="weightBackhaul" placeholder="45,210">
                    <div class="invalid-feedback">
                        Enter the weight
                    </div>
                </div>
            </div>

            <div class="col pt-3">
                <label for="trailerNumberBackhaul" class="form-label">Trailer #</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="trailerNumberBackhaul" name="trailerNumberBackhaul" placeholder="50254">
                    <div class="invalid-feedback">
                        Enter the trailer number
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-mron mt-3">Submit</button>
    </div>

    <div id="emptyArrival" hidden>
        <label for="trailerNumberEmpty" class="form-label pt-3">Trailer #</label>
        <div class="input-group">
            <input type="text" class="form-control" id="trailerNumberEmpty" name="trailerNumberEmpty" placeholder="50254">
            <div class="invalid-feedback">
                Enter a trailer number
            </div>
        </div>

        <button type="submit" class="btn btn-mron mt-3">Submit</button>
    </div>

    <div id="palletsOrSamples" hidden>
        <div class="row">
            <div class="col pt-3">
                <label for="palletsSamples" class="form-label">Pallets</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="palletsSamples" name="palletsSamples" placeholder="406">
                    <div class="invalid-feedback">
                        Enter the number of pallets
                    </div>
                </div>
            </div>

            <div class="col pt-3">
                <label for="trailerNumberSamples" class="form-label">Trailer #</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="trailerNumberSamples" name="trailerNumberSamples" placeholder="50249">
                    <div class="invalid-feedback">
                        Enter the trailer number
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-mron mt-3">Submit</button>
    </div>

    <div id="refusedLoadArrival" hidden>
        <label for="orderNumberRefused" class="form-label pt-3">Customer Order Number</label>
        <div class="input-group">
            <input type="text" class="form-control" id="orderNumberRefused" name="orderNumberRefused" placeholder="4503464432" autofocus>
            <div class="invalid-feedback">
                Enter a valid customer order number
            </div>
        </div>

        <label for="referenceNumberRefused" class="form-label pt-3">Shipment Reference Number</label>
        <div class="input-group">
            <input type="text" class="form-control" id="referenceNumberRefused" name="referenceNumberRefused" placeholder="5013705532">
            <div class="invalid-feedback">
                Enter a valid shipment reference number
            </div>
        </div>

        <div class="row">
            <div class="col pt-3">
                <label for="palletsRefused" class="form-label">Pallets</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="palletsRefused" name="palletsRefused" placeholder="24">
                    <div class="invalid-feedback">
                        Enter the number of pallets
                    </div>
                </div>
            </div>

            <div class="col pt-3">
                <label for="weightRefused" class="form-label">Weight</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="weightRefused" name="weightRefused" placeholder="45,210">
                    <div class="invalid-feedback">
                        Enter the weight
                    </div>
                </div>
            </div>

            <div class="col pt-3">
                <label for="trailerNumberRefused" class="form-label">Trailer #</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="trailerNumberRefused" name="trailerNumberRefused" placeholder="50254">
                    <div class="invalid-feedback">
                        Enter the trailer number
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-mron mt-3">Submit</button>
    </div>
</form>