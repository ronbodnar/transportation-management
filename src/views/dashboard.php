<div class="container-fluid pt-3">

        <!-- Page Title -->
        <div class="overlay-inner">
            <h3 class="text-light align-self-left fw-bold">Dashboard</h3>
        </div>

        <div class="row">
            <!-- Daily Shipment Chart -->
            <div class="col-sm-4">
                <div class="card content d-flex">
                    <div class="card-header">
                        Daily Shipments
                    </div>
                    <div class="card-body justify-content-center overflow-auto">
                        <div class="row d-flex align-items-center">
                            <div class="col-sm-4">
                                <p class="fw-bold text-center" style="font-size: 3rem;">36</p>
                            </div>
                            <div class="col-sm-8">
                                <canvas id="dailyShipmentsChart" style="height: 100px; width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Average Wait Time Chart -->
            <div class="col-sm-4">
                <div class="card content d-flex">
                    <div class="card-header">
                        Average Wait Time
                        <span class="card-header-options"></span>
                    </div>
                    <div class="card-body justify-content-center overflow-auto">
                        <div class="row d-flex align-items-center">
                            <div class="col-sm-4">
                                <h1 class="fw-bold text-center">1h 6m</h1>
                            </div>
                            <div class="col-sm-8">
                                <canvas id="waitTimeMinChart" style="max-height: 100px; width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Driver Chart -->
            <div class="col-sm-4">
                <div class="card content d-flex">
                    <div class="card-header">
                        Active Drivers
                        <span class="card-header-options"></span>
                    </div>
                    <div class="card-body justify-content-center overflow-auto">
                        <div class="row d-flex align-items-center">
                            <div class="col-sm-3">
                                <h1 class="fw-bold text-center display-5">9</h1>
                            </div>
                            <div class="col-sm-9">
                                <canvas id="activeDriverChartMin" style="height: 100px; width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Americold COI Shipment Target -->
            <div class="col-sm-4">
                <div class="card content d-flex">
                    <div class="dropdown">
                        <span class="card-header-options-no-header" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></span>
                        <ul class="dropdown-menu text-small shadow">
                            <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#setShipmentTargetModal"><i class="bi bi-bullseye" style="padding-right: 15px;"></i>Set Targets</button></li>
                        </ul>
                    </div>
                    <div class="card-body chart-container justify-content-center">
                        <div class="row pt-2">
                            <div class="col-sm-12 text-center d-flex justify-content-around px-4">
                                <p class="fs-3 fw-bold">Americold COI</p>
                                <div><span id="accoi-target" class="fw-bold" style="color: #E69322;"><?php echo $config['targets']['accoi']; ?></span><br />Target</div>
                                <div><span id="accoi-sent" class="fw-bold" style="color: #E69322;">26</span><br />Shipped</div>
                                <div><span id="accoi-remaining" class="fw-bold" style="color: #E69322;"><?php echo ($config['targets']['accoi'] - 26); ?></span><br />Remaining</div>
                            </div>
                            <div class="col-sm-12">
                                <canvas id="accoiShipmentTargetChart" style="height: 200px; width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Americold Ontario Shipment Target -->
            <div class="col-sm-4">
                <div class="card content d-flex">
                    <div class="dropdown">
                        <span class="card-header-options-no-header" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></span>
                        <ul class="dropdown-menu text-small shadow">
                            <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#setShipmentTargetModal"><i class="bi bi-bullseye" style="padding-right: 15px;"></i>Set Targets</button></li>
                        </ul>
                    </div>
                    <div class="card-body chart-container justify-content-center">
                        <div class="row pt-2">
                            <div class="col-sm-12 text-center d-flex justify-content-around px-4">
                                <p class="fs-3 fw-bold">Americold Ontario</p>
                                <div><span id="acont-target" class="fw-bold" style="color: #218B94;"><?php echo $config['targets']['acont']; ?></span><br />Target</div>
                                <div><span id="acont-sent" class="fw-bold" style="color: #218B94;">22</span><br />Shipped</div>
                                <div><span id="acont-remaining" class="fw-bold" style="color: #218B94;"><?php echo ($config['targets']['acont'] - 22); ?></span><br />Remaining</div>
                            </div>
                            <div class="col-sm-12">
                                <canvas id="acontShipmentTargetChart" style="height: 200px; width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lineage Riverside Shipment Target -->
            <div class="col-sm-4">
                <div class="card content d-flex">
                    <div class="dropdown">
                        <span class="card-header-options-no-header" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></span>
                        <ul class="dropdown-menu text-small shadow">
                            <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#setShipmentTargetModal"><i class="bi bi-bullseye" style="padding-right: 15px;"></i>Set Targets</button></li>
                        </ul>
                    </div>
                    <div class="card-body chart-container justify-content-center">
                        <div class="row pt-2">
                            <div class="col-sm-12 text-center d-flex justify-content-around px-4">
                                <p class="fs-3 fw-bold">Lineage Riverside</p>
                                <div><span id="lineage-target" class="fw-bold" style="color: #399D37;"><?php echo $config['targets']['lineage']; ?></span><br />Target</div>
                                <div><span id="lineage-sent" class="fw-bold" style="color: #399D37;">4</span><br />Shipped</div>
                                <div><span id="lineage-remaining" class="fw-bold" style="color: #399D37;"><?php echo ($config['targets']['lineage'] - 4); ?></span><br />Remaining</div>
                            </div>
                            <div class="col-sm-12">
                                <canvas id="lineageShipmentTargetChart" style="height: 200px; width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Available Driver Table -->
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="card content d-flex">
                            <div class="card-header">
                                Available Drivers (<span id="availableDriverCount"><?php echo $database->getAvailableDriverCount(); ?></span>)
                                <div class="dropdown">
                                    <span class="card-header-options" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></span>
                                    <ul class="dropdown-menu text-small shadow">
                                        <li><a class="dropdown-item" href="drivers/"><i class="bi bi-arrow-up-right-square" style="padding-right: 15px;"></i>View all Drivers</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body justify-content-center overflow-auto table-responsive" style="height: 350px;">
                                <table class="table table-striped" id="availableDriversTable">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <!--<th>#</th>-->
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th class="text-center">Arrival Time</th>
                                            <th class="text-center">Start Time</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Trip Estimates Chart -->
                    <div class="col-6 col-sm-6">
                        <div class="card content d-flex">
                            <div class="card-header">
                                Trip Time Estimates
                                <span class="card-header-options"></span>
                            </div>
                            <div class="card-body" style="height: 150px;">
                                <canvas id="tripTimeEstimatesChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- TBD -->
                    <div class="col-6 col-sm-6">
                        <div class="card content d-flex">
                            <div class="card-header">
                                Returning Drivers
                                <span class="card-header-options"></span>
                            </div>
                            <div class="card-body table-responsive" style="height: 150px;">
                                <table class="table table-striped" id="">
                                    <thead>
                                        <tr>
                                            <th>Driver</th>
                                            <th>Trailer</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>Jason Smith</td>
                                            <td>2550</td>
                                        </tr>
                                        <tr>
                                            <td>Brent Smith</td>
                                            <td>8050</td>
                                        </tr>
                                        <tr>
                                            <td>Anthony Smith</td>
                                            <td>Bobtail</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Door Status Table -->
            <div class="col-sm-3">
                <div class="card content d-flex">
                    <div class="card-header d-flex justify-content-between">
                        <span>Door Status (<span id="openDoorCount"><?php echo $database->countOpenDoors(); ?></span> open)</span>
                        <div class="shipment-tabsz">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item door-tabs" role="presentation">
                                    <button class="nav-link active door-tabs" id="southern-doors-tab" data-bs-toggle="tab" data-bs-target="#south" type="button" role="tab" aria-controls="south" aria-selected="true">South</button>
                                </li>
                                <li class="nav-item door-tabs" role="presentation">
                                    <button class="nav-link door-tabs" id="northern-doors-tab" data-bs-toggle="tab" data-bs-target="#north" type="button" role="tab" aria-controls="north" aria-selected="false">North (OC)</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body justify-content-center table-responsive" style="height: 562px;">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="south" role="tabpanel" aria-labelledby="southern-doors">
                                <table class="table table-striped" id="southernDoorsTable">
                                    <thead>
                                        <tr>
                                            <th>Door</th>
                                            <th>Carrier</th>
                                            <th>Trailer</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="north" role="tabpanel" aria-labelledby="northern-doors">
                                <table class="table table-striped" id="northernDoorsTable">
                                    <thead>
                                        <tr>
                                            <th>Door</th>
                                            <th>Carrier</th>
                                            <th>Trailer</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Yard Status Table -->
            <div class="col-sm-3">
                <div class="card content d-flex">
                    <div class="card-header">
                        Yard Status (<span id="yardCount"><?php echo $database->countTrailersInYard(); ?></span>)
                        <span class="card-header-options"></span>
                    </div>
                    <div class="card-body justify-content-center table-responsive" style="height: 562px;">
                        <table class="table table-striped" id="yardTable">
                            <thead>
                                <tr>
                                    <th>Carrier</th>
                                    <th>Trailer</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div> <!-- row end -->
    </div> <!-- container end -->

    <!-- Assignment Popovers -->
    <div id="assign-driver-popover" style="display: none;">
        <div class="assign-driver-choices">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col"><a class="btn btn-mron popover-button-lg2" id="assign-door"><i class="bi bi-truck"></i> Shipment</a></div>
                <div class="col"><a class="btn btn-mron popover-button-lg2" id="assign-yard-moves"><i class="bi bi-arrow-left-right"></i> Moves</a></div>
                <div class="col pt-3"><a class="btn btn-mron popover-button-lg2" id="assign-other"><i class="bi bi-vinyl"></i> Other</a></div>
            </div>
        </div>

        <div class="popover-continuation"></div>
    </div>

    <div id="assign-moves-popover" style="display: none;">
        <div class="row">
            <form class="yardMoveForm" id="yardMoveForm" method="POST" action="" novalidate>
                <div class="move-field">
                    <div class="row d-flex align-items-center justify-content-center" style="height: 70px;" id="assign-move-1">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="trailerNumber" style="margin-left: 1px;">Trailer / Door</label>
                                <input type="text" name="trailerNumber" id="trailerNumber-1" class="form-control" placeholder="" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-sm-2 pt-4">
                            <i class="bi bi-arrow-right" style="font-size: 1.8rem;"></i>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group inline-form">
                                <label for="location" style="margin-left: 1px;">Location</label>
                                <input type="text" name="location" id="location-1" class="form-control" placeholder="" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="extra-move-fields">
                </div>

                <div class="text-center pt-3">
                    <a class="text-mron" href="#" id="addMoves" style="height: 30px;"><i class="bi bi-plus-circle" style="font-size: 1.8rem; color: var(--mron-green); position: relative; bottom: -5px; left: -10px;"></i>Add Yard Move</a>
                </div>

                <div class="error-message text-danger py-2 fw-bold"></div>

                <div class="text-center mt-3">
                    <button class="btn btn-mron" id="send-assignment-button" type="submit">Send Assignment</button>
                </div>
            </form>
        </div>
    </div>

    <div id="assign-driver-cordova-popover" style="display: none;">
        <div class="row">
            <div class="assign-cordova">
                <strong>Product</strong><br />
                10372232&emsp;&emsp;50.7oz Alpla STOK Bottles
                <form class="assignCordovaForm pt-2" id="assignCordovaForm" method="POST" action="" novalidate>
                    <!-- Move Trailer Template -->
                    <div class="cordova-move-field" style="display: none">
                        <div class="row d-flex align-items-center justify-content-center" style="height: 70px;" id="assign-cordova-move-0">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="trailerNumber" style="margin-left: 1px;">Trailer / Door #</label>
                                    <input type="text" name="trailerNumber" id="trailerNumber-0" class="form-control" placeholder="" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="col-md-2 pt-4">
                                <i class="bi bi-arrow-right" style="font-size: 1.8rem;"></i>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group inline-form">
                                    <label for="location" style="margin-left: 1px;">Location</label>
                                    <input type="text" name="location" id="location-0" class="form-control" placeholder="" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Drop Trailer / Take Trailer Template -->
                    <div class="row d-flex align-items-center justify-content-center" style="height: 70px;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dropLocation" style="margin-left: 1px;">Drop Trailer:</label>
                                <input type="text" name="dropLocation" id="dropLocation-1" class="form-control" placeholder="Door # or fence" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group inline-form">
                                <label for="takeTrailer" style="margin-left: 1px;">Take Trailer:</label>
                                <input type="text" name="takeTrailer" id="takeTrailer-1" class="form-control" placeholder="Door # or Fence" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <span class="yard-moves-separator separator pb-1" style="display: none;">Yard Moves</span>

                    <div class="cordova-move-fields"></div>

                    <div class="text-center pt-3">
                        <a class="text-mron" href="#" id="add-moves-cordova" style="height: 30px;"><i class="bi bi-plus-circle" style="font-size: 1.8rem; color: var(--mron-green); position: relative; bottom: -5px; left: -10px;"></i>Add Yard Move</a>
                    </div>

                    <div class="error-message text-danger py-2 fw-bold"></div>

                    <div class="text-center mt-3">
                        <button class="btn btn-mron" id="send-assignment-button-cordova" type="submit">Send Assignment</button>
                    </div>
                </form>
            </div>

            <div class="popover-continuation-cordova"></div>
        </div>
    </div>

    <div id="assign-other-popover" style="display: none;">
        What would you like DRIVER to do?
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-sm-6 text-center p-3">
                <a class="btn btn-mron" id="bring-empty">Bring Empty</a>
            </div>
            <div class="col-sm-6 text-center p-3">
                <a class="btn btn-mron" id="pickup-backhaul">Get Backhaul</a>
            </div>
            <div class="col-sm-6 text-center p-3">
                <a class="btn btn-mron" id="rescue-shipment">Rescue Shipment</a>
            </div>
            <div class="col-sm-6 text-center p-3">
                <a class="btn btn-mron disabled" id="take-oos-trailer">Take OOS Trailer</a>
            </div>
        </div>

        <div class="assign-empty-facilities" style="display: none;">
            Where should DRIVER get an empty trailer from?
            <div class="row d-flex align-items-center justify-content-center pt-2">
                <div class="col-sm-6 text-center p-3">
                    <a class="btn btn-mron pu-empty" data-facility="accoi">ACCOI</a>
                </div>
                <div class="col-sm-6 text-center p-3">
                    <a class="btn btn-mron pu-empty" data-facility="acont">ACONT</a>
                </div>
                <div class="col-sm-6 text-center p-3">
                    <a class="btn btn-mron pu-empty" data-facility="lineage">Lineage</a>
                </div>
                <div class="col-sm-6 text-center p-3">
                    <a class="btn btn-mron pu-empty" data-facility="nrt">NRT Yard</a>
                </div>
            </div>
        </div>

        <div class="assign-backhaul-facilities" style="display: none;">
            Where should DRIVER get a backhaul from?
            <div class="row d-flex align-items-center justify-content-center pt-2">
                <div class="col-sm-4 text-center p-3">
                    <a class="btn btn-mron pu-backhaul" data-facility="accoi">ACCOI</a>
                </div>
                <div class="col-sm-4 text-center p-3">
                    <a class="btn btn-mron pu-backhaul" data-facility="acont">ACONT</a>
                </div>
                <div class="col-sm-4 text-center p-3">
                    <a class="btn btn-mron pu-backhaul" data-facility="lineage">Lineage</a>
                </div>
            </div>
        </div>
    </div>

    <div class="assign-rescue-popover" style="display: none;">
        What shipment should DRIVER go rescue?
        <div class="row d-flex align-items-center justify-content-center pt-2">
            <div class="col-sm-6 text-center p-3">
                <a class="btn btn-mron pu-shipment" id="5012802599" data-facility="nrt">5012802599</a>
            </div>
        </div>
    </div>

    <div class="assign-oos-trailer-popover" style="display: none;">
        What trailer should DRIVER take to the shop?
        <div class="row d-flex align-items-center justify-content-center pt-2">
            <div class="col-sm-6 text-center p-3">
                <a class="btn btn-mron pu-empty" id="">????</a>
            </div>
        </div>
    </div>

    <div id="assign-door-popover" style="display: none;">
        Where should DRIVER put their trailer?
        <div class="col text-center p-3">
            <a class="btn btn-mron popover-button drop-trailer" data-door="sb">S/B</a>
        </div>
        <div class="row d-flex align-items-center justify-content-center" id="available-doors"></div>
    </div>

    <div id="shipment-ready-popover" style="display: none;">
        Do you have a shipment ready for DRIVER?
        <div class="row d-flex justify-content-center align-items-center pt-3">
            <div class="col-sm-4"><a class="btn btn-mron" id="yes-shipment">Yes</a></div>
            <div class="col-sm-4"><a class="btn btn-secondary" id="no-shipment">No</a></div>
        </div>
    </div>

    <div id="assign-shipment-popover" style="display: none;">
        What door or trailer should DRIVER hook up to?
        <div class="row d-flex align-items-center justify-content-center" id="availableShipments"></div>
    </div>

    <!-- Set Shipment Target Modal -->
    <div class="modal fade" id="setShipmentTargetModal" tabindex="-1" role="dialog" aria-labelledby="setShipmentTargetModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title">Shipment Targets</p>
                    <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg" style="font-size: 1.1rem; color: var(--light-text-color);"></i></button>
                </div>
                <div class="modal-body">
                    <div class="row gx-3 gy-2 d-flex align-items-center justify-content-around">
                        <div class="col-sm-7">
                            <label for="shipment-target-accoi" class="fw-bold">Americold COI</label>
                        </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control target mx-5 text-center" id="shipment-target-accoi" name="shipment-target-accoi" style="width: 60%;" placeholder="0" autocomplete="off" value="<?php echo $config['targets']['accoi']; ?>" autofocus>
                        </div>

                        <div class="col-sm-7">
                            <label for="shipment-target-acont" class="fw-bold">Americold Ontario</label>
                        </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control target mx-5 text-center" id="shipment-target-acont" name="shipment-target-acont" style="width: 60%;" placeholder="0" autocomplete="off" value="<?php echo $config['targets']['acont']; ?>" autofocus>
                        </div>

                        <div class="col-sm-7">
                            <label for="shipment-target-lineage" class="fw-bold">Lineage Riverside</label>
                        </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control target mx-5 text-center" id="shipment-target-lineage" name="shipment-target-lineage" style="width: 60%;" placeholder="0" autocomplete="off" value="<?php echo $config['targets']['lineage']; ?>" autofocus>
                        </div>
                    </div>

                    <div class="text-center pt-4" id="modalErrors"></div>

                    <div class="text-end pt-2">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-sm btn-mron" id="saveTargetShipments">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Driver Modal -->
    <div class="modal fade" id="assignDriverModal" tabindex="-1" role="dialog" aria-labelledby="assignDriverModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title">Assigning DRIVER</p>
                    <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg" style="font-size: 1.1rem; color: var(--light-text-color);"></i></button>
                </div>
                <div class="modal-body">
                    <div class="row d-flex justify-content-between align-items-center">
                        <p class="text-center fw-bold">What would you like DRIVER to do?</p>
                        <div class="col text-center">
                            <a class="btn btn-mron popover-button-lg3" id="assign-door"><i class="bi bi-door-closed"></i> Drop Trailer</a>
                        </div>
                        <div class="col text-center">
                            <a class="btn btn-mron popover-button-lg3" onclick="$('#lol').show();"><i class="bi bi-truck"></i> Take Shipment</a>
                        </div>
                        <div class="col text-center">
                            <a class="btn btn-mron popover-button-lg3" id="assign-yard-moves"><i class="bi bi-arrow-left-right"></i> Yard Moves</a>
                        </div>
                        <div class="col text-center">
                            <a class="btn btn-mron popover-button-lg3" id="assign-other"><i class="bi bi-vinyl"></i> Other</a>
                        </div>
                    </div>

                    <div style="display: none; padding: 50px 0;" id="lol">
                        <p class="text-center fw-bold">What trailer or door should DRIVER hook up to?</p>
                        <div class="row d-flex justify-content-between align-items-center">
                            <div class="col text-center p-3 pt-2">
                                <a class="btn btn-mron popover-button drop-trailer" data-door="${door}">D3</a>
                            </div>
                            <div class="col text-center p-3 pt-2">
                                <a class="btn btn-mron popover-button drop-trailer" data-door="${door}">D7</a>
                            </div>
                            <div class="col text-center p-3 pt-2">
                                <a class="btn btn-mron popover-button drop-trailer" data-door="${door}">D12</a>
                            </div>
                            <div class="col text-center p-3 pt-2">
                                <a class="btn btn-mron popover-button drop-trailer" data-door="${door}">D15</a>
                            </div>
                            <div class="col text-center p-3 pt-2">
                                <a class="btn btn-mron popover-button-lg2 drop-trailer" data-door="${door}">S/B - 50263</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>