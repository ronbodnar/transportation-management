<?php

require '../header.php';

if (!isLoggedIn()) {
    include '../login-form.php';
} else { ?>
    <div class="container-fluid pt-4">
        <div class="overlay-inner">
            <h3 class="text-light text-center fw-bold">Data Sources</h3>
        </div>
        <div class="row d-flex align-content-center justify-content-center" style="margin-top: -10px;">
            <div class="col-md-6">
                <div class="card content d-flex">
                    <div class="card-header fs-5">
                        Wait Times
                    </div>
                    <div class="card-body" style="font-size: 0.9rem; min-height: 150px;">
                        The calculation of <strong>wait times</strong> is determined using the difference of time between a driver indicating that they have arrived at a 
                        facility and the time that the driver was given instructions by a facility.
                        <br /><br />
                        Utilizing this data, it is possible to determine the <strong>precise</strong> time spent waiting by a driver as well as time spent waiting 
                        at a specific facility. Since the data collection is recorded for every day and every shipment, it is possible to see historical data 
                        and to compare wait times from one period to another at ease.
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card content d-flex">
                    <div class="card-header fs-5">
                        Facility Utilization
                    </div>
                    <div class="card-body" style="font-size: 0.9rem; min-height: 150px;">
                        <strong>Facility Utilization</strong> is collected using shipments that were assigned by Danone. All shipments 
                        have a destination facility attached to them. Utilizing this data, a percentage of shipments received per facility can be obtained.
                        <br /><br />
                        Access to such information, combined with <strong>wait times</strong> of said facilities can offer insights into facility performance and 
                        where adjustments can be made, if necessary.
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card content d-flex">
                    <div class="card-header fs-5">
                        Time Utilization
                    </div>
                    <div class="card-body" style="font-size: 0.9rem; min-height: 450px;">
                        The summary of <strong>time utilization</strong> is a collective structure supported by data that is collected using driver and facility input. 
                        This is an alternative approach to monitor how facilities are processing drivers and where improvements or changes can be made, with the data 
                        to back it up.
                        <br /><br />
                        <strong>As of now, the visualized data includes time spent:</strong>
                        <ul class="pt-2">
                            <li syle="list-style-type: circle;">Driving shipments from Danone.</li>
                            <li syle="list-style-type: circle;">Driving and waiting for backhauls from facilities.</li>
                            <li syle="list-style-type: circle;">Waiting for a shipment or waiting for a door.</li>
                            <li syle="list-style-type: circle;">Completing yard moves or instructions.</li>
                        </ul>
                        <strong>That data is collected based on the following:</strong>
                        <ul class="pt-2">
                            <li syle="list-style-type: circle;">The time between a driver leaving a facility until they arrive at their destination.</li>
                            <li syle="list-style-type: circle;">The time between a driver leaving a facility after being assigned a backhaul until arrival at destination.</li>
                            <li syle="list-style-type: circle;">The time between a driver arriving at a facility and the time either Danone or a facility assign a shipment, or door, respectively.</li>
                            <li syle="list-style-type: circle;">The time between a driver receiving instructions and a driver completing said instructions.</li>
                        </ul>
                        Due to the vast amount of data collected, Time Utilization can be updated at any time to reflect data that Danone would like to see.
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card content d-flex">
                    <div class="card-header fs-5">
                        Shipment Fulfillment
                    </div>
                    <div class="card-body" style="font-size: 0.9rem; min-height: 450px;">
                        The collection of shipment data is vital to providing insights and trends relating to all shipments. This data is retrieved any time a driver 
                        is assigned a shipment either through the Danone dashboard or from the fulfillment center dashboards. When a driver is assigned a shipment or a backhaul, 
                        the basic shipment data is updated to include a vast array of information. This is especially helpful should an issue arise, or verification is needed.
                        <br /><br />
                        <strong>This information currently includes:</strong>
                        <ul class="pt-2">
                            <li syle="list-style-type: circle;">Driver details</li>
                            <li syle="list-style-type: circle;">Product details</li>
                            <li syle="list-style-type: circle;">Internal shipment details</li>
                            <li syle="list-style-type: circle;">Signed Bill of Lading images</li>
                            <li syle="list-style-type: circle;">Exact arrival & delivery times</li>
                            <li syle="list-style-type: circle;">Drop location (assigned door by facility)</li>
                            <li syle="list-style-type: circle;">Trailer number confirmation</li>
                        </ul>
                        Information related to shipments can be updated to collect any other necessary data at any given time, and due to the nature of collection, 
                        any and all historical shipment data will be available for viewing at any time. This will allow for verification or action to be taken, should 
                        there be any future issues with a shipment.

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
}
include '../footer.php'; ?>