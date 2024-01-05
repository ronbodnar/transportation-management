<?php if (strpos($directoryName, 'driver-tools') === false && strpos($directoryName, 'trip-management') === false) { ?>
    <footer class="footer" id="footer" style="font-size: 14px;">
        <span>&copy; 2023 <a class="text-mron" href="https://ronbodnar.com/">Ron Bodnar</a></span>
    </footer>
<?php } else { ?>
    <?php
    $unavailable = $_SESSION['STATUS'] === 'DRIVER_UNAVAILABLE';
    if (strlen($_SESSION['LOAD_NUMBER']) > 0 && !$unavailable) {
    ?>
        <footer class="footer-mobile" id="footer" style="font-size: 14px;">
            <small class="text-center" style="width: 100%;">Have an issue, making a stop, or taking your lunch?</small>
            <a href="" class="text-mron text-decoration-underline" id="driver-unavailable">Click Here</a>
        </footer>
<?php }
} ?>

<!-- jQuery Plugins -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/moment@^2"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.13.4/sorting/datetime-moment.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.41/moment-timezone.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@^1"></script>

<!-- Bootstrap Plugins -->
<script src="<?php echo getRelativePath(); ?>assets/js/bootstrap.bundle.min.js?v=<?php echo filemtime(getRelativePath() . 'assets/js/bootstrap.bundle.min.js'); ?>"></script>

<!-- Socket.io Library -->
<!--<script src="https://cdn.socket.io/4.6.1/socket.io.min.js"></script>-->

<!-- Custom JavaScript -->
<script src="<?php echo getRelativePath(); ?>assets/js/popovers.js?v=<?php echo filemtime(getRelativePath() . 'assets/js/popovers.js'); ?>"></script>
<script src="<?php echo getRelativePath(); ?>assets/js/charts.js?v=<?php echo filemtime(getRelativePath() . 'assets/js/charts.js'); ?>"></script>
<script src="<?php echo getRelativePath(); ?>assets/js/tables.js?v=<?php echo filemtime(getRelativePath() . 'assets/js/tables.js'); ?>"></script>
<script src="<?php echo getRelativePath(); ?>assets/js/analytics.js?v=<?php echo filemtime(getRelativePath() . 'assets/js/analytics.js'); ?>"></script>
<script src="<?php echo getRelativePath(); ?>assets/js/script.js?v=<?php echo filemtime(getRelativePath() . 'assets/js/script.js'); ?>"></script>
<!--<script src="<?php //echo getRelativePath(); ?>assets/js/websocket.js?v=<?php //echo filemtime(getRelativePath() . 'assets/js/websocket.js'); ?>"></script>-->

<?php
// Include relevant assets based on current page
if ($directoryName === 'osd' || $directoryName === 'backend') {
    echo '<script src="' . getRelativePath() . 'assets/js/osd.js?v=' . filemtime(getRelativePath() . "assets/js/osd.js") . '"></script>';
} else if ($directoryName == 'trip-management') {
    echo '<script src="' . getRelativePath() . 'assets/js/trip-management.js?v=' . filemtime(getRelativePath() . "assets/js/trip-management.js") . '"></script>';
}
?>
</body>

</html>