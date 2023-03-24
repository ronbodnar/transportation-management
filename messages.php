<?php

require 'header.php';
require 'config.php';

loadConfig();

?>

<?php if (isLoggedIn()) { ?>
    <div class="container-fluid pt-3">

        <!-- Page Title -->
        <div class="overlay-inner">
            <h3 class="text-light align-self-left fw-bold">Messages</h3>
        </div>

        <div class="card content">
            <div class="card-body">
                <div class="row" style="height: 75vh;">
                    <div class="col-md-2 g-0" style="height: 100%;">
                        <h3 class="fs-5 text-center">Conversations</h3>
                        <ul class="list-group list-group-flush" style="overflow-y: scroll;">
                            <li class="list-group-item active" aria-current="true">All Drivers</li>
                            <?php
                            $allDrivers = $database->getAllDrivers();

                            foreach ($allDrivers as $driver) {
                                echo '<a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">';
                                echo $driver->getFullName();
                                if (rand(0, 5) === 0) {
                                    echo '<span class="badge bg-mron rounded-pill">' . rand(1, 3) . '</span>';
                                }
                                echo '</a>';
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="col-md-10 g-0" style="height: 100%;">
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- row end -->
    </div> <!-- container end -->
<?php } else {
    include 'login-form.php';
} ?>

<?php include 'footer.php'; ?>