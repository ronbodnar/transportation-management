<?php

require '../../../header.php';

?>

<?php if (isLoggedIn()) { ?>
    <div class="container-fluid pt-3">
        <div class="overlay-inner">
            <h3 class="text-light align-self-left fw-bold">Analytics Overview</h3>
            <div id="date-range" style="position: absolute; top: 6px; right: 30px; text-align: center;">
                <span style="color: var(--mron-white);">Select a date range:</span>
                <div id="reportrange" style="background: var(--input-background-color); cursor: pointer; padding: 5px 10px; border: 1px solid var(--radio-outline-color); border-radius: 5px; font-size: 0.8rem; width: 100%">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card content d-flex">
                    <div class="card-header">
                        Average Time Spent at Warehouses
                        <span class="text-mron" style="cursor: help;" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" title="The calculation of <strong>average time spent at warehouses</strong> is determined using the difference of time between a driver indicating that they have arrived at a 
                        warehouse and the time that the driver departs from a warehouse.
                        <br /><br />
                        Utilizing this data, it is possible to determine the <strong>precise</strong> time spent waiting by a driver as well as time spent waiting 
                        at a specific warehouse. Since the data collection is recorded for every day and every shipment, it is possible to see historical data 
                        and to compare wait times from one period to another at ease."><i class="bi bi-question-circle"></i></span>
                        <div class="dropdown">
                            <span class="card-header-options" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></span>
                            <ul class="dropdown-menu text-small shadow">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-download" style="padding-right: 15px;"></i>Export CSV</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body chart-container justify-content-center">
                        <canvas id="waitTimeChart" style="height: 300px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card content d-flex">
                    <div class="card-header">
                        Warehouse Utilization
                        <span class="text-mron" style="cursor: help;" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" title="<strong>Warehouse Utilization</strong> is collected using shipments that were assigned by Danone. All shipments 
                        have a destination warehouse attached to them. Utilizing this data, a percentage of shipments received per warehouse can be obtained.
                        <br /><br />
                        Access to such information, combined with <strong>wait times</strong> of said warehouses can offer insights into warehouse performance and 
                        where adjustments can be made, if necessary."><i class="bi bi-question-circle"></i></span>
                        <div class="dropdown">
                            <span class="card-header-options" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></span>
                            <ul class="dropdown-menu text-small shadow">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-download" style="padding-right: 15px;"></i>Export CSV</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body chart-container justify-content-center">
                        <canvas id="facilityChart" style="height: 300px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card content d-flex">
                    <div class="card-header">
                        Average Time Waiting for Instructions
                        <span class="text-mron" style="cursor: help;" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" title="The calculation of <strong>average time waiting for instructions</strong> is determined using the difference of time between a driver indicating that they have arrived at a 
                        warehouse and the time that the warehouse sends instructions to a driver.
                        <br /><br />
                        Utilizing this data, it is possible to determine the <strong>precise</strong> time spent waiting by a driver as well as time spent waiting 
                        for a specific warehouse to assign instructions. Since the data collection is recorded for every day and every shipment, it is possible to see historical data 
                        and to compare wait times from one period to another at ease."><i class="bi bi-question-circle"></i></span>
                        <div class="dropdown">
                            <span class="card-header-options" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></span>
                            <ul class="dropdown-menu text-small shadow">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-download" style="padding-right: 15px;"></i>Export CSV</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body chart-container justify-content-center">
                        <canvas id="timeWaitingForInstructionsChart" style="height: 300px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card content d-flex">
                    <div class="card-header">
                        Average Time Completing Instructions
                        <span class="text-mron" style="cursor: help;" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" title="The calculation of <strong>average time completing instructions</strong> is determined using the difference of time between a driver indicating that they have accepted instructions  
                        from a warehouse and the time that the driver departs from a warehouse.
                        <br /><br />
                        Utilizing this data, it is possible to determine the <strong>precise</strong> time spent performing moves by a driver as well as time spent waiting 
                        at a specific warehouse. Combined with an automated flagging system, utilization of this data will provide insights into driver habits. Since the data collection is recorded for every day and every shipment, it is possible to see historical data 
                        and to compare wait times from one period to another at ease."><i class="bi bi-question-circle"></i></span>
                        <div class="dropdown">
                            <span class="card-header-options" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></span>
                            <ul class="dropdown-menu text-small shadow">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-download" style="padding-right: 15px;"></i>Export CSV</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body chart-container justify-content-center">
                        <canvas id="timeCompletingInstructionsChart" style="height: 300px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card content d-flex">
                    <div class="card-header">
                        Time Utilization
                        <span class="text-mron" style="cursor: help;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="The summary of <strong>time utilization</strong> is a collective structure supported by data that is collected using driver and warehouse input. 
                        This is an alternative approach to monitor how warehouses are processing drivers and where improvements or changes can be made, with the data 
                        to back it up.
                        <br /><br />
                        <strong>As of now, the visualized data includes time spent:</strong>
                        <ul class='pt-2'>
                            <li syle='list-style-type: circle;'>Driving shipments from Danone.</li>
                            <li syle='list-style-type: circle;'>Driving and waiting for backhauls from warehouses.</li>
                            <li syle='list-style-type: circle;'>Waiting for a shipment or waiting for a door.</li>
                            <li syle='list-style-type: circle;'>Completing yard moves or instructions.</li>
                        </ul>
                        <strong>That data is collected based on the following:</strong>
                        <ul class='pt-2'>
                            <li syle='list-style-type: circle;'>The time between a driver leaving a warehouse until they arrive at their destination.</li>
                            <li syle='list-style-type: circle;'>The time between a driver leaving a warehouse after being assigned a backhaul until arrival at destination.</li>
                            <li syle='list-style-type: circle;'>The time between a driver arriving at a warehouse and the time a driver is given instructions.</li>
                            <li syle='list-style-type: circle;'>The time between a driver receiving instructions and a driver completing said instructions.</li>
                        </ul>
                        Due to the vast amount of data collected, Time Utilization can be updated at any time to reflect data that Danone would like to see."><i class="bi bi-question-circle"></i></span>
                        <div class="dropdown">
                            <span class="card-header-options" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></span>
                            <ul class="dropdown-menu text-small shadow">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-download" style="padding-right: 15px;"></i>Export CSV</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body chart-container justify-content-center">
                        <canvas id="timeUtilizationChart" style="height: 300px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card content d-flex">
                    <div class="card-header">
                        Shipments Fulfilled
                        <span class="text-mron" style="cursor: help;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="The collection of shipment data is vital to providing insights and trends relating to all shipments. This data is retrieved any time a driver 
                        is assigned a shipment either through the Danone dashboard or from the fulfillment center dashboards. When a driver is assigned a shipment or a backhaul, 
                        the basic shipment data is updated to include a vast array of information. This is especially helpful should an issue arise, or verification is needed.
                        <br /><br />
                        <strong>This information currently includes:</strong>
                        <ul class='pt-2'>
                            <li syle='list-style-type: circle;'>Driver details</li>
                            <li syle='list-style-type: circle;'>Product details</li>
                            <li syle='list-style-type: circle;'>Internal shipment details</li>
                            <li syle='list-style-type: circle;'>Signed Bill of Lading images</li>
                            <li syle='list-style-type: circle;'>Exact arrival & delivery times</li>
                            <li syle='list-style-type: circle;'>Drop location (assigned door by warehouse)</li>
                            <li syle='list-style-type: circle;'>Trailer number confirmation</li>
                        </ul>
                        Information related to shipments can be updated to collect any other necessary data at any given time, and due to the nature of collection, 
                        any and all historical shipment data will be available for viewing at any time. This will allow for verification or action to be taken, should 
                        there be any future issues with a shipment."><i class="bi bi-question-circle"></i></span>
                        <div class="dropdown">
                            <span class="card-header-options" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></span>
                            <ul class="dropdown-menu text-small shadow">
                                <li><button type="button" class="dropdown-item" id="toggle-facilities"><i class="bi bi-toggles" style="padding-right: 15px;"></i>Toggle Warehouses</button></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-download" style="padding-right: 15px;"></i>Export CSV</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body chart-container justify-content-center">
                        <canvas id="shipmentsChart" style="height: 300px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else {
    include '../login-form.php';
} ?>

<?php include '../../../footer.php'; ?>