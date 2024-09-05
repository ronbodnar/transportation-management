$(document).ready(function () {
<<<<<<< HEAD
  initializeTooltips()

  $("#nav_dashboard").click(function () {
    toggleShipmentsChart()
    updateChartColors()
  })

  $("#testSocket").click(function () {
    socketTest()
  })

  $("#toggle-facilities").click(function () {
    toggleShipmentsChart()
    updateChartColors()
  })

  $("li a[href='#'].dropdown-item").click(function (e) {
    e.preventDefault()
=======
  initializeTooltips();

  $("#nav_dashboard").click(function () {
    toggleShipmentsChart();
    updateChartColors();
  });

  $("#testSocket").click(function () {
    socketTest();
  });

  $("#toggle-facilities").click(function () {
    toggleShipmentsChart();
    updateChartColors();
  });

  $("li a[href='#'].dropdown-item").click(function (e) {
    e.preventDefault();
>>>>>>> origin/master

    var myModal = new bootstrap.Modal(
      document.getElementById("exportCSVModal"),
      {}
<<<<<<< HEAD
    )
    myModal.show()
  })

  $("button[data-bs-target='#setShipmentTargetModal']").click(function (e) {
    e.preventDefault()

    $("#modalErrors").html("")
  })
=======
    );
    myModal.show();
  });

  $("button[data-bs-target='#setShipmentTargetModal']").click(function (e) {
    e.preventDefault();

    $("#modalErrors").html("");
  });
>>>>>>> origin/master

  $("#saveTargetShipments").click(function (e) {
    var fileLocation = $("script[src*=script]")
      .attr("src")
<<<<<<< HEAD
      .replace(/script\.js.*$/, "")

    let accoi = $("#shipment-target-accoi").val()
    let acont = $("#shipment-target-acont").val()
    let lineage = $("#shipment-target-lineage").val()

    var valid = true
=======
      .replace(/script\.js.*$/, "");

    let accoi = $("#shipment-target-accoi").val();
    let acont = $("#shipment-target-acont").val();
    let lineage = $("#shipment-target-lineage").val();

    var valid = true;
>>>>>>> origin/master

    var fields = [
      "shipment-target-accoi",
      "shipment-target-acont",
      "shipment-target-lineage",
<<<<<<< HEAD
    ]

    fields.forEach(function (field) {
      if (!isValid(field, 1, 2)) {
        valid = false
      }
    })
=======
    ];

    fields.forEach(function (field) {
      if (!isValid(field, 1, 2)) {
        valid = false;
      }
    });
>>>>>>> origin/master

    if (!valid) {
      $("#modalErrors").html(
        '<p class="small text-danger fw-bold">Each facility must have a valid target<br /><em>Numbers only</em>, <em>2 digits max</em></p>'
<<<<<<< HEAD
      )
      return false
=======
      );
      return false;
>>>>>>> origin/master
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
      url: fileLocation + "../../src/config.php",
    }).done(function (data) {
<<<<<<< HEAD
      $("#accoi-target").html(accoi)
      setData("accoi", {
        targets: { accoi: accoi, acont: acont, lineage: lineage },
      })

      $("#acont-target").html(acont)
      setData("acont", {
        targets: { accoi: accoi, acont: acont, lineage: lineage },
      })

      $("#lineage-target").html(lineage)
      setData("lineage", {
        targets: { accoi: accoi, acont: acont, lineage: lineage },
      })

      $("#modalErrors").html(
        '<p class="text-success fw-bold"><i class="bi bi-check2-circle"></i> Target Shipments Updated</p>'
      )
    })
  })

  // Login form submission
  $("#signOut").click(function (e) {
    e.preventDefault()
    e.stopPropagation()
=======
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
>>>>>>> origin/master

    $.ajax({
      type: "POST",
      url: $(this).attr("href"),
    }).done(function (data) {
<<<<<<< HEAD
      sessionStorage.setItem("userId", null)
      window.location.href = "/projects/logistics-management/"
    })
  })

  $("#forgotPassword").click(function (e) {
    e.preventDefault()
    e.stopPropagation()

    $("#loginForm").toggle("hidden")
    $("#forgotPasswordForm").toggle("hidden")
  })

  $("#backToLogin").click(function (e) {
    e.preventDefault()
    e.stopPropagation()

    $("#loginForm").toggle("hidden")
    $("#forgotPasswordForm").toggle("hidden")
  })

  // Forgot password toggle
  $("#forgotPasswordForm").submit(function (e) {
    e.preventDefault()
    e.stopPropagation()

    $("#loginForm").toggle("hidden")
  })

  // Login form submission
  $("#loginForm").submit(function (e) {
    var form = $(this)

    e.preventDefault()
    e.stopPropagation()

    console.log($(this).attr("action"))
=======
      sessionStorage.setItem("userId", null);
      window.location.href = "/projects/logistics-management/";
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

    console.log($(this).attr("action"));
>>>>>>> origin/master

    $.ajax({
      type: "POST",
      url: $(this).attr("action"),
      data: form.serialize(),
      dataType: "json",
    }).done(function (data) {
      if (data.result === "success") {
<<<<<<< HEAD
        sessionStorage.setItem("userId", data.userId)
        window.location.href = ""
      } else {
        $("#message").addClass("pb-3").html("Invalid username or password")
      }
    })
  })

  $(".nav_link.submenu").click(function (e) {
    $(this).find("[class*=bi-chevron]").toggleClass("rotate-chevron")
  })
