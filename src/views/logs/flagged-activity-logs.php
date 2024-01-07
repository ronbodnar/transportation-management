<?php require '../../header.php'; ?>

<div class="container-fluid pt-3">
    <div class="overlay-inner">
        <h3 class="text-light align-self-left fw-bold">Flagged Activity Logs</h3>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-md-11" id="driverActivityLogs">
            <div class="card content">
                <div class="card-header">
                    <span class="card-header-options"></span>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped" id="flaggedActivityLogsTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Driver</th>
                                <th>Location</th>
                                <th>Reason</th>
                                <th>Arrival Time</th>
                                <th>Instructions Received</th>
                                <th>Instructions Accepted</th>
                                <th>Departure Time</th>
                                <th class="text-center">Yard Moves</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../../footer.php'; ?>