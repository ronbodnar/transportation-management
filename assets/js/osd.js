function changeButtonText(item) {
  document.getElementById("dropdownButton-" + item.id).innerHTML =
    item.innerHTML;
  var status = 0;
  if (item.innerHTML === "Complete") {
    $("#dropdown-" + item.id)
      .removeClass("table-warning")
      .addClass("table-success");
    status = 1;
  } else if (item.innerHTML === "Pending") {
    $("#dropdown-" + item.id)
      .removeClass("table-success")
      .addClass("table-warning");
    status = 0;
  }
  console.log('id: ' + item.id);
  console.log('status: ' + status);
  $.ajax({
    type: "POST",
    url: "../process.php",
    data: { id: item.id, status: status },
    success: function (data) {},
    error: function (textStatus, errorThrown) {},
  }).done(function (data) {
    console.log(data);
  });
}

function resubmitForm() {
  $("#failure").hide();
  $("#default").removeAttr("hidden");
}

// Uploaded image array from OS&D form
var pictures = {};

/*
 * Insert image source below the camera/file input for users to see what they have uploaded.
 * Add image source to array of pictures
 */
function displayImages(files) {
  console.log(files.length);
  if (files && files[0]) {
    for (let i = 0; i < files.length; i++) {
      let reader = new FileReader();

      reader.onload = function (e) {
        var fileName = files.item(i).name;
        pictures[fileName] = e.target.result;
        $("#selectedFiles").append(
          '<div class="col-md-4 p-2 container-img" id="' +
            fileName +
            '"><img src="' +
            e.target.result +
            '" width="100" height="100"><i class="bi bi-trash-fill removePhoto" id="' +
            fileName +
            '"></i></div>'
        );
      };

      reader.readAsDataURL(files[i]);
    }
  }
}

/*
 * Validates all of the form fields for the OS&D form and styles them accordingly
 */
function validateOSDForm() {
  var valid = true;
  const fields = ["tripNumber", "fbNumber", "cases"];
  const types = ["overage", "shortage", "damage"];

  for (var i = 0; i < fields.length; i++) {
    if (!isValid(fields[i])) {
      valid = false;
    }
  }

  for (var i = 0; i < types.length; i++) {
    if (
      !$("#" + types[0]).prop("checked") &&
      !$("#" + types[1]).prop("checked") &&
      !$("#" + types[2]).prop("checked")
    ) {
      $("#overage").addClass("is-invalid");
      $("#shortage").addClass("is-invalid");
      $("#damage").addClass("is-invalid");
      valid = false;
    }
  }

  if (!$("#yCheck").prop("checked") && !$("#nCheck").prop("checked")) {
    $("#yesLabel").addClass("invalid");
    $("#yesCheck").addClass("invalid");
    $("#noLabel").addClass("invalid");
    $("#noCheck").addClass("invalid");
    $("#noLabel").addClass("is-invalid");
    valid = false;
  }

  if ($("#cameraInput").get(0).files.length === 0) {
    $("#cameraInput").addClass("is-invalid");
    valid = false;
  }

  return valid;
}

/*
 * Document is ready and custom hooks can be performed
 */
$(document).ready(function () {
  // Removes pictures from the OS&D and Accident Report form image input when delete icon is clicked
  $(document).on("click", ".removePhoto", function () {
    console.log($(this).attr("id"));
    $(this).parent().remove();

    pictures[$(this).attr("id")] = undefined;
  });

  //Removes validation errors from OS&D Form elements
  $("#overage, #shortage, #damage").click(function () {
    if ($(this).hasClass("is-invalid")) {
      $("#overage").removeClass("is-invalid");
      $("#shortage").removeClass("is-invalid");
      $("#damage").removeClass("is-invalid");
    }
  });
  $("#yesCheck, #noCheck").click(function () {
    if ($(this).hasClass("invalid")) {
      $("#yesCheck").removeClass("invalid");
      $("#yesLabel").removeClass("invalid");
      $("#noCheck").removeClass("invalid");
      $("#noLabel").removeClass("invalid");
      $("#noLabel").removeClass("is-invalid");
    }
  });

  // Removes the invalid styling from the camera input
  $("#cameraInput").change(function () {
    $("#cameraInput").removeClass("is-invalid");
  });

  // Removes the invalid styling from the specified inputs
  $("#tripNumber, #fbNumber, #cases").change(function () {
    if ($(this).val().length > 0) {
      $(this).removeClass("is-invalid");
      $(this).addClass("is-valid");
    }
  });

  // Submission of the OS&D Form
  $("#osdForm").submit(function (e) {
    e.preventDefault();
    var form = $(this);

    var valid = validateOSDForm();

    if (!valid) {
      e.stopPropagation();
      return;
    }

    var formData = form.serializeArray();
    formData.push({ name: "date", value: new Date().toISOString() });
    formData.push({ name: "pictures", value: JSON.stringify(pictures) });

    $.ajax({
      type: "POST",
      url: form.attr("action"),
      data: formData,
      success: function (data) {
        $("#default").hide();
        $("#success").removeAttr("hidden");
      },
      error: function (textStatus, errorThrown) {
        $("#default").hide();
        $("#failure").removeAttr("hidden");
      },
    }).done(function (data) {
      console.log(data);
    });
  });

  /*
   * Compressing and processing pictures from OS&D tool
   */
  const compressImage = async (file, { quality = 1, type = file.type }) => {
    const imageBitmap = await createImageBitmap(file);

    const canvas = document.createElement("canvas");
    canvas.width = imageBitmap.width;
    canvas.height = imageBitmap.height;
    canvas.getContext("2d").drawImage(imageBitmap, 0, 0);

    const blob = await new Promise((resolve) =>
      canvas.toBlob(resolve, type, quality)
    );

    return new File([blob], file.name, {
      type: blob.type,
    });
  };

  // Get the selected file from the file input
  const input = document.querySelector("#cameraInput");
  if (input) {
    input.addEventListener("change", async (e) => {
      const { files } = e.target;

      if (!files.length) return;

      const dataTransfer = new DataTransfer();

      // For every file in the files list, skipping non images
      for (const file of files) {
        if (!file.type.startsWith("image")) {
          dataTransfer.items.add(file);
          continue;
        }

        // Compress the file by 50%
        const compressedFile = await compressImage(file, {
          quality: 0.5,
          type: "image/jpeg",
        });

        dataTransfer.items.add(compressedFile);
      }

      // Set value of the file input to our new files list
      e.target.files = dataTransfer.files;

      // Display the images and compile array to send with the form data
      displayImages(e.target.files);
    });
  }
});
