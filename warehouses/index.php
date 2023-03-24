<?php

require '../header.php';

?>

<?php if (isLoggedIn()) { ?>
    <div class="container-fluid pt-3">
        <div class="overlay-inner">
            <h3 class="text-light align-self-left fw-bold">Dashboard</h3>
        </div>
        <div class="shipment-tabs rowz d-flexz justify-content-centerz">
            <div class="col-md-6">
                <ul class="nav nav-tabs d-flexz justify-content-centerz" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="inbound-shipments-tab" data-bs-toggle="tab" data-bs-target="#inbound" type="button" role="tab" aria-controls="inbound" aria-selected="true">Inbound Shipments</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="received-shipments-tab" data-bs-toggle="tab" data-bs-target="#received" type="button" role="tab" aria-controls="received" aria-selected="false">Received Shipments</button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="inbound" role="tabpanel" aria-labelledby="inbound-shipments-tab">
                <div class="row d-flex align-content-center justify-content-center">
                    <div class="col-md-12">
                        <div class="card content d-flex">
                            <div class="card-header">
                                Inbound Shipments
                                <span class="card-header-options"></span>
                            </div>
                            <div class="card-body justify-content-center table-responsive">
                                <table class="table table-striped" id="inboundShipmentsTable">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Driver</th>
                                            <th>Images</th>
                                            <th>Order Number</th>
                                            <th>Shipment ID</th>
                                            <th>Pallets</th>
                                            <th>Weight</th>
                                            <th>Hold</td>
                                            <th>Action</td>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td>2/13/2023</td>
                                            <td>3:07 PM</td>
                                            <td>Anthony Torres</td>
                                            <td><a class="text-mron" href="bol-1.png" target="_blank">1</a> | <a class="text-mron" href="bol-2.png" target="_blank">2</a> | <a class="text-mron" href="bol-3.png" target="_blank">3</a></td>
                                            <td>4503477321</td>
                                            <td>5012457224</td>
                                            <td>20</td>
                                            <td>36,661</td>
                                            <td><span class="badge rounded-pill" style="background-color: #4b9307;">Yes</span></td>
                                            <td><a class="text-mron" href="" data-toggle="popover-assign" data-bs-placement="left" data-type="warehouse" data-index="1" data-driver-name="Anthony Torres">Assign</a></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>2/13/2023</td>
                                            <td>3:17 PM</td>
                                            <td>Ron Bodnar</td>
                                            <td><a class="text-mron" href="bol-1.png" target="_blank">1</a> | <a class="text-mron" href="bol-2.png" target="_blank">2</a>
                                            <td>4503478834</td>
                                            <td>5012450931</td>
                                            <td>20</td>
                                            <td>36,661</td>
                                            <td><span class="badge rounded-pill" style="background-color: #4b9307;">Yes</span></td>
                                            <td><a class="text-mron" href="" data-toggle="popover-assign" data-bs-placement="left" data-type="warehouse" data-index="2" data-driver-name="Ron Bodnar">Assign</a></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>2/13/2023</td>
                                            <td>3:38 PM</td>
                                            <td>Matt Van Vleet</td>
                                            <td><a class="text-mron" href="bol-1.png" target="_blank">1</a> | <a class="text-mron" href="bol-2.png" target="_blank">2</a> | <a class="text-mron" href="bol-3.png" target="_blank">3</a></td>
                                            <td>4503479013</td>
                                            <td>5012451837</td>
                                            <td>24</td>
                                            <td>43,401</td>
                                            <td><span class="badge rounded-pill" style="background-color: #ef716f;">No</span></td>
                                            <td><a class="text-mron" href="" data-toggle="popover-assign" data-bs-placement="left" data-type="warehouse" data-index="3" data-driver-name="Matt Van Vleet">Assign</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="received" role="tabpanel" aria-labelledby="received-shipments-tab">
                <div class="row d-flex align-content-center justify-content-center">
                    <div class="col-md-12">
                        <div class="card content d-flex">
                            <div class="card-header">
                                Received Shipments
                                <div class="dropdown">
                                    <span class="card-header-options" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></span>
                                    <ul class="dropdown-menu text-small shadow">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-download" style="padding-right: 15px;"></i>Export CSV</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body justify-content-center table-responsive">
                                <table class="table table-striped" id="receivedShipmentsTable">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Driver</th>
                                            <th>Images</th>
                                            <th>Order Number</th>
                                            <th>Shipment ID</th>
                                            <th>Pallets</th>
                                            <th>Weight</th>
                                            <th>Hold</td>
                                            <th>Drop Location</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td>2/13/2023</td>
                                            <td>3:07 PM</td>
                                            <td>Anthony Torres</td>
                                            <td><a class="text-mron" href="bol-1.png" target="_blank">1</a> | <a class="text-mron" href="bol-2.png" target="_blank">2</a> | <a class="text-mron" href="bol-3.png" target="_blank">3</a></td>
                                            <td>4503477321</td>
                                            <td>5012457224</td>
                                            <td>20</td>
                                            <td>36,661</td>
                                            <td><span class="badge rounded-pill" style="background-color: #4b9307;">Yes</span></td>
                                            <td>Door 22</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>2/13/2023</td>
                                            <td>3:17 PM</td>
                                            <td>Ron Bodnar</td>
                                            <td><a class="text-mron" href="bol-1.png" target="_blank">1</a> | <a class="text-mron" href="bol-2.png" target="_blank">2</a>
                                            <td>4503478834</td>
                                            <td>5012450931</td>
                                            <td>20</td>
                                            <td>36,661</td>
                                            <td><span class="badge rounded-pill" style="background-color: #4b9307;">Yes</span></td>
                                            <td>Door 8</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>2/13/2023</td>
                                            <td>3:38 PM</td>
                                            <td>Matt Van Vleet</td>
                                            <td><a class="text-mron" href="bol-1.png" target="_blank">1</a> | <a class="text-mron" href="bol-2.png" target="_blank">2</a> | <a class="text-mron" href="bol-3.png" target="_blank">3</a></td>
                                            <td>4503479013</td>
                                            <td>5012451837</td>
                                            <td>24</td>
                                            <td>43,401</td>
                                            <td><span class="badge rounded-pill" style="background-color: #ef716f;">No</span></td>
                                            <td>Door 11</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>2/13/2023</td>
                                            <td>2:07 PM</td>
                                            <td>Carlos Quintero</td>
                                            <td><a class="text-mron" href="bol-1.png" target="_blank">1</a> | <a class="text-mron" href="bol-2.png" target="_blank">2</a> | <a class="text-mron" href="bol-3.png" target="_blank">3</a></td>
                                            <td>4503472441</td>
                                            <td>5012455354</td>
                                            <td>20</td>
                                            <td>36,661</td>
                                            <td><span class="badge rounded-pill" style="background-color: #4b9307;">Yes</span></td>
                                            <td>Door 36</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>2/13/2023</td>
                                            <td>2:17 PM</td>
                                            <td>Roger Diaz</td>
                                            <td><a class="text-mron" href="bol-1.png" target="_blank">1</a> | <a class="text-mron" href="bol-2.png" target="_blank">2</a>
                                            <td>4503475462</td>
                                            <td>5012455467</td>
                                            <td>20</td>
                                            <td>36,661</td>
                                            <td><span class="badge rounded-pill" style="background-color: #4b9307;">Yes</span></td>
                                            <td>Fence</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>2/13/2023</td>
                                            <td>2:38 PM</td>
                                            <td>Brent Pamplin</td>
                                            <td><a class="text-mron" href="bol-1.png" target="_blank">1</a> | <a class="text-mron" href="bol-2.png" target="_blank">2</a> | <a class="text-mron" href="bol-3.png" target="_blank">3</a></td>
                                            <td>4503472155</td>
                                            <td>5012456782</td>
                                            <td>24</td>
                                            <td>43,401</td>
                                            <td><span class="badge rounded-pill" style="background-color: #ef716f;">No</span></td>
                                            <td>Door 1</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    
    <div id="assign-warehouse-popover" style="display: none;">
        <div class="row">
            <div class="assign-warehouse">
                <form class="assignWarehouseForm" id="assignWarehouseForm" method="POST" action="" novalidate>
                    <!-- Move Trailer Template -->
                    <div class="warehouse-move-field" style="display: none">
                        <div class="row d-flex align-items-center justify-content-center" style="height: 70px;" id="assign-warehouse-move-0">
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

                    <div class="warehouse-move-fields">
                    </div>

                    <div class="text-center pt-3">
                        <a class="text-mron" href="#" id="add-moves-warehouse" style="height: 30px;"><i class="bi bi-plus-circle" style="font-size: 1.8rem; color: var(--mron-green); position: relative; bottom: -5px; left: -10px;"></i>Add Yard Move</a>
                    </div>

                    <div class="error-message text-danger py-2 fw-bold"></div>

                    <div class="text-center mt-3">
                        <button class="btn btn-mron" id="send-assignment-button-warehouse" type="submit">Send Assignment</button>
                    </div>
                </form>
            </div>

            <div class="popover-continuation-warehouse"> </div>
        </div>
    </div>
<?php } else {
    include '../login-form.php';
} ?>
</div>

<?php include '../footer.php'; ?>