$(function () {
  // Date Range Picker
  var start = moment().subtract(6, "days");
  var end = moment();
  var startMain = moment();
  var endMain = moment();
  var startComparison = moment().subtract(1, "days");
  var endComparison = moment().subtract(1, "days");

  function cb(start, end) {
    $("#reportrange span").html(
      start.format("MMM D, YYYY") + " - " + end.format("MMM D, YYYY")
    );
  }

  function cbc(start, end) {
    $("#reportrange-compare span").html(
      start.format("MMM D, YYYY") + " - " + end.format("MMM D, YYYY")
    );
  }

  function cbm(start, end) {
    $("#reportrange-main span").html(
      start.format("MMM D, YYYY") + " - " + end.format("MMM D, YYYY")
    );
  }

  $("#reportrange").daterangepicker(
    {
      showDropdowns: true,
      minYear: 2010,
      maxYear: 2023,
      maxDate: moment(),
      applyClass: "btn-mron",
      cancelClass: "btn-secondary",
      startDate: start,
      opens: "left",
      endDate: end,
      ranges: {
        Today: [moment(), moment()],
        Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
        "Last 7 Days": [moment().subtract(6, "days"), moment()],
        "Last 30 Days": [moment().subtract(29, "days"), moment()],
        "This Month": [moment().startOf("month"), moment().endOf("month")],
        "Last Month": [
          moment().subtract(1, "month").startOf("month"),
          moment().subtract(1, "month").endOf("month"),
        ],
      },
    },
    cb
  );

  $("#reportrange-main").daterangepicker(
    {
      showDropdowns: true,
      minYear: 2010,
      maxYear: 2023,
      maxDate: moment(),
      applyClass: "btn-mron",
      cancelClass: "btn-secondary",
      startDate: startMain,
      opens: "left",
      endDate: endMain,
      ranges: {
        Today: [moment(), moment()],
        Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
        "Last 7 Days": [moment().subtract(6, "days"), moment()],
        "Last 30 Days": [moment().subtract(29, "days"), moment()],
        "This Month": [moment().startOf("month"), moment().endOf("month")],
        "Last Month": [
          moment().subtract(1, "month").startOf("month"),
          moment().subtract(1, "month").endOf("month"),
        ],
      },
    },
    cbm
  );

  $("#reportrange-compare").daterangepicker(
    {
      showDropdowns: true,
      minYear: 2010,
      maxYear: 2023,
      maxDate: moment(),
      applyClass: "btn-mron",
      cancelClass: "btn-secondary",
      startDate: startComparison,
      opens: "left",
      endDate: endComparison,
      ranges: {
        Today: [moment(), moment()],
        Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
        "Last 7 Days": [moment().subtract(6, "days"), moment()],
        "Last 30 Days": [moment().subtract(29, "days"), moment()],
        "This Month": [moment().startOf("month"), moment().endOf("month")],
        "Last Month": [
          moment().subtract(1, "month").startOf("month"),
          moment().subtract(1, "month").endOf("month"),
        ],
      },
    },
    cbc
  );

  cb(start, end);
  cbm(startMain, endMain);
  cbc(startComparison, endComparison);
});

