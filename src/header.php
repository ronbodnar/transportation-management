<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL & ~E_NOTICE);

ini_set('session.cookie_lifetime', 120 * 60);
ini_set('session.gc_maxlifetime', 120 * 60);

session_set_cookie_params(120 * 60);

session_start();

/*
 * Sessions should expire after 120 minutes
 */
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] > 7200) {
    session_unset();
    session_destroy();
}

require 'functions.php';
require 'Database.class.php';

$database = new Database();

// Commented to set the default user for the demo.
//$user = isset($_SESSION['id']) ? $database->getUserData($_SESSION['id']) : null;
$user = $database->getUserData($database->getUserId("demo"));

$formattedPageNames = array(
    'index' => 'Dashboard',
    'trip-management' => 'Trip Management',
    'logs' => 'Logs',
    'analytics' => 'Analytics',
    'drivers' => 'Drivers',
    'shipments' => 'Shipments',
    'settings' => 'Settings'
);

$cwd = explode('/', $_SERVER["SCRIPT_FILENAME"]);
$dir = str_replace('.php', '', $cwd);
$directoryName = end($dir);

$pageTitle = $formattedPageNames[$directoryName];

/*
 This was the default auth redirection logic, removed to bypass login for demo.
 
 
// Redirecting
$adminPages = array(
    'index',
    'settings',
    'analytics',
    'drivers',
    'logs',
    'shipments'
);
if ($user === null) {
    if (strcmp($directoryName, 'index') === false) {
        $redirectUrl = '/projects/logistics-management/';
        header('Location: ' . $redirectUrl);
        die();
    }
} else {
    $redirectUrl = '/projects/logistics-management/';
    if (!$user->isAdmin()) {
        if (in_array($directoryName, $adminPages)) {
            header('Location: ' . $redirectUrl);
            die();
        }
    }
}
    */

?>

<!doctype html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Logistics Management is a mixture of a Transportation Management System and a Warehouse Management System, geared towards streamlining logistics and providing analytics of data collected.">
    <meta name="author" content="Ron Bodnar">

    <title><?php echo $pageTitle; ?> | Logistics Management</title>

    <link rel="canonical" href="https://ronbodnar.com/projects/logistics-management/">

    <script>
        // Render blocking
        if (localStorage.theme) document.documentElement.setAttribute("data-theme", localStorage.theme);
    </script>

    <link href="<?php echo getRelativePath(); ?>assets/css/bootstrap.min.css?v=<?php echo filemtime(getRelativePath() . 'assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="<?php echo getRelativePath(); ?>assets/css/style.css?v=<?php echo filemtime(getRelativePath() . 'assets/css/style.css'); ?>" rel="stylesheet">

    <link rel="icon" href="<?php echo getRelativePath(); ?>assets/img/favicon-32x32.png?v=<?php echo filemtime(getRelativePath() . 'assets/img/favicon-32x32.png'); ?>">

    <meta name="theme-color" content="#7952b3">
</head>

