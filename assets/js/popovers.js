var driverAssignment = [];

$(document).ready(function () {
  // Opening popover - hide all other popovers and set variables
  $(document).on(
    "click",
    '[data-toggle="popover-assign"], [data-toggle="popover-shipment"]',
    function (e) {
      e.preventDefault();
      e.stopPropagation();

      var name = $(this).popover().attr("data-driver-name");
      if (name) {
        var split = name.split(" ");
        sessionStorage.setItem("driverName", split[split.length - 2]);
        driverAssignment["name"] = split[split.length - 2];
      }

      var driverId = $(this).popover().attr("data-driver-id");
      if (driverId) {
        sessionStorage.setItem("driverId", driverId);
        driverAssignment["driverId"] = driverId;
      }

      var dataIndex = $(this).popover().attr("data-index");
      sessionStorage.setItem("popoverId", dataIndex);

      if ($(this).attr("data-type") === "outbound-shipment-details") {
        updateShipmentDetails(true);
      } else if ($(this).attr("data-type") === "inbound-shipment-details") {
        updateShipmentDetails(false);
      } else {
        $.ajax({
          type: "GET",
          url: "src/requests/driver.php",
          data: "action=get-status&driverId=" + driverAssignment["driverId"],
          dataType: "JSON",
        }).done(function (data) {
          var hasTrailer = data["data"]["status"] !== "AVAILABLE";
          if (hasTrailer) {
            $(".popover-body .assign-driver-choices").hide();
            loadAvailableDoors();
          }
        });
      }

      updateCurrentPopover();

      // Hide all Popovers that are not the currently selected Popover
      $('[data-toggle="popover-shipment"]').not(this).popover("hide");
      $('[data-toggle="popover-assign"]').not(this).popover("hide");
    }
  );

  // Closing popover by clicking the "X" in the corner
  $(document).on("click", ".close-popover", function (e) {
    e.preventDefault();
    e.stopPropagation();

    hideCurrentPopover();
  });

  $(document).on("click", "#assign-yard-moves", function (e) {
    $(".popover-body .assign-driver-choices").hide();
    $(".popover-body .extra-move-fields").html("");

    loadPopoverContinuation("#assign-moves-popover");
  });

  $(document).on("click", "#assign-door", function (e) {
    $(".popover-body .assign-driver-choices").hide();

    loadAvailableShipments();
  });

  $(document).on("click", "#assign-other", function (e) {
    $(".popover-body .assign-driver-choices").hide();

    loadPopoverContinuation("#assign-other-popover");
  });

  $(document).on("click", "#bring-empty", function (e) {
    loadPopoverContinuation(".assign-empty-facilities");
  });

  $(document).on("click", "#pickup-backhaul", function (e) {
    loadPopoverContinuation(".assign-backhaul-facilities");
  });

  $(document).on("click", "#rescue-shipment", function (e) {
    loadPopoverContinuation(".assign-rescue-popover");
  });

  $(document).on("click", "#take-oos-trailer", function (e) {
    loadPopoverContinuation(".assign-oos-trailer-popover");
  });

  $(document).on("click", "#yes-shipment", function (e) {
    $(".popover-body .popover-continuation").html("");

    loadAvailableShipments();
  });

  // Handles clicking the + icon on the Assign Popover
  $(document).on("click", "#addMoves", function (e) {
    e.preventDefault();

    // Number of current fields, divided by 2 because Popover creates a copy of the HTML
    var numFields = $("[id^=assign-move]").length / 2;

    // Add extra rows of input fields for extra moves
    var removeButton =
      '<a href="" class="remove-move-row"><i class="bi bi-dash-circle" style="color: red; font-size: 1rem; position: relative; top: -35px; right: -174px;"></i></a>';
    var beginningHtml = $(".move-field")
      .html()
      .trim()
      .slice(0, -6)
      .replace("assign-move-1", "assign-move-" + numFields)
      .replace("trailerNumber-1", "trailerNumber-" + numFields)
      .replace("location-1", "location-" + numFields);
    var endingHtml = $(".move-field").html().trim().slice(-6);

    $(".error-message").html("");
    $(".extra-move-fields").append(beginningHtml + removeButton + endingHtml);

    updateCurrentPopover();
  });

  $(document).on("click", "#add-moves-cordova", function (e) {
    e.preventDefault();

    // Number of current fields, divided by 2 because Popover creates a copy of the HTML
    var numFields = $(".popover-body [id^=assign-cordova-move]").length;

    // Add extra rows of input fields for extra moves
    var removeButton =
      '<a href="" class="remove-move-row"><i class="bi bi-dash-circle" style="color: red; font-size: 1rem; position: relative; top: -35px; right: -174px;"></i></a>';
    var beginningHtml = $(".cordova-move-field")
      .html()
      .trim()
      .slice(0, -6)
      .replace("assign-cordova-move-0", "assign-cordova-move-" + numFields)
      .replace("trailerNumber-0", "trailerNumber-" + numFields)
      .replace("location-0", "location-" + numFields);
    var endingHtml = $(".cordova-move-field").html().trim().slice(-6);

    $("form .separator").show();

    $(".error-message").html("");
    $(".cordova-move-fields").append(beginningHtml + removeButton + endingHtml);

    updateCurrentPopover();
  });

  // Handles clicking the + icon on the Assign Popover on warehouse Page
  $(document).on("click", "#add-moves-warehouse", function (e) {
    e.preventDefault();

    // Number of current fields, divided by 2 because Popover creates a copy of the HTML
    var numFields = $(".popover-body [id^=assign-warehouse-move]").length;

    // Add extra rows of input fields for extra moves
    var removeButton =
      '<a href="" class="remove-move-row"><i class="bi bi-dash-circle" style="color: red; font-size: 1rem; position: relative; top: -35px; right: -174px;"></i></a>';
    var beginningHtml = $(".warehouse-move-field")
      .html()
      .trim()
      .slice(0, -6)
      .replace("assign-warehouse-move-0", "assign-warehouse-move-" + numFields)
      .replace("trailerNumber-0", "trailerNumber-" + numFields)
      .replace("location-0", "location-" + numFields);
    var endingHtml = $(".warehouse-move-field").html().trim().slice(-6);

    $("form .separator").show();

    $(".error-message").html("");
    $(".warehouse-move-fields").append(
      beginningHtml + removeButton + endingHtml
    );

    updateCurrentPopover();
  });

  // Remove the row for the specified Popover
  $(document).on("click", ".remove-move-row", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $($(this).parent()).remove();
    $(".error-message").html("");

    var numFields = $(".popover-body [id^=assign-warehouse-move]").length;
    var numFields2 = $(".popover-body [id^=assign-cordova-move]").length;

    if (numFields <= 1 && numFields2 <= 1) {
      $("form .separator").hide();
    }

    updateCurrentPopover();
  });

  // Reset the shown Popover HTML to remove any added fields by other Popovers.
  $(document).on("show.bs.popover", function () {
    $(".popover-continuation").html("");
    $(".popover-continuation-cordova").html("");
    $(".popover-continuation-warehouse").html("");
    $(".yard-moves-separator").hide();
    $(".cordova-move-fields").html("");
    $(".warehouse-move-fields").html("");
    $(".assign-warehouse").show();
    $(".assign-cordova").show();
    $(".assign-driver-choices").show();
  });

  /*
   * Finishing dialogues
   */
  $(document).on("click", "#send-assignment-button", function (e) {
    e.preventDefault();
    e.stopPropagation();

    var form = $(".popover-body").find("#yardMoveForm :text");
    var inputCount = form.length / 2;

    var valid = true;

    var index = 0;
    var moves = [];
    var trailers = [];
    var locations = [];
    form.each(function () {
      if (index == 0) {
        moves = [];
      }
      if (this.value.length < 1) {
        valid = false;
        return false;
      }
      if (index % 2 == 0) {
        trailers.push(this.value);
      } else {
        locations.push(this.value);
      }
      index++;
    });

    if (!valid || trailers.length != locations.length) {
      e.preventDefault();
      e.stopPropagation();
      $(".error-message").html("All fields must be filled out.");
      return;
    }

    for (let i = 0; i < trailers.length; i++) {
      moves[i] = { trailer: trailers[i], location: locations[i] };
    }

    driverAssignment["moves"] = moves;

    $(".popover-body .popover-continuation").html("");
    $(".popover-body .popover-continuation").append(
      $("#success-popover")
        .html()
        .replace("DRIVER", sessionStorage.getItem("driverName"))
    );

    var stringToAppend =
      '<div class="text-' + (moves.length <= 1 ? "center" : "start") + '">';

    Object.values(moves).forEach((val) => {
      var trailerIsOC = val["trailer"].toLowerCase().includes("oc");
      var locationIsOC = val["location"].toLowerCase().includes("oc");
      var trailerIsEmpty =
        val["trailer"].toLowerCase().includes("empty") ||
        val["trailer"].toLowerCase().startsWith("e");

      var trailerIsDoor =
        val["trailer"].toLowerCase().includes("d") ||
        val["trailer"].length <= 2;
      var locationIsDoor =
        (val["location"].toLowerCase().includes("d") &&
          val["location"].length <= 2) ||
        !val["location"].toLowerCase().startsWith("s");

      var source = val["trailer"]
        .toLowerCase()
        .replace("d", "")
        .replace("oc", "")
        .trim();
      var destination = val["location"]
        .toLowerCase()
        .replace("d", "")
        .replace("oc", "")
        .trim();

      if (trailerIsOC) {
        source += " (OC)";
      }
      if (locationIsOC) {
        destination += " (OC)";
      }

      if (trailerIsDoor && locationIsDoor) {
        stringToAppend +=
          "Move <strong>door " +
          source +
          "</strong> to <strong>door " +
          destination +
          "</strong><br />";
        assignYardMove(
          source,
          "d",
          destination,
          "d",
          driverAssignment["driverId"]
        );
      } else if (trailerIsDoor && !locationIsDoor) {
        stringToAppend +=
          "Move <strong>door " +
          source +
          "</strong> to the <strong>side building</strong><br />";
        assignYardMove(
          source,
          "d",
          destination,
          "y",
          driverAssignment["driverId"]
        );
      } else if (!trailerIsDoor && locationIsDoor && !trailerIsEmpty) {
        stringToAppend +=
          "Move <strong>trailer " +
          source +
          "</strong> to <strong>door " +
          destination +
          "</strong><br />";
        assignYardMove(
          source,
          "y",
          destination,
          "d",
          driverAssignment["driverId"]
        );
      } else if (!trailerIsDoor && !locationIsDoor && !trailerIsEmpty) {
        stringToAppend +=
          "Move <strong>trailer " +
          source +
          "</strong> to the <strong>side building</strong><br />";
        assignYardMove(
          source,
          "y",
          destination,
          "y",
          driverAssignment["driverId"]
        );
      } else if (trailerIsEmpty && locationIsDoor) {
        stringToAppend +=
          "Put an <strong>empty</strong> trailer into <strong>door " +
          destination +
          "</strong><br />";
      } else {
        stringToAppend +=
          "Unhandled: [source=" +
          source +
          ", destination=" +
          destination +
          ", trailerIsDoor=" +
          trailerIsDoor +
          ", locationIsDoor=" +
          locationIsDoor +
          ", trailerIsEmpty=" +
          trailerIsEmpty +
          ", trailerIsOC=" +
          trailerIsOC +
          ", locationIsOC=" +
          locationIsOC +
          "]";
      }
      //TODO: process yard moves and add status to driver
    });
    stringToAppend += "</div>";

    $(".assignments").html("");
    $(".assignments").html(stringToAppend);

    updateCurrentPopover();

    //console.log($(".popover-body").find("#yardMoveForm").serializeArray());
  });

  $(document).on("click", "#send-assignment-button-warehouse", function (e) {
    e.preventDefault();
    e.stopPropagation();

    var form = $(".popover-body").find("#assignWarehouseForm :text");
    var inputCount = form.length / 2;

    var valid = true;

    var index = 0;
    var data = [];
    var trailers = [];
    var locations = [];
    form.each(function () {
      if (index == 0) {
        data = [];
      }
      if (this.id === "trailerNumber-0" || this.id === "location-0") {
        return;
      }
      if (this.value.length < 1) {
        valid = false;
        return false;
      }
      if (index % 2 == 0) {
        trailers.push(this.value);
      } else {
        locations.push(this.value);
      }
      index++;
    });

    if (!valid || trailers.length != locations.length) {
      e.preventDefault();
      e.stopPropagation();
      $(".error-message").html("All fields must be filled out.");
      return;
    }

    for (let i = 0; i < trailers.length; i++) {
      data[i] = { trailer: trailers[i], location: locations[i] };
    }

    driverAssignment["moves"] = data;

    $(".assign-warehouse").hide();
    $(".popover-continuation-warehouse").html("");
    $(".popover-continuation-warehouse").append(
      $("#success-popover")
        .html()
        .replace("DRIVER", sessionStorage.getItem("driverName"))
    );

    var stringToAppend =
      '<div class="text-' + (data.length <= 1 ? "center" : "start") + '">';
    Object.values(data).forEach((val, i) => {
      var trailerIsEmpty = val["trailer"].toLowerCase().includes("empty");
      var trailerIsFence = val["trailer"].startsWith("f");
      var trailerIsDoor =
        val["trailer"].toLowerCase().includes("d") ||
        (val["trailer"].length <= 2 && !trailerIsFence);
      var locationIsDoor =
        (val["location"].toLowerCase().includes("d") &&
          val["location"].length <= 2) ||
        !val["location"].toLowerCase().startsWith("f");

      var source = val["trailer"].toLowerCase().replace("d", "").trim();
      var destination = val["location"].toLowerCase().replace("d", "").trim();

      var backhaul = destination.includes("bh") || destination.includes("back");

      if (trailerIsDoor && locationIsDoor && !backhaul) {
        if (i == 0) {
          stringToAppend +=
            "Drop in <strong>door " +
            source +
            "</strong> and take the empty from <strong>door " +
            destination +
            "</strong><br />";
        } else {
          stringToAppend +=
            "Move <strong>door " +
            source +
            "</strong> to <strong>door " +
            destination +
            "</strong><br />";
        }
      } else if (trailerIsDoor && !locationIsDoor && !backhaul) {
        if (i == 0) {
          stringToAppend +=
            "Drop in <strong>door " +
            source +
            "</strong> and take an empty from <strong>the fence</strong><br />";
        } else {
          stringToAppend +=
            "Move <strong>door " +
            source +
            "</strong> to <strong>the fence</strong><br />";
        }
      } else if (trailerIsDoor && locationIsDoor && backhaul) {
        stringToAppend +=
          "Drop in <strong>door " +
          source +
          "</strong> and take a backhaul from <strong>door " +
          destination.replace("bh", "").trim() +
          "</strong><br />";
      } else if (trailerIsDoor && !locationIsDoor && backhaul) {
        stringToAppend +=
          "Drop in <strong>door " +
          source +
          "</strong> and take a backhaul from <strong>the fence</strong><br />";
      } else if (trailerIsFence && locationIsDoor) {
        stringToAppend +=
          "Put an empty <strong>from the fence</strong> into <strong>door " +
          destination +
          "</strong><br />";
      } else {
        stringToAppend +=
          "Unhandled: [source=" +
          source +
          ", destination=" +
          destination +
          ", trailerIsDoor=" +
          trailerIsDoor +
          ", locationIsDoor=" +
          locationIsDoor +
          ", trailerIsEmpty=" +
          trailerIsEmpty +
          ", trailerIsFence=" +
          trailerIsFence +
          "]";
      }
    });
    stringToAppend += "</div>";

    //TODO: update driver info
    $(".assignments").html("");
    $(".assignments").html(stringToAppend);

    updateCurrentPopover();
  });

  $(document).on("click", "#send-assignment-button-cordova", function (e) {
    e.preventDefault();
    e.stopPropagation();

    var form = $(".popover-body").find("#assignCordovaForm :text");
    var inputCount = form.length / 2;

    var valid = true;

    var index = 0;
    var data = [];
    var trailers = [];
    var locations = [];
    form.each(function () {
      if (index == 0) {
        data = [];
      }
      if (this.id === "trailerNumber-0" || this.id === "location-0") {
        return;
      }
      if (this.value.length < 1) {
        valid = false;
        return false;
      }
      if (index % 2 == 0) {
        trailers.push(this.value);
      } else {
        locations.push(this.value);
      }
      index++;
    });

    if (!valid || trailers.length != locations.length) {
      e.preventDefault();
      e.stopPropagation();
      $(".error-message").html("All fields must be filled out.");
      return;
    }

    for (let i = 0; i < trailers.length; i++) {
      data[i] = { trailer: trailers[i], location: locations[i] };
    }

    driverAssignment["moves"] = data;

    $(".assign-cordova").hide();
    $(".popover-continuation-cordova").html("");
    $(".popover-continuation-cordova").append(
      $("#success-popover")
        .html()
        .replace("DRIVER", sessionStorage.getItem("driverName"))
    );

    var stringToAppend =
      '<div class="text-' + (data.length <= 1 ? "center" : "start") + '">';
    Object.values(data).forEach((val, i) => {
      var trailerIsOC = val["trailer"].toLowerCase().includes("oc");
      var locationIsOC = val["location"].toLowerCase().includes("oc");
      var trailerIsEmpty =
        val["trailer"].toLowerCase().includes("empty") ||
        val["trailer"].toLowerCase().startsWith("e");
      var trailerIsFence = val["trailer"].startsWith("s");
      var trailerIsDoor =
        val["trailer"].toLowerCase().includes("d") ||
        val["trailer"].length <= 2 ||
        val["trailer"].toLowerCase().includes("oc");
      var locationIsDoor =
        (val["location"].toLowerCase().includes("d") &&
          val["location"].length <= 2) ||
        !val["location"].toLowerCase().startsWith("s");

      var source = val["trailer"]
        .toLowerCase()
        .replace("d", "")
        .replace("oc", "")
        .trim();
      var destination = val["location"]
        .toLowerCase()
        .replace("d", "")
        .replace("oc", "")
        .trim();

      if (trailerIsOC) {
        source += " (OC)";
      }
      if (locationIsOC) {
        destination += " (OC)";
      }

      var backhaul = destination.includes("bh") || destination.includes("back");

      if (trailerIsDoor && locationIsDoor && !backhaul) {
        if (i == 0) {
          stringToAppend +=
            "Drop in <strong>D" +
            source +
            "</strong> and take the empty from <strong>D" +
            destination +
            "</strong><br />";
        } else {
          stringToAppend +=
            "Move <strong>D" +
            source +
            "</strong> to <strong>D" +
            destination +
            "</strong><br />";
        }
      } else if (trailerIsDoor && !locationIsDoor && !backhaul) {
        if (i == 0) {
          stringToAppend +=
            "Drop in <strong>D" +
            source +
            "</strong> and take an empty from <strong>the side building</strong><br />";
        } else {
          stringToAppend +=
            "Move <strong>D" +
            source +
            "</strong> to <strong>the side building</strong><br />";
        }
      } else if (trailerIsDoor && locationIsDoor && backhaul) {
        stringToAppend +=
          "Drop in <strong>D" +
          source +
          "</strong> and take a backhaul from <strong>D" +
          destination.replace("bh", "").trim() +
          "</strong><br />";
      } else if (trailerIsDoor && !locationIsDoor && backhaul) {
        stringToAppend +=
          "Drop in <strong>D" +
          source +
          "</strong> and take a backhaul from <strong>the side building</strong><br />";
      } else if (trailerIsFence && locationIsDoor) {
        stringToAppend +=
          "Put an empty <strong>from the side building</strong> into <strong>D" +
          destination +
          "</strong><br />";
      } else {
        stringToAppend +=
          "Unhandled: [source=" +
          source +
          ", destination=" +
          destination +
          ", trailerIsDoor=" +
          trailerIsDoor +
          ", locationIsDoor=" +
          locationIsDoor +
          ", trailerIsEmpty=" +
          trailerIsEmpty +
          ", trailerIsFence=" +
          trailerIsFence +
          "]";
      }
    });
    stringToAppend += "</div>";

    //TODO: update driver info
    $(".assignments").html("");
    $(".assignments").html(stringToAppend);

    updateCurrentPopover();
  });

  $(document).on("click", ".drop-trailer", function (e) {
    driverAssignment["drop"] = $(this).data("door");

    loadPopoverContinuation("#shipment-ready-popover");
  });

  $(document).on("click", ".take-trailer", function (e) {
    $(".popover-body .popover-continuation").html("");
    $(".popover-body .popover-continuation").append(
      $("#success-popover")
        .html()
        .replace("DRIVER", sessionStorage.getItem("driverName"))
    );

    driverAssignment["take"] = $(this).data("door");
    driverAssignment["trailer"] = $(this).data("trailer");
    driverAssignment["shipmentId"] = $(this).data("id");

    $(".assignments").html("");
    if (driverAssignment["drop"]) {
      $(".assignments").append(
        "<strong>Drop</strong> their trailer " +
          (driverAssignment["drop"] === "sb"
            ? "on the <strong>side building</strong>"
            : "into <strong>door " + driverAssignment["drop"]) +
          "</strong><br />"
      );
      //TODO: update trailer in the door/yard and driver status
      processTrailerDrop(
        driverAssignment["drop"],
        driverAssignment["driverId"]
      );
    }
    //TODO: update trailer in the door/yard and driver status
    $(".assignments").append(
      "<div class='text-center'>Take <strong>trailer " +
        driverAssignment["trailer"] +
        "</strong> from " +
        (driverAssignment["take"] === "sb"
          ? "the <strong>side building</strong>"
          : "<strong>door " + driverAssignment["take"]) +
        "</strong><br /><em>Shipment ID: " +
        driverAssignment["shipmentId"] +
        "</div>"
    );
    assignShipment(
      driverAssignment["shipmentId"],
      driverAssignment["driverId"],
      driverAssignment["trailer"],
      driverAssignment["take"]
    );

    updateCurrentPopover();
  });

  $(document).on("click", ".pu-backhaul", function (e) {
    var facility = $(this).data("facility");
    driverAssignment["backhaul"] = facility;

    $(".popover-body .popover-continuation").html("");
    $(".popover-body .popover-continuation").append(
      $("#success-popover")
        .html()
        .replace("DRIVER", sessionStorage.getItem("driverName"))
    );

    var facilityName = "";
    if (facility === "accoi") {
      facilityName = "Americold COI";
    } else if (facility === "acont") {
      facilityName = "Americold Ontario";
    } else if (facility === "lineage") {
      facilityName = "Lineage";
    }

    $(".assignments").html("");
    $(".assignments").append(
      "<div class='text-center'>Pick up a <strong>backhaul</strong> from <strong>" +
        facilityName +
        "</strong></div>"
    );
    assignPickupBackhaul(driverAssignment["driverId"]);
    //TODO: assign & update driver status

    updateCurrentPopover();
  });

  $(document).on("click", ".pu-empty", function (e) {
    var facility = $(this).data("facility");
    driverAssignment["empty"] = facility;

    $(".popover-body .popover-continuation").html("");
    $(".popover-body .popover-continuation").append(
      $("#success-popover")
        .html()
        .replace("DRIVER", sessionStorage.getItem("driverName"))
    );

    var facilityName = "";
    if (facility === "accoi") {
      facilityName = "Americold COI";
    } else if (facility === "acont") {
      facilityName = "Americold Ontario";
    } else if (facility === "lineage") {
      facilityName = "Lineage";
    } else if (facility === "nrt") {
      facilityName = "the Northern Yard";
    }

    $(".assignments").html("");
    $(".assignments").append(
      "<div class='text-center'>Bring an <strong>empty</strong> trailer from <strong>" +
        facilityName +
        "</strong></div>"
    );
    assignPickupEmpty(driverAssignment["driverId"]);
    //TODO: assign & update driver status

    updateCurrentPopover();
  });

  $(document).on("click", ".pu-shipment", function (e) {
    var facility = $(this).data("facility");
    driverAssignment["empty"] = facility;

    $(".popover-body .popover-continuation").html("");
    $(".popover-body .popover-continuation").append(
      $("#success-popover")
        .html()
        .replace("DRIVER", sessionStorage.getItem("driverName"))
    );

    var facilityName = "";
    if (facility === "accoi") {
      facilityName = "Americold COI";
    } else if (facility === "acont") {
      facilityName = "Americold Ontario";
    } else if (facility === "lineage") {
      facilityName = "Lineage";
    } else if (facility === "nrt") {
      facilityName = "the Northern Yard";
    }

    $(".assignments").html("");
    $(".assignments").append(
      "<div class='text-center'>Rescue a <strong>shipment</strong> from <strong>" +
        facilityName +
        "</strong><br /><em>Shipment ID: " +
        $(this).attr("id") +
        "</em></div>"
    );
    assignRescueShipment(driverAssignment["driverId"]);
    //assignPickupEmpty(driverAssignment["driverId"]);
    //TODO: assign & update driver status

    updateCurrentPopover();
  });

  $(document).on("click", "#no-shipment", function (e) {
    $(".popover-body .popover-continuation").html("");
    $(".popover-body .popover-continuation").append(
      $("#success-popover")
        .html()
        .replace("DRIVER", sessionStorage.getItem("driverName"))
    );

    $(".assignments").html("");
    if (driverAssignment["drop"] == "sb") {
      $(".assignments").html(
        "<div class='text-center'><strong>Drop</strong> their trailer on the <strong>side building</strong></div>"
      );
      //TODO: add trailer to the yard and update driver status
    } else {
      //TODO: add trailer to the door and update driver status
      $(".assignments").html(
        "<div class='text-center'><strong>Drop</strong> their trailer into <strong>door " +
          driverAssignment["drop"] +
          "</strong></div>"
      );
    }
    processTrailerDrop(driverAssignment["drop"], driverAssignment["driverId"]);

    updateCurrentPopover();
  });
});