$(document).ready(function () {
  initializeTooltips();

  /*var myModal = new bootstrap.Modal(
    document.getElementById("assignDriverModal"),
    {}
  );
  myModal.show();*/

  $("#testSocket").click(function () {
    socketTest();
  });

  $("#reportrange").on("apply.daterangepicker", function (ev, picker) {
    updateChartData(picker.startDate, picker.endDate);
  });

  $("#reportrange-main").on("apply.daterangepicker", function (ev, picker) {
    var metric = $("#compareMetricButton").html().trim();
    if (metric === "Select a metric") {
      return false;
    }
    var comparisonRange = $("#reportrange-compare").data("daterangepicker");
    updateComparisonChartData(
      picker.startDate,
      picker.endDate,
      comparisonRange.startDate,
      comparisonRange.endDate
    );
    updateChartColors();
  });
  $("#reportrange-compare").on("apply.daterangepicker", function (ev, picker) {
    var metric = $("#compareMetricButton").html().trim();
    if (metric === "Select a metric") {
      return false;
    }
    var mainRange = $("#reportrange-main").data("daterangepicker");
    updateComparisonChartData(
      mainRange.startDate,
      mainRange.endDate,
      picker.startDate,
      picker.endDate
    );
    updateChartColors();
  });

  $("#toggle-facilities").click(function () {
    toggleShipmentsChart();
    updateChartColors();
  });

  $("#compareMetricDropdown .dropdown-item").click(function (e) {
    $("#compareMetricButton").html($(this).html());
    var mainRange = $("#reportrange-main").data("daterangepicker");
    var comparisonRange = $("#reportrange-compare").data("daterangepicker");
    updateComparisonChartData(
      mainRange.startDate,
      mainRange.endDate,
      comparisonRange.startDate,
      comparisonRange.endDate
    );
    updateChartColors();
    if (
      $(this).attr("id") === "shipmentsCompleted" ||
      $(this).attr("id") === "waitTimes"
    ) {
      $("#compareFacility").show();
    } else {
      $("#compareFacility").hide();
    }
  });

  $("#compareFacilityDropdown .dropdown-item").click(function (e) {
    $("#compareFacilityButton").html($(this).html());
    var mainRange = $("#reportrange-main").data("daterangepicker");
    var comparisonRange = $("#reportrange-compare").data("daterangepicker");
    updateComparisonChartData(
      mainRange.startDate,
      mainRange.endDate,
      comparisonRange.startDate,
      comparisonRange.endDate,
      true
    );
    updateChartColors();
  });

  $("#allDriversDropdown .dropdown-item").click(function (e) {
    $("#allDriversDropdownButton").html($(this).html());
    $("#driverAverages").show();
    $("#driverActivityLogs").show();
    $("#averageShipments").html("2.36");
    $("#averageBackhauls").html("0.91");
    $("#averageYardMoves").html("6");
    $("#averageShiftTime").html("11h " + Math.floor(Math.random() * 59) + "m");
    $("#averageInstructionTime").html(
      Math.floor(Math.random() * 39) + 20 + "m"
    );
    $("#averageUnplannedStops").html("3");
    $("#activityLogDriverName").html("for " + $(this).attr("id"));
    $("#driverActivityLogTable")
      .DataTable()
      .ajax.url("/projects/tms/test/logs.txt")
      .load();
  });

  $("li a[href='#'].dropdown-item").click(function (e) {
    e.preventDefault();

    var myModal = new bootstrap.Modal(
      document.getElementById("exportCSVModal"),
      {}
    );
    myModal.show();
  });

  $("button[data-bs-target='#setShipmentTargetModal'").click(function (e) {
    e.preventDefault();

    $("#modalErrors").html("");
  });

  $("#saveTargetShipments").click(function (e) {
    var fileLocation = $("script[src*=script]")
      .attr("src")
      .replace(/script\.js.*$/, "");

    let accoi = $("#shipment-target-accoi").val();
    let acont = $("#shipment-target-acont").val();
    let lineage = $("#shipment-target-lineage").val();

    var valid = true;

    var fields = [
      "shipment-target-accoi",
      "shipment-target-acont",
      "shipment-target-lineage",
    ];

    fields.forEach(function (field) {
      if (!isValid(field, 1, 2)) {
        valid = false;
      }
    });

    if (!valid) {
      $("#modalErrors").html(
        '<p class="small text-danger fw-bold">Each facility must have a valid target<br /><em>Numbers only</em>, <em>2 digits max</em></p>'
      );
      return false;
    }

    $.ajax({
      type: "POST",
      data:
        "action=save&accoi=" +
        accoi +
        "&acont=" +
        acont +
        "&lineage=" +
        lineage,
      url: fileLocation + "../../config.php",
    }).done(function (data) {
      $("#accoi-target").html(accoi);
      setData("accoi", {
        targets: { accoi: accoi, acont: acont, lineage: lineage },
      });

      $("#acont-target").html(acont);
      setData("acont", {
        targets: { accoi: accoi, acont: acont, lineage: lineage },
      });

      $("#lineage-target").html(lineage);
      setData("lineage", {
        targets: { accoi: accoi, acont: acont, lineage: lineage },
      });

      $("#modalErrors").html(
        '<p class="text-success fw-bold"><i class="bi bi-check2-circle"></i> Target Shipments Updated</p>'
      );
    });
  });

  // Login form submission
  $("#signOut").click(function (e) {
    e.preventDefault();
    e.stopPropagation();

    $.ajax({
      type: "POST",
      url: $(this).attr("href"),
    }).done(function (data) {
      sessionStorage.setItem("userId", null);
      window.location.href = "/projects/tms/";
    });
  });

  $("#forgotPassword").click(function (e) {
    e.preventDefault();
    e.stopPropagation();

    $("#loginForm").toggle("hidden");
    $("#forgotPasswordForm").toggle("hidden");
  });

  $("#backToLogin").click(function (e) {
    e.preventDefault();
    e.stopPropagation();

    $("#loginForm").toggle("hidden");
    $("#forgotPasswordForm").toggle("hidden");
  });

  // Forgot password toggle
  $("#forgotPasswordForm").submit(function (e) {
    e.preventDefault();
    e.stopPropagation();

    $("#loginForm").toggle("hidden");
  });

  // Login form submission
  $("#loginForm").submit(function (e) {
    var form = $(this);

    e.preventDefault();
    e.stopPropagation();

    $.ajax({
      type: "POST",
      url: $(this).attr("action"),
      data: form.serialize(),
      dataType: "json",
    }).done(function (data) {
      if (data.result === "success") {
        sessionStorage.setItem("userId", data.userId);
        window.location.href = "";
      } else {
        $("#message").addClass("pb-3").html("Invalid username or password");
      }
    });
  });

  $(".nav_link.submenu").click(function (e) {
    $(this).find("[class*=bi-chevron]").toggleClass("rotate-chevron");
  });

  /*
   * Removing invalid styling on clicking input
   */
  $("input").click(function () {
    if ($(this).hasClass("is-invalid")) {
      $(this).removeClass("is-invalid");
    }
    if ($(this).hasClass("invalid")) {
      $(this).removeClass("invalid");
    }
  });

  // Toggling yes/no options to allow for only one selection
  $("input.checkbox").change(function () {
    if ($(this).attr("id").includes("assign-to-door-yes")) {
      $("#door-selection").toggle("show");
    }
    if ($(this).attr("id").includes("assign-to-door-no")) {
      $("#door-selection").hide();
    }
    $("input.checkbox").not(this).prop("checked", false);
  });

  /*
   * Animated dropdown menus
   */
  $(".dropdown-menu").addClass("invisible");

  $(".dropdown").on("show.bs.dropdown", function (e) {
    $(".dropdown-menu").removeClass("invisible");
    $(this).find(".dropdown-menu").first().stop(true, true).slideDown();
  });

  $(".dropdown").on("hide.bs.dropdown", function (e) {
    $(this).find(".dropdown-menu").first().stop(true, true).hide();
  });

  /*
   * Notification events
   */
  $(".notification-bell").click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    window.scrollTo(0, 0);
    $(".presentation-dropdown").removeClass("open");
    $(".notification-wrapper").toggleClass("active");
    $(".notification-bell").removeClass("notify");
  });

  $(document).click(function (event) {
    if (
      $(event.target) &&
      !$(event.target).closest(".notification-bell, .notification-wrapper")
        .length
    ) {
      $("body").find(".notification-wrapper").removeClass("active");
    }
  });
});