<body class="body <?php echo (isLoggedIn() ? "body-pd" : ""); ?>" id="body-pd">
    <?php if (isLoggedIn()) { ?>
        <!-- Top Navbar -->
        <header class="header top-bar <?php echo (isLoggedIn() ? "body-pd" : ""); ?>" id="header">
            <div class="header-toggle"></div>

            <div class="d-flex justify-content-center align-items-center">

                <div class="notification-bell-header pt-2">
                    <a href="" class="nav-link nav-icon notification-bell notify">
                        <i class="bi bi-bell" style="font-size: 22px;"></i>
                    </a>
                </div>

                <div class="dropdown">
                    <a href="#" class="text-mron d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo getRelativePath(); ?>assets/img/favicon-32x32.png" alt="MR" width="32" height="32" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1"><?php echo $user->getFullName(); ?></span>
                    </a>
                    <ul class="dropdown-menu text-small shadow">
                        <li>
                            <a class="dropdown-item d-flex justify-content-between">
                                <label class="form-check-label d-inline-block" for="darkModeSwitch">Dark Mode</label>
                                <div class="form-check form-switch d-inline-block">
                                    <input class="form-check-input" type="checkbox" id="darkModeSwitch" onclick="toggleDarkMode()">
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?php echo getRelativePath(); ?>src/login.php" id="signOut">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Sidebar -->
        <div class="l-navbar show" id="nav-bar">
            <nav class="sidebar">
                <div>
                    <div class="nav_logo">
                        <a href="/projects/logistics-management/">
                            <img src="<?php echo getRelativePath(); ?>assets/img/header.png" id="nav-header" alt="MRon Development" />
                        </a>
                    </div>

                    <div class="nav_list">
                        <a href="<?php echo getRelativePath(); ?>" id="nav_dashboard" class="nav_link<?php echo ($directoryName === 'logistics-management' ? ' active' : '') ?>">
                            <i class="bi bi-grid"></i>
                            <span class="nav_name">Dashboard</span>
                        </a>

                        <a class="nav_link submenu<?php echo (($directoryName === 'analytics') ? ' active' : '') ?>" data-bs-toggle="collapse" href="#analyticsCollapse" role="button" aria-expanded="false" aria-controls="analyticsCollapse">
                            <i class="bi bi-graph-up-arrow"></i>
                            <span class="nav_name">Analytics <i class="bi bi-chevron-right<?php echo ($directoryName === 'analytics' ? ' rotate-chevron' : ''); ?>" style="position: absolute; right: 15px;"></i></span>
                        </a>
                        <div class="collapse<?php echo ($directoryName === 'analytics' ? ' show' : ''); ?>" id="analyticsCollapse">
                            <div class="submenu-items">
                                <a class="nav_link submenu-item" href="<?php echo getRelativePath(); ?>src/views/analytics/" class="nav_link">
                                    <span class="nav_name">Overview</span>
                                </a>
                                <a class="nav_link submenu-item" href="<?php echo getRelativePath(); ?>src/views/analytics/compare.php" class="nav_link">
                                    <span class="nav_name">Comparisons</span>
                                </a>
                            </div>
                        </div>

                        <a class="nav_link submenu<?php echo ($directoryName === 'logs' ? ' active' : '') ?>" data-bs-toggle="collapse" href="#logsCollapse" role="button" aria-expanded="false" aria-controls="logsCollapse">
                            <i class="bi bi-person"></i>
                            <span class="nav_name">Activity Logs <i class="bi bi-chevron-right<?php echo ($directoryName === 'logs' ? ' rotate-chevron' : ''); ?>" style="position: absolute; right: 15px;"></i></span>
                        </a>
                        <div class="collapse<?php echo ($directoryName === 'logs' ? ' show' : ''); ?>" id="logsCollapse">
                            <div class="submenu-items">
                                <a class="nav_link submenu-item" href="<?php echo getRelativePath(); ?>src/views/logs/daily-activity-logs.php" class="nav_link">
                                    <span class="nav_name">Daily Activity Logs</span>
                                </a>
                                <a class="nav_link submenu-item" href="<?php echo getRelativePath(); ?>src/views/logs/flagged-activity-logs.php" class="nav_link">
                                    <span class="nav_name">Flagged Activity Logs</span>
                                </a>
                            </div>
                        </div>

                        <a href="<?php echo getRelativePath(); ?>src/views/drivers" class="nav_link<?php echo ($directoryName === 'drivers' ? ' active' : '') ?>">
                            <i class="bi bi-person"></i>
                            <span class="nav_name">Drivers</span>
                        </a>

                        <a class="nav_link submenu<?php echo ($directoryName === 'shipments' ? ' active' : '') ?>" data-bs-toggle="collapse" href="#shipmentsCollapse" role="button" aria-expanded="false" aria-controls="shipmentsCollapse">
                            <i class="bi bi-truck"></i>
                            <span class="nav_name">Shipments <i class="bi bi-chevron-right<?php echo ($directoryName === 'shipments' ? ' rotate-chevron' : ''); ?>" style="position: absolute; right: 15px;"></i></span>
                        </a>
                        <div class="collapse<?php echo ($directoryName === 'shipments' ? ' show' : ''); ?>" id="shipmentsCollapse">
                            <div class="submenu-items">
                                <a class="nav_link submenu-item" href="<?php echo getRelativePath(); ?>src/views/shipments/inbound.php" class="nav_link">
                                    <span class="nav_name">Inbound</span>
                                </a>
                                <a class="nav_link submenu-item" href="<?php echo getRelativePath(); ?>src/views/shipments/outbound.php" class="nav_link">
                                    <span class="nav_name">Outbound</span>
                                </a>
                            </div>
                        </div>

                        <a href="<?php echo getRelativePath(); ?>src/views/settings.php" class="nav_link<?php echo ($directoryName === 'admin' ? ' active' : '') ?>">
                            <i class="bi bi-sliders"></i>
                            <span class="nav_name">Settings</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Notifications -->
        <div class="notification-wrapper arrow">
            <div class="notification-header">
                Notifications
            </div>

            <div class="notification-body">
                <div class="notification">
                    <div class="notification-content">
                        Fransisco Smith put empty trailer 5005 into D6
                    </div>
                    <div class="time">
                        10 min
                    </div>
                </div>

                <div class="notification">
                    <div class="notification-content">
                        Fransisco Smith has arrived with an empty trailer
                    </div>
                    <div class="time">
                        14 min
                    </div>
                </div>

                <div class="notification">
                    <div class="notification-content">
                        Joseph Smith put empty trailer 50161 into D11
                    </div>
                    <div class="time">
                        17 min
                    </div>
                </div>

                <div class="notification">
                    <div class="notification-content">
                        Ricardo Smith was assigned a shipment to AC COI.
                    </div>
                    <div class="time">
                        24 min
                    </div>
                </div>

                <div class="notification">
                    <div class="notification-content">
                        Ricardo Smith put empty trailer 7750 into D15
                    </div>
                    <div class="time">
                        29 min
                    </div>
                </div>

                <div class="notification">
                    <div class="notification-content">
                        Joseph Smith has arrived with an empty trailer
                    </div>
                    <div class="time">
                        38 min
                    </div>
                </div>

                <div class="notification">
                    <div class="notification-content">
                        Ricardo Smith has arrived with an empty trailer
                    </div>
                    <div class="time">
                        1h 35m
                    </div>
                </div>

                <div class="notification">
                    <div class="notification-content">
                        Rodrigo Smith was assigned a shipment from D9
                    </div>
                    <div class="time">
                        1h 44m
                    </div>
                </div>
            </div>
        </div>

        <!-- Export CSV Modal -->
        <div class="modal fade" id="exportCSVModal" tabindex="-1" role="dialog" aria-labelledby="exportCSVModalTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title">Export CSV</p>
                        <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg" style="font-size: 1.1rem; color: var(--light-text-color);"></i></button>
                    </div>
                    <div class="modal-body">
                        This feature will be implemented in the future.
                    </div>
                </div>
            </div>
        </div>

        <!-- Popovers -->
        <div id="success-popover" style="display: none;">
            <div class="text-center"><i class="bi bi-patch-check-fill text-success" style="font-size: 4rem;"></i></div>
            <p class="text-center pt-2">DRIVER has been notified that you'd like them to:</p>
            <div class="px-4 assignments"></div>
        </div>

        <div id="assign-outbound-shipment-details-popover" style="display: none;">
            <div class="loading" style="display: none;">
                <div class="spinner-border text-mron" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="row details">
                <div class="col-md-6 fw-bold">Shipment ID</div>
                <div class="col-md-6 fw-bold">PO Number</div>
                <div class="col-md-6" id="shipmentId">-</div>
                <div class="col-md-6" id="po-number">-</div>
                <div class="col-md-6 fw-bold pt-3">Pallets</div>
                <div class="col-md-6 fw-bold pt-3">Net Weight</div>
                <div class="col-md-6" id="pallets">-</div>
                <div class="col-md-6" id="weight">-</div>
                <div class="col-md-6 fw-bold pt-3">Warehouse</div>
                <div class="col-md-6 fw-bold pt-3">Status</div>
                <div class="col-md-6" id="facility">-</div>
                <div class="col-md-6" id="status">-</div>
            </div>
            <div class="row pt-3 text-center">
                <a href="" id="view-more" class="text-mron">View More</a>
            </div>
        </div>

        <div id="assign-inbound-shipment-details-popover" style="display: none;">
            <div class="loading" style="display: none;">
                <div class="spinner-border text-mron" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="row details">
                <div class="col-md-6 fw-bold">PO Number</div>
                <div class="col-md-6 fw-bold">Status</div>
                <div class="col-md-6" id="po-number-in">-</div>
                <div class="col-md-6" id="status-in">-</div>
                <div class="col-md-6 fw-bold pt-3">Pallets</div>
                <div class="col-md-6 fw-bold pt-3">Net Weight</div>
                <div class="col-md-6" id="pallets-in">-</div>
                <div class="col-md-6" id="weight-in">-</div>
                <div class="col-md-12 fw-bold pt-3">Product</div>
                <div class="col-md-12" id="product-in">-</div>
            </div>
            <div class="row pt-3 text-center">
                <a href="" id="view-more-in" class="text-mron">View More</a>
            </div>
        </div>

        <div id="assign-no-shipment-details-popover" style="display: none;">
            <p>No shipment information is available at this time.</p>
            <p>You can <a href="<?php echo getRelativePath() . 'shipments/create.php'; ?>" class="text-mron">create or assign a shipment</a> if needed.</p>
        </div>

    <?php } ?>