=======
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
>>>>>>> origin/master

  /*
   * Removing invalid styling on clicking input
   */
  $("input").click(function () {
    if ($(this).hasClass("is-invalid")) {
<<<<<<< HEAD
      $(this).removeClass("is-invalid")
    }
    if ($(this).hasClass("invalid")) {
      $(this).removeClass("invalid")
    }
  })
=======
      $(this).removeClass("is-invalid");
    }
    if ($(this).hasClass("invalid")) {
      $(this).removeClass("invalid");
    }
  });
>>>>>>> origin/master

  // Toggling yes/no options to allow for only one selection
  $("input.checkbox").change(function () {
    if ($(this).attr("id").includes("assign-to-door-yes")) {
<<<<<<< HEAD
      $("#door-selection").toggle("show")
    }
    if ($(this).attr("id").includes("assign-to-door-no")) {
      $("#door-selection").hide()
    }
    $("input.checkbox").not(this).prop("checked", false)
  })
=======
      $("#door-selection").toggle("show");
    }
    if ($(this).attr("id").includes("assign-to-door-no")) {
      $("#door-selection").hide();
    }
    $("input.checkbox").not(this).prop("checked", false);
  });
>>>>>>> origin/master

  /*
   * Animated dropdown menus
   */
<<<<<<< HEAD
  $(".dropdown-menu").addClass("invisible")

  $(".dropdown").on("show.bs.dropdown", function (e) {
    $(".dropdown-menu").removeClass("invisible")
    $(this).find(".dropdown-menu").first().stop(true, true).slideDown()
  })

  $(".dropdown").on("hide.bs.dropdown", function (e) {
    $(this).find(".dropdown-menu").first().stop(true, true).hide()
  })
=======
  $(".dropdown-menu").addClass("invisible");

  $(".dropdown").on("show.bs.dropdown", function (e) {
    $(".dropdown-menu").removeClass("invisible");
    $(this).find(".dropdown-menu").first().stop(true, true).slideDown();
  });

  $(".dropdown").on("hide.bs.dropdown", function (e) {
    $(this).find(".dropdown-menu").first().stop(true, true).hide();
  });
>>>>>>> origin/master

  /*
   * Notification events
   */
  $(".notification-bell").click(function (e) {
<<<<<<< HEAD
    e.preventDefault()
    e.stopPropagation()
    window.scrollTo(0, 0)
    $(".presentation-dropdown").removeClass("open")
    $(".notification-wrapper").toggleClass("active")
    $(".notification-bell").removeClass("notify")
  })
=======
    e.preventDefault();
    e.stopPropagation();
    window.scrollTo(0, 0);
    $(".presentation-dropdown").removeClass("open");
    $(".notification-wrapper").toggleClass("active");
    $(".notification-bell").removeClass("notify");
  });
>>>>>>> origin/master

  $(document).click(function (event) {
    if (
      $(event.target) &&
      !$(event.target).closest(".notification-bell, .notification-wrapper")
        .length
    ) {
<<<<<<< HEAD
      $("body").find(".notification-wrapper").removeClass("active")
    }
  })
})
=======
      $("body").find(".notification-wrapper").removeClass("active");
    }
  });
});
>>>>>>> origin/master

function initializeTooltips() {
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
<<<<<<< HEAD
  )
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
=======
  );
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
>>>>>>> origin/master
}

/*
 * Dark / Light mode functionality
 */
function toggleDarkMode() {
<<<<<<< HEAD
  let theme = localStorage.getItem("theme")
  if (theme === "dark") {
    document.documentElement.setAttribute("data-theme", "light")
    localStorage.setItem("theme", "light")
    if (document.getElementById("darkModeSwitch"))
      document.getElementById("darkModeSwitch").checked = false
  } else if (theme === "light") {
    document.documentElement.setAttribute("data-theme", "dark")
    localStorage.setItem("theme", "dark")
    if (document.getElementById("darkModeSwitch"))
      document.getElementById("darkModeSwitch").checked = true
  }
  updateChartColors()
}

