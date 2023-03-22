<div id="forfeit-shipment">
    <div class="text-center"><i class="bi bi-patch-exclamation-fill text-danger" style="font-size: 5rem;"></i></div>
    <p class="text-center" style="font-size: 1.5rem;">Forfeit Shipment</p>
    <p class="text-center pt-4 pb-4 fw-bold">Are you sure you want to forfeit this shipment? You will <u>not be authorized</u> to advance the load for any reason if you select yes.</p>
    <div>
        <label class="checkbox-wrap" id="yesLabel">Yes, I want to forfeit this shipment
            <input type="checkbox" name="yes" id="yCheck" class="checkbox">
            <span class="checkmark" id="yesCheck"></span>
        </label>
        <label class="checkbox-wrap" id="noLabel">No, do not forfeit this shipment
            <input type="checkbox" name="no" id="nCheck" class="checkbox">
            <span class="checkmark" id="noCheck"></span>
        </label>
        <div class="invalid-feedback">
            You must select an option
        </div>
    </div>
    <button type="submit" class="btn btn-danger mt-3 disabled w-100" id="">Submit</button>
</div>