function updateCurrentPopover() {
  var currentPopoverId = $(
    ".popover-assign-" + sessionStorage.getItem("popoverId") + ""
  ).attr("id");
  var exampleTriggerEl = document.getElementById(currentPopoverId);
  var popover = bootstrap.Popover.getInstance(exampleTriggerEl);
  if (popover != null) popover.update();
}

/*
 * Populate the Popover list
 */
function initializePopovers() {
  var popoverTriggerList = [].slice.call(
    document.querySelectorAll('[data-toggle="popover-assign"]')
  );
  popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl, {
      html: true,
      sanitize: false,
      trigger: "click",
      container: $(this).attr("data-facility")
        ? ".card-header-options-no-header"
        : "body",
      template:
        '<div class="popover popover-assign-' +
        $(popoverTriggerEl).attr("data-index") +
        '"><a href="" class="close-popover"><i class="bi bi-x" style="color: var(--mron-green); font-weight: bold; font-size: 1.7rem; position: absolute; top: 0; right: 10px;"></i></a><div class="popover-arrow"></div><h3 class="popover-header px-5"></h3><div class="popover-body"></div></div>',
      title: function () {
        if ($(this).attr("data-driver-name")) {
          return "Assigning " + $(this).attr("data-driver-name");
        } else if ($(this).attr("data-facility")) {
          return "Set Shipment Target";
        } else {
          return "Shipment Details";
        }
      },
      content: function () {
        return $("#assign-" + $(this).attr("data-type") + "-popover").html();
      },
    });
  });
}

