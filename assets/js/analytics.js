$(function () {
<<<<<<< HEAD
  // Date Range Picker
  var start = moment().subtract(6, "days")
  var end = moment()
  var startMain = moment()
  var endMain = moment()
  var startComparison = moment().subtract(1, "days")
  var endComparison = moment().subtract(1, "days")

  function cb(start, end) {
    $("#reportrange span").html(
      start.format("MMM D, YYYY") + " - " + end.format("MMM D, YYYY")
    )
  }

  function cbc(start, end) {
    $("#reportrange-compare span").html(
      start.format("MMM D, YYYY") + " - " + end.format("MMM D, YYYY")
    )
  }

  function cbm(start, end) {
    $("#reportrange-main span").html(
      start.format("MMM D, YYYY") + " - " + end.format("MMM D, YYYY")
    )
  }

  $("#reportrange").daterangepicker(
    {
      showDropdowns: true,
      minYear: 2020,
      maxYear: 2024,
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
  )

  $("#reportrange-main").daterangepicker(
    {
      showDropdowns: true,
      minYear: 2020,
      maxYear: 2024,
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
  )

  $("#reportrange-compare").daterangepicker(
    {
      showDropdowns: true,
      minYear: 2020,
      maxYear: 2024,
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
  )

  cb(start, end)
  cbm(startMain, endMain)
  cbc(startComparison, endComparison)
})

$(document).ready(function () {
  $("#reportrange").on("apply.daterangepicker", function (ev, picker) {
    updateChartData(picker.startDate, picker.endDate)
  })

  $("#reportrange-main").on("apply.daterangepicker", function (ev, picker) {
    var metric = $("#compareMetricButton").html().trim()
    if (metric === "Select a metric") {
      return false
    }
    var comparisonRange = $("#reportrange-compare").data("daterangepicker")
    updateComparisonChartData(
      picker.startDate,
      picker.endDate,
      comparisonRange.startDate,
      comparisonRange.endDate
    )
    updateChartColors()
  })
  $("#reportrange-compare").on("apply.daterangepicker", function (ev, picker) {
    var metric = $("#compareMetricButton").html().trim()
    if (metric === "Select a metric") {
      return false
    }
    var mainRange = $("#reportrange-main").data("daterangepicker")
    updateComparisonChartData(
      mainRange.startDate,
      mainRange.endDate,
      picker.startDate,
      picker.endDate
    )
    updateChartColors()
  })

  $("#compareMetricDropdown .dropdown-item").click(function (e) {
    $("#compareMetricButton").html($(this).html())
    var mainRange = $("#reportrange-main").data("daterangepicker")
    var comparisonRange = $("#reportrange-compare").data("daterangepicker")
    updateComparisonChartData(
      mainRange.startDate,
      mainRange.endDate,
      comparisonRange.startDate,
      comparisonRange.endDate
    )
    updateChartColors()
    if (
      $(this).attr("id") === "shipmentsCompleted" ||
      $(this).attr("id") === "waitTimes"
    ) {
      $("#compareFacility").show()
    } else {
      $("#compareFacility").hide()
    }
  })

  $("#compareFacilityDropdown .dropdown-item").click(function (e) {
    $("#compareFacilityButton").html($(this).html())
    var mainRange = $("#reportrange-main").data("daterangepicker")
    var comparisonRange = $("#reportrange-compare").data("daterangepicker")
    updateComparisonChartData(
      mainRange.startDate,
      mainRange.endDate,
      comparisonRange.startDate,
      comparisonRange.endDate,
      true
    )
    updateChartColors()
  })

  $("#allDriversDropdown .dropdown-item").click(function (e) {
    $("#allDriversDropdownButton").html($(this).html())
    $("#driverAverages").show()
    $("#driverActivityLogs").show()
    $("#averageShipments").html("2.36")
    $("#averageBackhauls").html("0.91")
    $("#averageYardMoves").html("6")
    $("#averageShiftTime").html("11h " + Math.floor(Math.random() * 59) + "m")
    $("#averageInstructionTime").html(Math.floor(Math.random() * 39) + 20 + "m")
    $("#averageUnplannedStops").html("3")
    $("#activityLogDriverName").html("for " + $(this).attr("id"))
    $("#driverActivityLogTable")
      .DataTable()
      .ajax.url("/projects/logistics-management/config/logs.txt")
      .load()
  })
})
=======
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
        minYear: 2020,
        maxYear: 2024,
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
        minYear: 2020,
        maxYear: 2024,
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
        minYear: 2020,
        maxYear: 2024,
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
          .ajax.url("/projects/logistics-management/test/logs.txt")
          .load();
    });
});
>>>>>>> origin/master
