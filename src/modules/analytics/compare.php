<?php

require '../../header.php';

?>

<?php if (isLoggedIn()) { ?>
    <div class="container-fluid pt-3">
        <div class="overlay-inner">
            <h3 class="text-light align-self-left fw-bold">Analytics Comparison</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card content d-flex">
                    <div class="card-header">
                        <div class="row d-flex justify-content-between align-items-center px-4 pt-2">
                            <div class="col-md-3">
                                What metric would you like to compare?
                                <div class="dropdown">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" role="button" id="compareMetricButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Select a metric
                                    </button>

                                    <ul class="dropdown-menu" id="compareMetricDropdown" aria-labelledby="dropdownMenuLink">
                                        <li><button type="button" class="dropdown-item" id="shipmentsCompleted">Shipments Completed</button></li>
                                        <li><button type="button" class="dropdown-item" id="waitTimes">Average Overall Wait Time</button></li>
                                        <li><button type="button" class="dropdown-item" id="waitTimes">Average Instruction Wait Time</button></li>
                                        <li><button type="button" class="dropdown-item" id="waitTimes">Average Instruction Completion Time</button></li>
                                    </ul>
                                </div>

                                <div class="pt-3" id="compareFacility" style="display: none;">
                                    What warehouse would you like to compare?
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-secondary dropdown-toggle" role="button" id="compareFacilityButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            All Warehouses
                                        </button>

                                        <ul class="dropdown-menu" id="compareFacilityDropdown" aria-labelledby="dropdownMenuLink">
                                            <li><button type="button" class="dropdown-item" id="all">All Warehouses</button></li>
                                            <li><button type="button" class="dropdown-item" id="accoi">Americold COI</button></li>
                                            <li><button type="button" class="dropdown-item" id="acont">Americold Ontario</button></li>
                                            <li><button type="button" class="dropdown-item" id="lineage">Lineage Riverside</button></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 text-center px-1" id="date-range">
                                <span style="color: var(--light-text-color);">Main Date Range:</span>
                                <div id="reportrange-main" style="width: 100%; background: var(--input-background-color); cursor: pointer; padding: 5px 10px; border: 1px solid var(--radio-outline-color); border-radius: 5px; font-size: 0.8rem;">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                </div>
                            </div>
                            
                            <div class="col-md-2 text-center px-1" id="date-range">
                                <span style="color: var(--light-text-color);">Comparison Date Range:</span>
                                <div id="reportrange-compare" style="background: var(--input-background-color); cursor: pointer; padding: 5px 10px; border: 1px solid var(--radio-outline-color); border-radius: 5px; font-size: 0.8rem;">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                    <div class="card-body chart-container justify-content-center">
                        <canvas id="comparisonChart" style="height: 500px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else {
    include '../login-form.php';
} ?>

<?php include '../../footer.php'; ?>