function initializePopovers2() {
  var popoverTriggerList = [].slice.call(
    document.querySelectorAll('[data-toggle="popover-shipment"]')
  );
  popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl, {
      html: true,
      sanitize: false,
      trigger: "click",
      container: "body",
      template:
        '<div class="popover popover-assign-' +
        $(popoverTriggerEl).attr("data-index") +
        '"><a href="" class="close-popover"><i class="bi bi-x" style="color: var(--mron-green); font-weight: bold; font-size: 1.7rem; position: absolute; top: 0; right: 10px;"></i></a><div class="popover-arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
      title: function () {
        return $(this).attr("data-driver-name")
          ? "Assigning " + $(this).attr("data-driver-name")
          : "Shipment Details";
      },
      content: function () {
        return $("#assign-" + $(this).attr("data-type") + "-popover").html();
      },
    });
  });
}

function hideCurrentPopover() {
  var currentPopoverId = $(
    ".popover-assign-" + sessionStorage.getItem("popoverId") + ""
  ).attr("id");
  var exampleTriggerEl = document.getElementById(currentPopoverId);
  var popover = bootstrap.Popover.getInstance(exampleTriggerEl);
  popover.hide();
}

function loadPopoverContinuation(selector) {
  $(".popover-body .popover-continuation").html("");
  $(".popover-body .popover-continuation").append(
    $(selector).html().replace("DRIVER", sessionStorage.getItem("driverName"))
  );

  updateCurrentPopover();
}

