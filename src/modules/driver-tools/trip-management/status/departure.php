<p>When you have finished all necessary yard moves and are either hooked up to a trailer or ready to leave, tap the button below.</p>
<form id="leaving" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
        <legend class="pt-0">Were you given a backhaul?</legend>
        <div class="col d-flex text-end">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1">
                <label class="form-check-label" for="gridRadios1">
                    Yes
                </label>
            </div>
        </div>
        <div class="col d-flex">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2" checked>
                <label class="form-check-label" for="gridRadios2">
                    No
                </label>
            </div>
        </div>
    </fieldset>
    <button type="submit" class="btn btn-mron mt-3" id="leaving">Leaving Facility</button>
</form>