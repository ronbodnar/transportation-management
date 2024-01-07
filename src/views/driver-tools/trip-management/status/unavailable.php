<div id="timer">
    <div class="text-center"><i class="bi bi-clock text-mron" style="font-size: 5rem;"></i></div>
    <h5 class="fw-bold text-center" style="font-size: 1.5rem;" id="title"><?php echo $_SESSION['unavailableReason']; ?></h5>

    <button type="submit" class="btn btn-mron-fw mt-5" id="return-to-work">Return to Work</button>

    <?php
    $reason = $_SESSION['unavailableReason'];
    if (strpos($reason, "Lunch Break") === false && strpos($reason, "Truck Wash") === false && strpos($reason, "Fuel Station") === false) { ?>
        <div id="rescue-needed">
            <p class="small pt-5">If you are unable to complete the load and must forfeit your shipment, tap the button below.</p>

            <button type="submit" class="btn btn-danger mt-3 mb-3" style="width: 100%;" id="forfeit-shipment-button">Forfeit Shipment</button>
        </div>
    <?php } ?>
</div>