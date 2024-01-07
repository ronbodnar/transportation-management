<div class="text-center" id="distance-not-acceptable" style="display: block;">
    <div class="text-center"><i class="bi bi-patch-exclamation-fill text-danger" style="font-size: 5rem;"></i></div>
    <p style="font-size: 1.3rem;">You are <span class="text-danger">1.5 miles</span> away from the facility. You must be at <strong>Americold COI</strong> to check in.</p>
    <p class="small pt-3">When you have arrived, <strong>tap the button below</strong> to continue the check-in process.</p>
    <button class="btn btn-mron-fw mt-3" id="arrived-at-facilityy">I've arrived</button>
</div>

<div class="text-center" id="distance-acceptable" style="display: none;">
    <div class="text-center"><i class="bi bi-patch-check-fill text-mron" style="font-size: 5rem;"></i></div>
    <p style="font-size: 1.3rem;">Arrived at <strong>Americold COI</strong></p>

    <p class="small pt-2 pb-3">You will receive your instructions as soon as they have been assigned to you by office staff. Hang tight.</p>
    <div class="spinner-border text-mron" style="width: 3rem; height: 3rem;" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <a class="toggle-check-in text-mron" style="position: absolute; bottom: 0;left: 0; cursor: pointer;"><i class="bi bi-arrow-clockwise" style="font-size: 0.9rem;"></i></a>
</div>

<div id="facility-instructions" style="display: none;">
    <div class="text-center"><i class="bi bi-patch-exclamation-fill text-mron" style="font-size: 5rem;"></i></div>
    <h5 class="fw-bold text-center pb-4" style="font-size: 1.5rem;">Instructions Received</h5>

    <div class="text-start">
        <p><strong style="font-size: 1.2rem; color: var(--light-text-color); padding-left: 1.1rem;">Drop</strong> your trailer in door <strong class="text-mron" style="font-size: 1.2rem;">5</strong></p>
        <p><strong style="font-size: 1.2rem; color: var(--light-text-color); padding-left: 1.1rem;">Move</strong> empty in door <strong class="text-mron" style="font-size: 1.2rem;">6</strong> to the yard</p>
        <p><strong style="font-size: 1.2rem; color: var(--light-text-color); padding-left: 1.1rem;">Take</strong> empty trailer from door <strong class="text-mron" style="font-size: 1.2rem;">4</strong></p>
    </div>

    <div class="text-center pt-3" id="accept-instructions-prompt">
        <p class="small fw-bold">Do you accept these instructions?</p>
        <div class="d-flex justify-content-around">
            <button class="btn btn-mron mt-1" id="accept-instructions">Accept</button>
            <button class="btn btn-secondary disabled mt-1" id="refuse-instructions">Refuse</button>
        </div>
    </div>

    <div class="text-center pt-5" id="accepted-instructions" style="display: none;">
        <p class="small">When you are finished and ready to leave, <strong>tap the button below.</strong></p>
        <button class="btn btn-mron-fw mt-1" id="leaving-facility">I'm leaving</button>
    </div>

    <div class="refuse-instructions pt-5 text-center" style="display: none;">
        <form method="post" action="">
            <textarea id="refusal-reason" name="refusal-reason" placeholder="Explain why you are refusing instructions" style="width: 100%;" rows="3"></textarea>
            <button type="submit" class="btn btn-secondary mt-1" id="send-refusal">Send Refusal</button>
        </form>
    </div>
</div>