function initializeTooltips() {
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
}

/*
 * Dark / Light mode functionality
 */
function toggleDarkMode() {
  let theme = localStorage.getItem("theme");
  if (theme === "dark") {
    document.documentElement.setAttribute("data-theme", "light");
    localStorage.setItem("theme", "light");
    if (document.getElementById("darkModeSwitch"))
      document.getElementById("darkModeSwitch").checked = false;
  } else if (theme === "light") {
    document.documentElement.setAttribute("data-theme", "dark");
    localStorage.setItem("theme", "dark");
    if (document.getElementById("darkModeSwitch"))
      document.getElementById("darkModeSwitch").checked = true;
  }
  updateChartColors();
}

let theme = localStorage.getItem("theme");
if (!theme || theme === "light") {
  document.documentElement.setAttribute("data-theme", "light");
  if (document.getElementById("darkModeSwitch"))
    document.getElementById("darkModeSwitch").checked = false;
  localStorage.setItem("theme", "light");
  updateChartColors();
} else if (theme === "dark") {
  document.documentElement.setAttribute("data-theme", "dark");
  if (document.getElementById("darkModeSwitch"))
    document.getElementById("darkModeSwitch").checked = true;
  localStorage.setItem("theme", "dark");
  updateChartColors();
}

//TODO: Rewrite this function
document.addEventListener("DOMContentLoaded", function (event) {
  const showNavbar = (
    toggleId,
    mobileToggleId,
    navId,
    bodyId,
    headerId,
    footerId
  ) => {
    const toggle = document.getElementById(toggleId),
      mobileToggle = document.getElementById(mobileToggleId),
      nav = document.getElementById(navId),
      bodypd = document.getElementById(bodyId),
      headerpd = document.getElementById(headerId),
      footerpd = document.getElementById(footerId);

    if (toggle && mobileToggle && nav && bodypd && headerpd) {
      if (
        $(window).width() >= 768 &&
        (!localStorage.getItem("showSidebar") ||
          localStorage.getItem("showSidebar") === "true")
      ) {
        nav.classList.toggle("show");
        //toggle.classList.toggle("bx-x");
        bodypd.classList.toggle("body-pd");
        headerpd.classList.toggle("body-pd");
        footerpd.classList.toggle("body-pd");
        localStorage.setItem("showSidebar", "true");
      }
      if ($(window).width() < 768) {
        mobileToggle.classList.toggle("show");
      }

      mobileToggle.addEventListener("click", () => {
        //mobileToggle.classList.toggle("show");
        nav.classList.toggle("show");
        bodypd.classList.toggle("body-pd");
        // add padding to header
        headerpd.classList.toggle("body-pd");
        footerpd.classList.toggle("body-pd");
      });

      toggle.addEventListener("click", () => {
        // show navbar
        nav.classList.toggle("show");
        mobileToggle.classList.toggle("show");
        // change icon
        //toggle.classList.toggle("bx-x");
        // add padding to body
        bodypd.classList.toggle("body-pd");
        // add padding to header
        headerpd.classList.toggle("body-pd");
        if (footerpd) footerpd.classList.toggle("body-pd");
        var showSidebar = localStorage.getItem("showSidebar");
        localStorage.setItem(
          "showSidebar",
          showSidebar === "true" ? "false" : "true"
        );
      });
    }
  };

  showNavbar(
    "header-toggle",
    "header-toggle-mobile",
    "nav-bar",
    "body-pd",
    "header",
    "footer"
  );

  // Style the active link
  const linkColor = document.querySelectorAll(".nav_link");

  function colorLink() {
    if (linkColor && !this.classList.contains("submenu")) {
      linkColor.forEach((l) => l.classList.remove("active"));
      this.classList.add("active");
    }
  }
  linkColor.forEach((l) => l.addEventListener("click", colorLink));
});

