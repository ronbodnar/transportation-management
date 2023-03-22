/*
 * Shows certain <div> elements based on current session status and hides all other elements.
 */
function toggleVisibility(visible) {
  var options = [
    "danoneArrival",
    "normalArrival",
    "bobtailArrival",
    "backhaulArrival",
    "emptyArrival",
    "palletsOrSamples",
    "refusedLoadArrival",
    "northernArrival",
    "fuelArrival",
  ];
  var danoneOptions = [
    "bobtailArrival",
    "backhaulArrival",
    "emptyArrival",
    "palletsOrSamples",
    "refusedLoadArrival",
  ];
  for (var i = 0; i < options.length; i++) {
    if (options[i] === visible) continue;
    if (
      Object.values(danoneOptions).includes(visible) &&
      options[i] === "danoneArrival"
    )
      continue;
    $("#" + options[i]).attr("hidden", true);
  }
  $("#" + visible).attr("hidden", false);
}

/*
 * Document is ready and custom hooks can be performed
 */
$(document).ready(function () {
  $("a.toggle").click(function () {
    $("div#waiting").hide();
    $("div#instructions").show();
  });

  $("a.toggle-check-in").click(function () {
    $("#distance-acceptable").hide();
    $("#facility-instructions").show();
  });

  $("#startOfDayForm").submit(function (e) {
    var form = $(this);

    var valid = true;

    var fields = [
      "loadNumber",
      "startTime",
      "startLocation",
      "startingMileage",
    ];

    for (var i = 0; i < fields.length; i++) {
      if (!isValid(fields[i])) {
        valid = false;
      }
    }
    if (!valid) {
      e.preventDefault();
      e.stopPropagation();
    }

    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: form.serialize(),
    }).done(function (data) {
      window.location.reload();
    });
  });

  $("#ready").submit(function (e) {
    var form = $(this);
    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: "status=READY",
    }).done(function (data) {
      window.location.reload();
    });
  });

  $("#accept-instructions").click(function (e) {
    $(".refuse-instructions").hide();
    $("#accept-instructions-prompt").hide();
    $("#accepted-instructions").show();
    window.scrollTo(0, document.body.scrollHeight);
  });

  $("#refuse-instructions").click(function (e) {
    $("#refuse-instructions").attr("disabled", "true");
    $(".refuse-instructions").show();
    window.scrollTo(0, document.body.scrollHeight);
  });

  $("#ready-to-go").click(function (e) {
    $.ajax({
      type: "POST",
      url: ".",
      data: "status=LEFT_DANONE",
    }).done(function (data) {
      window.location.reload();
    });
  });

  $("#leaving-facility").click(function (e) {
    $.ajax({
      type: "POST",
      url: ".",
      data: "status=LEFT_FACILITY",
    }).done(function (data) {
      window.location.reload();
    });
  });

  $("#arrived-at-danone").click(function (e) {
    $.ajax({
      type: "POST",
      url: ".",
      data: "status=ARRIVED_AT_DANONE",
    }).done(function (data) {
      window.location.reload();
    });
  });

  $("#arrived-at-facility").click(function (e) {
    $.ajax({
      type: "POST",
      url: ".",
      data: "status=ARRIVED_AT_FACILITY",
    }).done(function (data) {
      window.location.reload();
    });
  });

  $("#arrived-at-facilityy").click(function (e) {
    $("#distance-not-acceptable").hide();
    $("#distance-acceptable").show();
  });

  $("#arrivalFormDanone").submit(function (e) {
    e.preventDefault();
    e.stopPropagation();
    var form = $(this);
    var valid = true;

    var reason = $("#arrivalStatus").val();
    if (!reason) valid = false;

    if (reason == "backhaul") {
      var fields = [
        "orderNumberBackhaul",
        "referenceNumberBackhaul",
        "palletsBackhaul",
        "weightBackhaul",
        "trailerNumberBackhaul",
      ];

      for (var i = 0; i < fields.length; i++) {
        if (!isValid(fields[i])) {
          valid = false;
        }
      }
    }

    if (reason == "emptyTrailer") {
      if ($("#trailerNumberEmpty").val().length < 4) {
        document
          .querySelector("#trailerNumberEmpty")
          .classList.add("is-invalid");
        valid = false;
      }

      if (!$("#yCheck").prop("checked") && !$("#nCheck").prop("checked") && !$("#n2Check").prop("checked")) {
        $("#yesLabel").addClass("invalid");
        $("#yesCheck").addClass("invalid");
        $("#noLabel").addClass("invalid");
        $("#noCheck").addClass("invalid");
        $("#no2Label").addClass("invalid");
        $("#no2Check").addClass("invalid");
        //$("#noLabel").addClass("is-invalid");
        valid = false;
      }
    }

    if (reason == "samples" || reason == "chepPallets") {
      var fields = ["palletsSamples", "trailerNumberSamples"];

      for (var i = 0; i < fields.length; i++) {
        if (!isValid(fields[i])) {
          valid = false;
        }
      }
    }

    if (reason == "refusedLoad") {
      var fields = [
        "orderNumberRefused",
        "referenceNumberRefused",
        "palletsRefused",
        "weightRefused",
        "trailerNumberRefused",
      ];

      for (var i = 0; i < fields.length; i++) {
        if (!isValid(fields[i])) {
          valid = false;
        }
      }
    }

    if (!valid) {
      e.preventDefault();
      e.stopPropagation();
      return false;
    }

    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: "status=READY",
    }).done(function (data) {
      window.location.reload();
    });
  });

  $("#arrivalForm").submit(function (e) {
    e.preventDefault();
    e.stopPropagation();
    var form = $(this);
    var valid = true;

    var facility = $("#facilityName").val();

    if (!facility) {
      document.querySelector("#facilityName").classList.add("is-invalid");
      valid = false;
    }

    if (facility == "danone") {
      var reason = $("#arrivalStatus").val();
      if (!reason) valid = false;

      if (reason == "backhaul") {
        var fields = [
          "orderNumberBackhaul",
          "referenceNumberBackhaul",
          "palletsBackhaul",
          "weightBackhaul",
          "trailerNumberBackhaul",
        ];

        for (var i = 0; i < fields.length; i++) {
          if (!isValid(fields[i])) {
            valid = false;
          }
        }
      }

      if (
        reason == "emptyTrailer" &&
        $("#trailerNumberEmpty").val().length < 4
      ) {
        document
          .querySelector("#trailerNumberEmpty")
          .classList.add("is-invalid");
        valid = false;
      }

      if (reason == "samples" || reason == "chepPallets") {
        var fields = ["palletsSamples", "trailerNumberSamples"];

        for (var i = 0; i < fields.length; i++) {
          if (!isValid(fields[i])) {
            valid = false;
          }
        }
      }

      if (reason == "refusedLoad") {
        var fields = [
          "orderNumberRefused",
          "referenceNumberRefused",
          "palletsRefused",
          "weightRefused",
          "trailerNumberRefused",
        ];

        for (var i = 0; i < fields.length; i++) {
          if (!isValid(fields[i])) {
            valid = false;
          }
        }
      }
    }

    if (facility == "accoi" || facility == "acont" || facility == "lineage") {
      var fields = [
        "orderNumber",
        "referenceNumber",
        "pallets",
        "weight",
        "trailer",
      ];

      for (var i = 0; i < fields.length; i++) {
        if (!isValid(fields[i])) {
          valid = false;
        }
      }
    }

    if (facility == "northern") {
      if (!$("#reason").val()) {
        document.querySelector("#reason").classList.add("is-invalid");
        valid = false;
      } else {
        document.querySelector("#reason").classList.remove("is-invalid");
      }
      if ($("#reason").val() == "other" && !isValid("otherReason")) {
        valid = false;
      }
    }

    if (facility == "fuel") {
    }

    if (!valid) {
      e.preventDefault();
      e.stopPropagation();
      return false;
    }

    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: form.serialize(),
      dataType: "text",
    }).done(function (data) {});
  });

  $("#facilityName").change(function () {
    var selection = $(this).val();

    if (selection == "danone") {
      $("select#arrivalStatus").prop("selectedIndex", 0);
      toggleVisibility("danoneArrival");
    } else if (
      selection == "accoi" ||
      selection == "acont" ||
      selection == "lineage"
    ) {
      toggleVisibility("normalArrival");
    } else if (selection == "northern") {
      toggleVisibility("northernArrival");
    } else if (selection == "fuel") {
      toggleVisibility("fuelArrival");
    }
  });

  $("#reason").change(function () {
    var selection = $(this).val();
    if (selection == "other") {
      $("#other").attr("hidden", false);
    } else {
      $("#other").attr("hidden", true);
    }
  });

  $("#forfeit-shipment-button").click(function () {
    $.ajax({
      type: "POST",
      url: ".",
      data: "status=FORFEIT_SHIPMENT",
    }).done(function (data) {
      window.location.reload();
    });
  });

  $("#arrivalStatus").change(function () {
    var selection = $(this).val();
    if (selection == "bobtail") {
      toggleVisibility("bobtailArrival");
    } else if (selection == "backhaul") {
      toggleVisibility("backhaulArrival");
    } else if (selection == "emptyTrailer") {
      toggleVisibility("emptyArrival");
    } else if (selection == "samples" || selection == "chepPallets") {
      toggleVisibility("palletsOrSamples");
    } else if (selection == "refusedLoad") {
      toggleVisibility("refusedLoadArrival");
    }
  });

  $("#refuse-instructions-form").submit(function (e) {
    var valid = true;

    if (!$("#refusal-reason").val()) {
      $("#refusal-reason").addClass("is-invalid");
      valid = false;
    } else {
      $("#refusal-reason").removeClass("is-invalid");
    }
    if ($("#refusal-reason").val().includes("other")) {
      if (!isValid("refusal-other", 10)) {
        $("#refusal-other").addClass("is-invalid");
        valid = false;
      } else {
        $("#refusal-other").removeClass("is-invalid");
      }
    }

    if (!valid) {
      e.preventDefault();
      e.stopPropagation();
      return false;
    }

    $.ajax({
      type: "POST",
      url: ".",
      data: "status=INSTRUCTIONS_REFUSED",
    }).done(function (data) {
      window.location.reload();
    });
  });

  $("#refusal-reason").change(function () {
    var selection = $(this).val();
    if (selection == "other") {
      $("#other-refusal").show();
      window.scrollTo(0, document.body.scrollHeight);
    } else if (selection === "trailer") {
      $(".trailer-reason").show();
      $("#other-refusal").hide();
      window.scrollTo(0, document.body.scrollHeight);
    } else {
      $("#other-refusal").hide();
      $(".trailer-reason").hide();
    }
    $("#send-refusal").removeClass("disabled");
    $("#refusal-reason").removeClass("is-invalid");
    $("#refusal-other").removeClass("is-invalid");
  });

  $("#trailer-reason").change(function () {
    var selection = $(this).val();
    if (selection === "other") {
      $("#other-trailer").show();
      window.scrollTo(0, document.body.scrollHeight);
    } else {
      $("#other-trailer").hide();
    }
    $("#trailer-oos-prompt").show();
  });

  $("#finished-refusal, #return-to-work").click(function () {
    $.ajax({
      type: "POST",
      url: ".",
      data: "status=READY",
    }).done(function (data) {
      window.location.reload();
    });
  });

  $("#driver-unavailable").click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    $("#main").hide();
    $("#issuePrompt").show();
  });

  $("#canDriveToShop").change(function () {
    var selection = $(this).val();
    if (selection === "no") {
      $("#mechanical-issue-rescue-prompt").show();
    }
    $("#mechanicalDescription").show();
  });

  $("#unavailable-reason").change(function () {
    var selection = $(this).val();
    if (selection == "other") {
      $("#stop-locations-prompt").hide();
      $("#fuel-stations-prompt").hide();
      $("#other-unavailable").show();
      $("#mechanicalDescription").hide();
      $("#mechanical-issue-prompt").hide();
      $("#mechanical-issue-rescue-prompt").hide();
      window.scrollTo(0, document.body.scrollHeight);
    } else if (selection === "stop") {
      $("#other-unavailable").hide();
      $("#stop-locations-prompt").show();
      $("#fuel-stations-prompt").hide();
      $("#mechanicalDescription").hide();
      $("#mechanical-issue-prompt").hide();
      $("#mechanical-issue-rescue-prompt").hide();
    } else if (selection === "mechanical") {
      $("#other-unavailable").hide();
      $("#stop-locations-prompt").hide();
      $("#fuel-stations-prompt").hide();
      $("#mechanical-issue-prompt").show();
      $("#mechanicalDescription").hide();
    } else {
      $("#stop-locations-prompt").hide();
      $("#fuel-stations-prompt").hide();
      $("#other-unavailable").hide();
      $("#mechanicalDescription").hide();
      $("#mechanical-issue-prompt").hide();
      $("#mechanical-issue-rescue-prompt").hide();
    }
    $("#sendIssueForm").removeClass("disabled");
    $("#unavailable-reason").removeClass("is-invalid");
    $("#unavailable-other").removeClass("is-invalid");
  });

  $("#stop-locations").change(function () {
    var selection = $(this).val();
    if (selection == "fuel") {
      $("#other-unavailable").hide();
      $("#fuel-stations-prompt").show();
      $("#nrtYardReason").hide();
    } else if (selection === "nrt") {
      $("#other-unavailable").hide();
      $("#fuel-stations-prompt").hide();
      $("#nrtYardReason").show();
    } else {
      $("#other-unavailable").hide();
      $("#fuel-stations-prompt").hide();
      $("#nrtYardReason").hide();
    }
    $("#sendIssueForm").removeClass("disabled");
    $("#unavailable-reason").removeClass("is-invalid");
    $("#unavailable-other").removeClass("is-invalid");
  });

  $("#rescue-needed").change(function () {
    var selection = $(this).val();
    if (selection === "yes") {
      $("#other-unavailable").hide();
      $("#fuel-stations-prompt").show();
    } else {
      $("#other-unavailable").hide();
    }
    $("#sendIssueForm").removeClass("disabled");
    $("#unavailable-reason").removeClass("is-invalid");
    $("#unavailable-other").removeClass("is-invalid");
  });

  $("#unavailable-form").submit(function (e) {
    e.preventDefault();
    e.stopPropagation();

    var unavailableReason = "Unhandled: " + $("#unavailable-reason").val();
    if ($("#unavailable-reason").val() == "lunch") {
      unavailableReason = "Lunch Break";
    } else if ($("#unavailable-reason").val() == "mechanical") {
      unavailableReason = "Mechanical Issue";
    } else if ($("#unavailable-reason").val() == "stop") {
      if ($("#stop-locations").val() === "fuel") {
        unavailableReason = "Fuel Station";
      } else if ($("#stop-locations").val() === "wash") {
        unavailableReason = "Truck Wash";
      } else {
        unavailableReason = "Northern Yard";
      }
    }

    $.ajax({
      type: "POST",
      url: ".",
      data: "status=DRIVER_UNAVAILABLE&reason=" + unavailableReason,
    }).done(function (data) {
      window.location.reload();
    });
  });
});

function getFormattedTime(time) {
  let hrs = Math.floor(time / 3600);
  let mins = Math.floor(time / 60);
  let secs = time - mins * 60;
  if (hrs < 10) hrs = "0" + hrs;
  if (mins < 10) mins = "0" + mins;
  if (secs < 10) secs = "0" + secs;
  return hrs > 0 ? `${hrs}:${mins}:${secs}` : `${mins}:${secs}`;
}