function loadAvailableShipments() {
  $.ajax({
    type: "GET",
    url: "src/requests/shipment.php",
    data: "action=get-ready-shipments",
    dataType: "JSON",
  }).done(function (data) {
    var sideBuildingShipments = [];

    var shipments = data["data"];

    shipments.forEach(function (shipment) {
      var door = shipment["door"];
      var trailer = shipment["trailer"];
      var id = shipment["id"];
      if (door === "sb") {
        sideBuildingShipments.push(shipment);
        return;
      }
      $(".popover-body .popover-continuation #availableShipments").append(
        `<div class="col text-center p-3">
              <a class="btn btn-mron popover-button take-trailer" data-door="${door}" data-trailer="${trailer}" data-id="${id}">D${door}</a>
              </div>`
      );
    });

    sideBuildingShipments.forEach(function (shipment) {
      var trailer = shipment["trailer"];
      var id = shipment["id"];
      $(".popover-body .popover-continuation #availableShipments").append(
        `<div class="col text-center p-3">
              <a class="btn btn-mron popover-button-lg take-trailer" data-door="sb" data-trailer="${trailer}" data-id="${id}">S/B - ${trailer}</a>
              </div>`
      );
    });
  });

  $(".popover-body .popover-continuation").append(
    $("#assign-shipment-popover")
      .html()
      .replace("DRIVER", sessionStorage.getItem("driverName"))
  );

  updateCurrentPopover();
}

