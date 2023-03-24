<?php

require '../header.php';

if (!isLoggedIn()) {
    include '../login-form.php';
} else { ?>
    <div class="container-fluid pt-4">
        <div class="overlay-inner">
            <h3 class="text-light text-center fw-bold">Benefits</h3>
        </div>
        <div class="row d-flex align-content-center justify-content-center" style="margin-top: -10px;">
            <div class="col-md-6">
                <div class="card content">
                    <div class="card-header fs-5">
                        Overview
                    </div>
                    <div class="card-body" style="font-size: 0.9rem; min-height: 650px;">
                        Using an in-house software engineer provides the company with highly specialized software that is specifically designed with Danone's needs in mind.
                        Utilizing an in-house software engineer can drastically increase production and profitability in a business. The difference in what I can provide and what
                        third party solutions provide is immensely beneficial for operations, including, but not limited to: <strong>knowledge</strong>, <strong>familiarity</strong>,
                        <strong>specialization</strong>, and <strong>cost effectiveness</strong>.
                        <br /><br />
                        <strong>Knowledge</strong>
                        <br />
                        I have 6 years of combined logistics and warehouse experience - notably managing shipments, data, and workflow. I understand how every aspect
                        of logistics has to come together for maximum profitability and recognize ways that softwares can be implemented to exceed profit goals. This software
                        is just the start.
                        <br /><br />
                        <strong>Familiarity</strong>
                        <br />
                        I have been driving dedicated on the Danone account for nearly 2 years and understand procedures for drivers and facility interactions.
                        Knowing where potential driver and logistics improvements can be made for logistics to run efficiently across the board.
                        This software is the solution for that will support a majority of issues.
                        <br /><br />
                        <strong>Specialization</strong>
                        <br />
                        With my knowledge and familiarity with the Danone workflow, I began developing this <strong>highly specialized software</strong> to show just what is
                        possible when a software engineer truly <strong>understands</strong> and <strong>cares</strong> about the needs of a business. This is not a generic
                        Warehouse Management System or Transportation Management System, and as such, can and will be modified in the future to include any possible functions
                        or features that Danone or myself feel would improve the overall <strong>ease</strong> and <strong>efficiency</strong> of employees and contractors
                        alike. Third party softwares are <strong>not specialized</strong> and therefore <strong>can not</strong> provide this functionality.
                        <br /><br />
                        <strong>Cost Effectiveness</strong>
                        <br />
                        Let's be real - third party software costs <strong>a lot</strong> of money and do not meet <strong>all of a company's needs</strong>, leading to inefficient workflow
                        or multiple software contracts - resulting in even more expenses. As an in-house software engineer, I will be able to develop and integrate softwares, and
                        data collection and visualization to the <strong>exact needs</strong> and <strong>financial benefit</strong> of Danone, all at a <strong>lower cost</strong> and quicker <strong>turnaround time</strong>.
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card content">
                    <div class="card-header fs-5">
                        Key Benefits
                    </div>
                    <div class="card-body" style="font-size: 0.9rem; min-height: 650px;">
                        <strong>Danone:</strong>
                        <ul class="pt-2">
                            <li syle="list-style-type: circle;">More shipments per day through advanced check-in procedures and a flagging system for drivers who arrive late on purpose or buy time.</li>
                            <li syle="list-style-type: circle;">Notification system to ensure an action is never gone unnoticed.</li>
                            <li syle="list-style-type: circle;">Substantially reduce number of errors due to miscommunication.</li>
                            <li syle="list-style-type: circle;">Automated management of door statuses and trailers in the yard.</li>
                            <li syle="list-style-type: circle;">Consolidated overview of all doors, drivers, shipments, and trailers available in the yard.</li>
                            <li syle="list-style-type: circle;">Assign drivers yard moves, shipments, and tasks at the click of a button.</li>
                            <li syle="list-style-type: circle;">Detailed time logs for every action relating to a shipment, from assignment to completion.</li>
                            <li syle="list-style-type: circle;">Flagging system when driver is detected abusing time, resulting in less shipments per day.</li>
                            <li syle="list-style-type: circle;">Trip estimate system for Logistics Lead to determine if driver is able to complete a shipment on time.</li>
                            <li syle="list-style-type: circle;">Detailed records of all trailers brought to Danone - preventing extra work or lost product due to defective trailers.</li>
                            <li syle="list-style-type: circle;">Streamlined check-in and instruction process for Northern and 3PL drivers, resulting in less stress for the logistic lead during inevitable driver pile-ups.</li>
                        </ul>

                        <div class="pt-3">
                            <strong>Drivers:</strong>
                            <ul class="pt-2">
                                <li syle="list-style-type: circle;">Easy to use, user-friendly application.</li>
                                <li syle="list-style-type: circle;">Drastically reduce time spent checking in and logging arrival / departure times.</li>
                                <li syle="list-style-type: circle;">No distracting phone calls or second guessing instructions - it's all available on the app.</li>
                                <li syle="list-style-type: circle;">Reduce or eliminate time lost due to long check-in processing, resulting in more shipments per day.</li>
                                <li syle="list-style-type: circle;">Ability to send daily activity log (trip sheet) to Northern, eliminating paperwork, if Danone approves.</li>
                            </ul>
                        </div>

                        <div class="pt-3">
                            <strong class="pt-5">Facilities:</strong>
                            <ul class="pt-2">
                                <li syle="list-style-type: circle;">Easily assign drivers: doors, yard moves, backhauls, or empty trailers.</li>
                                <li syle="list-style-type: circle;">Advanced warning of drivers arriving with a shipment, to prepare yard moves or backhauls.</li>
                                <li syle="list-style-type: circle;">Detailed history of shipments received, including: driver name, door given, and BOL images.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card content">
                    <div class="card-header fs-5">
                        Time Efficiency
                    </div>
                    <div class="card-body" style="font-size: 0.9rem; min-height: 125px;">
                        Proper utilization of this specialized software will result in strict time management and performance increases for all parties.
                        Since this software was designed with Danone logistics, drivers, and facilities in mind; it is aimed at providing a streamlined process across the board
                        and reduce time lost due to mistakes and inefficient practices.
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card content">
                    <div class="card-header fs-5">
                        Data Visualization
                    </div>
                    <div class="card-body" style="font-size: 0.9rem; min-height: 125px;">
                        Through technology and data collection, visualized data can be utilized to provide insights on how logistics are running. With the level of scalability
                        provided in such a software, future analytics are a breeze to visualize, and new data collection can be implemented at any time, providing an even closer
                        look into any hiccups or performance issues that can be addressed to further profitability.
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card content">
                    <div class="card-header fs-5">
                        Profit Realization
                    </div>
                    <div class="card-body" style="font-size: 0.9rem; min-height: 125px;">
                        It is inevitable that an individual would not be able to identify small details that contribute to profitability. A software increases functionality which
                        can identify areas that are missed by individuals. One method of this is a flagging system which will provide reports when drivers are flagged doing
                        actions that cost money. Some actions include the following: extended periods of time wasted, not checking in when arriving, and repeatedly bringing
                        broken trailers
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card content">
                    <div class="card-header fs-5">
                        Historical Data
                    </div>
                    <div class="card-body" style="font-size: 0.9rem; min-height: 125px;">
                        Issues can arise with a shipment; whether it be before leaving the door, while it's in-transit, or even months or years from a delivery date. It's important to be
                        able to see every detail relating to a shipment, regardless of where its at or when it was delivered. All of this is possible with historial data retention
                        and was intuitively designed to be as simple as possible. Historical driver data is also available.
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
}
include '../footer.php'; ?>