let theme = localStorage.getItem("theme")
if (!theme || theme === "light") {
  document.documentElement.setAttribute("data-theme", "light")
  if (document.getElementById("darkModeSwitch"))
    document.getElementById("darkModeSwitch").checked = false
  localStorage.setItem("theme", "light")
  updateChartColors()
} else if (theme === "dark") {
  document.documentElement.setAttribute("data-theme", "dark")
  if (document.getElementById("darkModeSwitch"))
    document.getElementById("darkModeSwitch").checked = true
  localStorage.setItem("theme", "dark")
  updateChartColors()
=======
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
>>>>>>> origin/master
}

document.addEventListener("DOMContentLoaded", function (event) {
  // Style the active link
<<<<<<< HEAD
  const linkColor = document.querySelectorAll(".nav_link")

  function colorLink() {
    if (linkColor && !this.classList.contains("submenu")) {
      linkColor.forEach((l) => l.classList.remove("active"))
      this.classList.add("active")
    }
  }
  linkColor.forEach((l) => l.addEventListener("click", colorLink))
})
=======
  const linkColor = document.querySelectorAll(".nav_link");

  function colorLink() {
    if (linkColor && !this.classList.contains("submenu")) {
      linkColor.forEach((l) => l.classList.remove("active"));
      this.classList.add("active");
    }
  }
  linkColor.forEach((l) => l.addEventListener("click", colorLink));
});
>>>>>>> origin/master

/*
 * Used to validate fields in forms, checking if they are not empty and contain at least @length characters.
 */
function isValid(id, length = 1, maxLength = 0) {
<<<<<<< HEAD
  var input = $("#" + id)
  var valid = true

  if (!input) return false
=======
  var input = $("#" + id);
  var valid = true;

  if (!input) return false;
>>>>>>> origin/master

  if (
    !input.val() ||
    input.val() === "" ||
    input.val().length < length ||
    (maxLength > 0 && input.val().length > maxLength)
  ) {
<<<<<<< HEAD
    document.querySelector("#" + id).classList.add("is-invalid")
    valid = false
  } else {
    document.querySelector("#" + id).classList.remove("is-invalid")
  }
  return valid
=======
    document.querySelector("#" + id).classList.add("is-invalid");
    valid = false;
  } else {
    document.querySelector("#" + id).classList.remove("is-invalid");
  }
  return valid;
>>>>>>> origin/master
}

function processTrailerDrop(door, driverId) {
  // door = # or "sb"
<<<<<<< HEAD
  var url = door === "sb" ? "yard.php" : "doors.php"
  var params = "action=add"
  if (door === "sb") {
    //trailer, driver
    params += "&driverId=" + driverId
  } else {
    //door, trailer, id
    params += "&door=" + door + "&driverId=" + driverId
  }
  console.log(url + params)
  $.ajax({
    type: "POST",
    url: "src/api/" + url,
=======
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
    url: "src/requests/" + url,
>>>>>>> origin/master
    data: params,
  }).done(function (data) {
    //TODO: update card headers with new amount (eg: Yard Status (10) => Yard Status (11))
    if (door === "sb") {
      $("#yardTable")
        .DataTable()
<<<<<<< HEAD
        .ajax.url("src/api/yard.php?action=trailerList")
        .load()
    } else {
      $("#southernDoorsTable")
        .DataTable()
        .ajax.url("src/api/doors.php?action=southList")
        .load()
      $("#northernDoorsTable")
        .DataTable()
        .ajax.url("src/api/doors.php?action=northList")
        .load()
    }
    $("#availableDriversTable")
      .DataTable()
      .ajax.url("src/api/driver.php?action=availableList")
      .load()
  })
=======
        .ajax.url("src/requests/yard.php?action=trailerList")
        .load();
    } else {
      $("#southernDoorsTable")
        .DataTable()
        .ajax.url("src/requests/doors.php?action=southList")
        .load();
      $("#northernDoorsTable")
        .DataTable()
        .ajax.url("src/requests/doors.php?action=northList")
        .load();
    }
    $("#availableDriversTable")
      .DataTable()
      .ajax.url("src/requests/driver.php?action=availableList")
      .load();
  });
>>>>>>> origin/master
}