/*
 * Used to validate fields in forms, checking if they are not empty and contain at least @length characters.
 */
function isValid(id, length = 1, maxLength = 0) {
  var input = $("#" + id);
  var valid = true;

  if (!input) return false;

  if (
    !input.val() ||
    input.val() === "" ||
    input.val().length < length ||
    (maxLength > 0 && input.val().length > maxLength)
  ) {
    document.querySelector("#" + id).classList.add("is-invalid");
    valid = false;
  } else {
    document.querySelector("#" + id).classList.remove("is-invalid");
  }
  return valid;
}

function processTrailerDrop(door, driverId) {
  // door = # or "sb"
  var url = door === "sb" ? "yard.php" : "doors.php";
  var params = "action=add";
  if (door === "sb") {
    //trailer, driver
    params += "&driverId=" + driverId;
  } else {
    //door, trailer, id
    params += "&door=" + door + "&driverId=" + driverId;
  }
  console.log(url + params);
  $.ajax({
    type: "POST",
    url: "api/" + url,
    data: params,
  }).done(function (data) {
    //TODO: update card headers with new amount (eg: Yard Status (10) => Yard Status (11))
    if (door === "sb") {
      $("#yardTable")
        .DataTable()
        .ajax.url("api/yard.php?action=trailerList")
        .load();
    } else {
      $("#southernDoorsTable")
        .DataTable()
        .ajax.url("api/doors.php?action=southList")
        .load();
      $("#northernDoorsTable")
        .DataTable()
        .ajax.url("api/doors.php?action=northList")
        .load();
    }
    $("#availableDriversTable")
      .DataTable()
      .ajax.url("api/driver.php?action=availableList")
      .load();
  });
}