function loadAvailableDoors() {
  $.ajax({
    type: "GET",
    url: "src/requests/doors.php",
    data: "action=availableList",
    dataType: "JSON",
  }).done(function (data) {
    var doors = data["data"];
    doors.forEach(function (door) {
      if (door > 15) {
        return false;
      }
      $(".popover-body .popover-continuation #available-doors").append(
        `<div class="col text-center p-3 pt-2">
        <a class="btn btn-mron popover-button drop-trailer" data-door="${door}">D${door}</a>
        </div>`
      );
    });
  });

  $(".popover-body .popover-continuation").append(
    $("#assign-door-popover")
      .html()
      .replace("DRIVER", sessionStorage.getItem("driverName"))
  );

  updateCurrentPopover();
}

function updateShipmentDetails(outbound) {
  $(".popover-body #no-shipment-details").hide();

  if (outbound) {
    $(".popover-body #outbound-shipment-details").show();
    $.ajax({
      type: "GET",
      url: "/projects/logistics-management/src/requests/shipment.php",
      data: "action=get-shipment&query=" + sessionStorage.getItem("popoverId"),
      dataType: "json",
    }).done(function (data) {
      if (data["id"]) {
        var id = data["id"];
        var orderNumber = data["orderNumber"];
        var pallets = data["palletCount"];
        var weight = data["netWeight"]
          .toString()
          .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var facility = data["facility"].replace("_", " ");
        var status = data["status"];
        var fileLocation = $("script[src*=script]")
          .attr("src")
          .replace(/script\.js.*$/, "");

        var backgroundColor = "#276E05";
        if (status.includes("UNASSIGNED")) {
          backgroundColor = "#009b9b";
        } else if (status.includes("LOADING")) {
          backgroundColor = "#E49B0F";
        } else if (status.includes("READY")) {
          backgroundColor = "#3BA608";
        } else if (status.includes("IN_TRANSIT")) {
          backgroundColor = "#DA70D6";
        }

        $(".popover-body #shipmentId").html(id);
        $(".popover-body #po-number").html(orderNumber);
        $(".popover-body #pallets").html(pallets);
        $(".popover-body #weight").html(weight);
        $(".popover-body #facility").html(facility);
        $(".popover-body #status").html(
          '<span class="badge rounded-pill" style="background-color: ' +
            backgroundColor +
            '">' +
            status.replace("_", "-") +
            "</span>"
        );
        $(".popover-body #view-more").attr(
          "href",
          fileLocation + "../../shipments/details?id=" + id
        );
      } else {
        $(".popover-body #outbound-shipment-details").hide();
        $(".popover-body #no-shipment-details").show();
      }
    });
  } else {
    $(".popover-body #inbound-shipment-details").show();
    $.ajax({
      type: "GET",
      url: "/projects/logistics-management/src/requests/shipment.php",
      data: "action=get-shipment&query=" + sessionStorage.getItem("popoverId"),
      dataType: "json",
    }).done(function (data) {
      if (data["id"]) {
        var id = data["id"];
        var orderNumber = data["orderNumber"];
        var pallets = data["palletCount"];
        var weight = data["netWeight"]
          .toString()
          .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var status = data["status"];
        var fileLocation = $("script[src*=script]")
          .attr("src")
          .replace(/script\.js.*$/, "");

        var backgroundColor = "#276E05";
        if (status.includes("UNASSIGNED")) {
          backgroundColor = "#009b9b";
        } else if (status.includes("LOADING")) {
          backgroundColor = "#E49B0F";
        } else if (status.includes("READY")) {
          backgroundColor = "#3BA608";
        } else if (status.includes("IN_TRANSIT")) {
          backgroundColor = "#DA70D6";
        }

        $(".popover-body #po-number-in").html(orderNumber);
        $(".popover-body #pallets-in").html(pallets);
        $(".popover-body #weight-in").html(weight);
        $(".popover-body #status-in").html(
          '<span class="badge rounded-pill" style="background-color: ' +
            backgroundColor +
            '">' +
            status.replace("_", "-") +
            "</span>"
        );
        $(".popover-body #product-in").html("10372232&emsp;&emsp;50.7oz Alpla STOK Bottles&emsp;&emsp;30,492")
        $(".popover-body #view-more-in").attr(
          "href",
          fileLocation + "../../shipments/details?id=" + id
        );
      } else {
        $(".popover-body #inbound-shipment-details").hide();
        $(".popover-body #no-shipment-details").show();
      }
    });
  }
}