function updateTables() {
  $("#yardTable")
    .DataTable()
<<<<<<< HEAD
    .ajax.url("src/api/yard.php?action=trailerList")
    .load()
  $("#southernDoorsTable")
    .DataTable()
    .ajax.url("src/api/doors.php?action=southList")
    .load()
  $("#northernDoorsTable")
    .DataTable()
    .ajax.url("src/api/doors.php?action=northList")
    .load()
  $("#availableDriversTable")
    .DataTable()
    .ajax.url("src/api/driver.php?action=availableList")
    .load()
  updateHeaders()
=======
    .ajax.url("src/requests/yard.php?action=trailerList")
    .load();
  $("#southernDoorsTable")
    .DataTable()
    .ajax.url("src/requests/doors.php?action=southList")
    .load();
  $("#northernDoorsTable")
    .DataTable()
    .ajax.url("src/requests/doors.php?action=northList")
    .load();
  $("#availableDriversTable")
    .DataTable()
    .ajax.url("src/requests/driver.php?action=availableList")
    .load();
  updateHeaders();
>>>>>>> origin/master
}

function updateHeaders() {
  $.ajax({
    type: "GET",
<<<<<<< HEAD
    url: "src/api/driver.php",
    data: "action=availableCount",
  }).done(function (data) {
    $("#availableDriverCount").html(data)
  })
  $.ajax({
    type: "GET",
    url: "src/api/yard.php",
    data: "action=count",
  }).done(function (data) {
    $("#yardCount").html(data)
  })
  $.ajax({
    type: "GET",
    url: "src/api/doors.php",
    data: "action=count",
  }).done(function (data) {
    $("#openDoorCount").html(data)
  })
=======
    url: "src/requests/driver.php",
    data: "action=availableCount",
  }).done(function (data) {
    $("#availableDriverCount").html(data);
  });
  $.ajax({
    type: "GET",
    url: "src/requests/yard.php",
    data: "action=count",
  }).done(function (data) {
    $("#yardCount").html(data);
  });
  $.ajax({
    type: "GET",
    url: "src/requests/doors.php",
    data: "action=count",
  }).done(function (data) {
    $("#openDoorCount").html(data);
  });
>>>>>>> origin/master
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
<<<<<<< HEAD
    url: "src/api/trailer.php",
=======
    url: "src/requests/trailer.php",
>>>>>>> origin/master
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
<<<<<<< HEAD
    updateTables()
  })
=======
    updateTables();
  });
>>>>>>> origin/master
}

function assignShipment(id, driverId, trailerId, source) {
  $.ajax({
    type: "POST",
<<<<<<< HEAD
    url: "src/api/shipment.php",
=======
    url: "src/requests/shipment.php",
>>>>>>> origin/master
    data: "action=assign-shipment&id=" + id + "&driverId=" + driverId,
  }).done(function (data) {
    socket.emit(
      "sendInstructions",
      JSON.stringify({
        to: driverId,
        instructions: { trailerId: trailerId, source: source, shipmentId: id },
      })
<<<<<<< HEAD
    )
    updateTables()
  })
=======
    );
    updateTables();
  });
>>>>>>> origin/master
}

function assignPickupEmpty(driverId) {
  $.ajax({
    type: "GET",
<<<<<<< HEAD
    url: "src/api/driver.php",
=======
    url: "src/requests/driver.php",
>>>>>>> origin/master
    data: "action=assign-task&driverId=" + driverId,
  }).done(function (data) {
    $("#availableDriversTable")
      .DataTable()
<<<<<<< HEAD
      .ajax.url("src/api/driver.php?action=availableList")
      .load()
    updateHeaders()
  })
=======
      .ajax.url("src/requests/driver.php?action=availableList")
      .load();
    updateHeaders();
  });
>>>>>>> origin/master
}

function assignPickupBackhaul(driverId) {
  $.ajax({
    type: "GET",
<<<<<<< HEAD
    url: "src/api/driver.php",
=======
    url: "src/requests/driver.php",
>>>>>>> origin/master
    data: "action=assign-task&driverId=" + driverId,
  }).done(function (data) {
    $("#availableDriversTable")
      .DataTable()
<<<<<<< HEAD
      .ajax.url("src/api/driver.php?action=availableList")
      .load()
    updateHeaders()
  })
=======
      .ajax.url("src/requests/driver.php?action=availableList")
      .load();
    updateHeaders();
  });
>>>>>>> origin/master
}

function assignRescueShipment(driverId) {
  $.ajax({
    type: "GET",
<<<<<<< HEAD
    url: "src/api/driver.php",
=======
    url: "src/requests/driver.php",
>>>>>>> origin/master
    data: "action=assign-task&driverId=" + driverId,
  }).done(function (data) {
    $("#availableDriversTable")
      .DataTable()
<<<<<<< HEAD
      .ajax.url("src/api/driver.php?action=availableList")
      .load()
    updateHeaders()
  })
}
=======
      .ajax.url("src/requests/driver.php?action=availableList")
      .load();
    updateHeaders();
  });
}
>>>>>>> origin/master