function updateTables() {
  $("#yardTable")
    .DataTable()
    .ajax.url("api/yard.php?action=trailerList")
    .load();
  $("#southernDoorsTable")
    .DataTable()
    .ajax.url("api/doors.php?action=southList")
    .load();
  $("#northernDoorsTable")
    .DataTable()
    .ajax.url("api/doors.php?action=northList")
    .load();
  $("#availableDriversTable")
    .DataTable()
    .ajax.url("api/driver.php?action=availableList")
    .load();
  updateHeaders();
}

function updateHeaders() {
  $.ajax({
    type: "GET",
    url: "api/driver.php",
    data: "action=availableCount",
  }).done(function (data) {
    $("#availableDriverCount").html(data);
  });
  $.ajax({
    type: "GET",
    url: "api/yard.php",
    data: "action=count",
  }).done(function (data) {
    $("#yardCount").html(data);
  });
  $.ajax({
    type: "GET",
    url: "api/doors.php",
    data: "action=count",
  }).done(function (data) {
    $("#openDoorCount").html(data);
  });
}

function assignYardMove(
  source,
  sourceType,
  destination,
  destinationType,
  driverId
) {
  $.ajax({
    type: "GET",
    url: "api/trailer.php",
    data:
      "action=yardMove&source=" +
      source +
      "&sourceType=" +
      sourceType +
      "&destination=" +
      destination +
      "&destinationType=" +
      destinationType +
      "&driverId=" +
      driverId,
  }).done(function (data) {
    updateTables();
  });
}

function assignShipment(id, driverId, trailerId, source) {
  $.ajax({
    type: "POST",
    url: "api/shipment.php",
    data: "action=assign-shipment&id=" + id + "&driverId=" + driverId,
  }).done(function (data) {
    socket.emit(
      "sendInstructions",
      JSON.stringify({
        to: driverId,
        instructions: { trailerId: trailerId, source: source, shipmentId: id },
      })
    );
    updateTables();
  });
}

function assignPickupEmpty(driverId) {
  $.ajax({
    type: "GET",
    url: "api/driver.php",
    data: "action=assign-task&driverId=" + driverId,
  }).done(function (data) {
    $("#availableDriversTable")
      .DataTable()
      .ajax.url("api/driver.php?action=availableList")
      .load();
    updateHeaders();
  });
}

function assignPickupBackhaul(driverId) {
  $.ajax({
    type: "GET",
    url: "api/driver.php",
    data: "action=assign-task&driverId=" + driverId,
  }).done(function (data) {
    $("#availableDriversTable")
      .DataTable()
      .ajax.url("api/driver.php?action=availableList")
      .load();
    updateHeaders();
  });
}

function assignRescueShipment(driverId) {
  $.ajax({
    type: "GET",
    url: "api/driver.php",
    data: "action=assign-task&driverId=" + driverId,
  }).done(function (data) {
    $("#availableDriversTable")
      .DataTable()
      .ajax.url("api/driver.php?action=availableList")
      .load();
    updateHeaders();
  });
}
