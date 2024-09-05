<div>
    <div id="waiting" class="text-center">
        <h5 class="fw-bold text-center pb-4" style="font-size: 1.5rem;">Awaiting Instructions</h5>
        <p class="pb-3">The Danone Lead has been informed of your arrival and you will receive instructions soon. Hang tight.</p>
        <div class="spinner-border text-mron" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <a class="toggle text-mron" style="position: absolute; bottom: 0;left: 0; cursor: pointer;"><i class="bi bi-arrow-clockwise" style="font-size: 0.9rem;"></i></a>
    </div>
    <div id="instructions" style="display: none;">
        <div class="text-center"><i class="bi bi-patch-exclamation-fill text-mron" style="font-size: 5rem;"></i></div>
        <h5 class="fw-bold text-center pb-4" style="font-size: 1.5rem;">Instructions Received</h5>

        <div class="text-start" id="details">
            <p>
                <strong style="font-size: 1.2rem; color: var(--light-text-color); padding-left: 1.1rem;">Take</strong> trailer <strong class="text-mron" style="font-size: 1.2rem;">5147</strong> from door <strong class="text-mron" style="font-size: 1.2rem;">15</strong>
                <em class="small" style="color: var(--light-text-color); padding-left: 2rem;">Reference number: 5012802600</em>
            </p>
        </div>

        <div class="text-center pt-3" id="accept-instructions-prompt">
            <p class="small fw-bold">Do you accept these instructions?</p>
            <div class="d-flex justify-content-around">
                <button class="btn btn-mron mt-1" id="accept-instructions">Accept</button>
                <button class="btn btn-secondary mt-1" id="refuse-instructions">Refuse</button>
            </div>
        </div>

        <div class="text-center pt-2" id="accepted-instructions" style="display: none;">
            <div>
                <label for="cameraInput" class="form-label pt-1 fw-bold">Signed Bill of Lading Pictures <br /><small>(Include a picture of <strong>ALL</strong> pages received)</small></label>
                <input type="file" class="form-control" id="cameraInput" names="pictures[]" accept="image/*" multiple required>
                <div class="invalid-feedback">
                    You must select at least 1 picture to upload
                </div>
            </div>

            <p class="small pt-3">When you are hooked up and ready to go, <strong>tap the button below.</strong></p>
            <button class="btn btn-mron-fw mt-1" id="ready-to-go">Ready to go</button>
        </div>

        <div class="refuse-instructions pt-3 text-center" style="display: none;">
            <form id="refuse-instructions-form" method="post" action=".">
                <label for="refusal-reason" class="form-label fw-bold small">Why are you refusing?</label>
                <div class="form-group">
                    <select class="form-select select-caret" id="refusal-reason" name="refusal-reason">
                        <option selected disabled value="">Select reason...</option>
                        <option value="lunch">Going on lunch</option>
                        <option value="time">Not enough time</option>
                        <option value="trailer">Trailer Unsafe</option>
                        <option value="other">Other</option>
                    </select>
                    <div class="invalid-feedback">
                        Select a reason for refusing instructions
                    </div>
                </div>

                <div class="trailer-reason pt-3" style="display: none;">
                    <label for="trailer-reason" class="form-label fw-bold small">What is unsafe about the trailer?</label>
                    <div class="form-group">
                        <select class="form-select select-caret" id="trailer-reason" name="trailer-reason">
                            <option selected disabled value="">Select reason...</option>
                            <option value="tire">Flat / Damaged Tire</option>
                            <option value="lights">Missing Lights</option>
                            <option value="mechanical">Mechanical Issue</option>
                            <option value="other">Other</option>
                        </select>
                        <div class="invalid-feedback">
                            Select an option
                        </div>
                    </div>
                </div>

                <div class="pt-3" id="other-trailer" style="display: none;">
                    <div class="form-group">
                        <textarea class="form-control" id="trailer-other" name="trailer-other" placeholder="Explain why the trailer is unsafe" style="width: 100%;" rows="3"></textarea>
                        <div class="invalid-feedback">
                            You must enter a valid explanation<br /><small>(min 10 chars)</small>
                        </div>
                    </div>
                </div>

                <div class="pt-3" id="trailer-oos-prompt" style="display: none;">
                    <label for="trailer-oos" class="form-label fw-bold small">Do you want to put the trailer OUT OF SERVICE?</label>
                    <div class="form-group">
                        <select class="form-select select-caret" id="trailer-oos" name="trailer-oos">
                            <option selected disabled value="">Select response...</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                        <div class="invalid-feedback">
                            Select an option
                        </div>
                    </div>
                </div>

                <div class="pt-3" id="other-refusal" style="display: none;">
                    <div class="form-group">
                        <textarea class="form-control" id="refusal-other" name="refusal-other" placeholder="Explain why you are refusing instructions" style="width: 100%;" rows="3"></textarea>
                        <div class="invalid-feedback">
                            You must enter a valid explanation<br /><small>(min 10 chars)</small>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-secondary mt-3 disabled" id="send-refusal">Send Refusal</button>
            </form>
        </div>
    </div>
</div>