;(function () {
  window.parent.postMessage(
    {
      type: "nav_change",
      route: window.location.pathname,
      url: window.location.href,
      title: document.title,
    },
    "https://ronbodnar.com"
  )
})()

$(document).ready(function () {
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

    var myModal = new bootstrap.Modal(
      document.getElementById("exportCSVModal"),
      {}
    )
    myModal.show()
  })

  $("button[data-bs-target='#setShipmentTargetModal']").click(function (e) {
    e.preventDefault()

    $("#modalErrors").html("")
  })

  $("#saveTargetShipments").click(function (e) {
    var fileLocation = $("script[src*=script]")
      .attr("src")
      .replace(/script\.js.*$/, "")

    let coi = $("#shipment-target-coi").val()
    let ontario = $("#shipment-target-ontario").val()
    let riverside = $("#shipment-target-riverside").val()

    var valid = true

    var fields = [
      "shipment-target-coi",
      "shipment-target-ontario",
      "shipment-target-riverside",
    ]

    fields.forEach(function (field) {
      if (!isValid(field, 1, 2)) {
        valid = false
      }
    })

    if (!valid) {
      $("#modalErrors").html(
        '<p class="small text-danger fw-bold">Each facility must have a valid target<br /><em>Numbers only</em>, <em>2 digits max</em></p>'
      )
      return false
    }

    $.ajax({
      type: "POST",
      data:
        "action=save&coi=" +
        coi +
        "&ontario=" +
        ontario +
        "&riverside=" +
        riverside,
      url: fileLocation + "../../src/config.php",
    }).done(function (data) {
      $("#coi-target").html(coi)
      setData("coi", {
        targets: { coi: coi, ontario: ontario, riverside: riverside },
      })

      $("#ontario-target").html(ontario)
      setData("ontario", {
        targets: { coi: coi, ontario: ontario, riverside: riverside },
      })

      $("#riverside-target").html(riverside)
      setData("riverside", {
        targets: { coi: coi, ontario: ontario, riverside: riverside },
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

    $.ajax({
      type: "POST",
      url: $(this).attr("href"),
    }).done(function (data) {
      sessionStorage.setItem("userId", null)
      window.location.href = "/"
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

    $.ajax({
      type: "POST",
      url: $(this).attr("action"),
      data: form.serialize(),
      dataType: "json",
    }).done(function (data) {
      if (data.result === "success") {
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

  /*
   * Removing invalid styling on clicking input
   */
  $("input").click(function () {
    if ($(this).hasClass("is-invalid")) {
      $(this).removeClass("is-invalid")
    }
    if ($(this).hasClass("invalid")) {
      $(this).removeClass("invalid")
    }
  })

  // Toggling yes/no options to allow for only one selection
  $("input.checkbox").change(function () {
    if ($(this).attr("id").includes("assign-to-door-yes")) {
      $("#door-selection").toggle("show")
    }
    if ($(this).attr("id").includes("assign-to-door-no")) {
      $("#door-selection").hide()
    }
    $("input.checkbox").not(this).prop("checked", false)
  })

  /*
   * Animated dropdown menus
   */
  $(".dropdown-menu").addClass("invisible")

  $(".dropdown").on("show.bs.dropdown", function (e) {
    $(".dropdown-menu").removeClass("invisible")
    $(this).find(".dropdown-menu").first().stop(true, true).slideDown()
  })

  $(".dropdown").on("hide.bs.dropdown", function (e) {
    $(this).find(".dropdown-menu").first().stop(true, true).hide()
  })

  /*
   * Notification events
   */
  $(".notification-bell").click(function (e) {
    e.preventDefault()
    e.stopPropagation()
    window.scrollTo(0, 0)
    $(".presentation-dropdown").removeClass("open")
    $(".notification-wrapper").toggleClass("active")
    $(".notification-bell").removeClass("notify")
  })

  $(document).click(function (event) {
    if (
      $(event.target) &&
      !$(event.target).closest(".notification-bell, .notification-wrapper")
        .length
    ) {
      $("body").find(".notification-wrapper").removeClass("active")
    }
  })
})

function initializeTooltips() {
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  )
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
}

/*
 * Dark / Light mode functionality
 */
function toggleDarkMode() {
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

if (!theme) {
  // Detect browser/OS preference
  if (
    window.matchMedia &&
    window.matchMedia("(prefers-color-scheme: dark)").matches
  ) {
    theme = "dark"
  } else {
    theme = "light"
  }
}

document.documentElement.setAttribute("data-theme", theme)
if (document.getElementById("darkModeSwitch"))
  document.getElementById("darkModeSwitch").checked = theme === "dark"

localStorage.setItem("theme", theme)
updateChartColors()

document.addEventListener("DOMContentLoaded", function (event) {
  // Style the active link
  const linkColor = document.querySelectorAll(".nav_link")

  function colorLink() {
    if (linkColor && !this.classList.contains("submenu")) {
      linkColor.forEach((l) => l.classList.remove("active"))
      this.classList.add("active")
    }
  }
  linkColor.forEach((l) => l.addEventListener("click", colorLink))
})

/*
 * Used to validate fields in forms, checking if they are not empty and contain at least @length characters.
 */
function isValid(id, length = 1, maxLength = 0) {
  var input = $("#" + id)
  var valid = true

  if (!input) return false

  if (
    !input.val() ||
    input.val() === "" ||
    input.val().length < length ||
    (maxLength > 0 && input.val().length > maxLength)
  ) {
    document.querySelector("#" + id).classList.add("is-invalid")
    valid = false
  } else {
    document.querySelector("#" + id).classList.remove("is-invalid")
  }
  return valid
}

function processTrailerDrop(door, driverId) {
  // door = # or "sb"
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
    data: params,
  }).done(function (data) {
    //TODO: update card headers with new amount (eg: Yard Status (10) => Yard Status (11))
    if (door === "sb") {
      $("#yardTable")
        .DataTable()
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
}

function updateTables() {
  $("#yardTable")
    .DataTable()
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
}

function updateHeaders() {
  $.ajax({
    type: "GET",
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
    url: "src/api/trailer.php",
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
    updateTables()
  })
}

function assignShipment(id, driverId, trailerId, source) {
  $.ajax({
    type: "POST",
    url: "src/api/shipment.php",
    data: "action=assign-shipment&id=" + id + "&driverId=" + driverId,
  }).done(function (data) {
    socket.emit(
      "sendInstructions",
      JSON.stringify({
        to: driverId,
        instructions: { trailerId: trailerId, source: source, shipmentId: id },
      })
    )
    updateTables()
  })
}

function assignPickupEmpty(driverId) {
  $.ajax({
    type: "GET",
    url: "src/api/driver.php",
    data: "action=assign-task&driverId=" + driverId,
  }).done(function (data) {
    $("#availableDriversTable")
      .DataTable()
      .ajax.url("src/api/driver.php?action=availableList")
      .load()
    updateHeaders()
  })
}

function assignPickupBackhaul(driverId) {
  $.ajax({
    type: "GET",
    url: "src/api/driver.php",
    data: "action=assign-task&driverId=" + driverId,
  }).done(function (data) {
    $("#availableDriversTable")
      .DataTable()
      .ajax.url("src/api/driver.php?action=availableList")
      .load()
    updateHeaders()
  })
}

function assignRescueShipment(driverId) {
  $.ajax({
    type: "GET",
    url: "src/api/driver.php",
    data: "action=assign-task&driverId=" + driverId,
  }).done(function (data) {
    $("#availableDriversTable")
      .DataTable()
      .ajax.url("src/api/driver.php?action=availableList")
      .load()
    updateHeaders()
  })
}
