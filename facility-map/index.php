<?php

require '../header.php';

?>

<?php if (isLoggedIn()) { ?>
    <div class="container-fluid pt-3">
        <div class="overlay-inner">
            <h3 class="text-light align-self-left fw-bold">Facility Map <small style="font-size: 0.8rem; padding-left: 10px;">Proof of concept - not an actual feature</small></h3>
        </div>
        <div class="card content">
            <div class="card-body p-3" style="width: 100%; height: 75vh; max-height: 75vh;">
                <img id="facilityMap" src="/projects/tms/assets/img/Danone Map.png?v=10" style="height:100%; width:100%; object-fit: fill;" />
            </div>
        </div>
    </div>
<?php } else {
    include '../login-form.php';
} ?>

<?php include '../footer.php'; ?>