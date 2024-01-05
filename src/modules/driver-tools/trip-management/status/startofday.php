<form class="form-signin" id="startOfDayForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" novalidate>
    <label for="loadNumber" class="form-label">Load Number</label>
    <div class="input-group">
        <span class="input-group-text" id="inputGroupPrepend">C</span>
        <input type="text" class="form-control" id="loadNumber" name="loadNumber" aria-describedby="inputGroupPrepend" required autofocus>
        <div class="invalid-feedback">
            Enter a valid load number
        </div>
    </div>

    <label for="startTime" class="form-label mt-3">Start Time</label>
    <select class="form-control form-select select-caret" id="startTime" name="startTime" required>
        <option selected disabled value="">Select start time...</option>
        <option value="0200">2:00 AM</option>
        <option value="0300">3:00 AM</option>
        <option value="0400">4:00 AM</option>
        <option disabled class="separator" value=""></option>
        <option value="1400">2:00 PM</option>
        <option value="1500">3:00 PM</option>
        <option value="1600">4:00 PM</option>
    </select>
    <div class="invalid-feedback">
        Please select your start time
    </div>

    <label for="startLocation" class="form-label mt-3">Starting Location</label>
    <select class="form-control form-select select-caret" id="startLocation" name="startLocation" required>
        <option selected disabled value="">Select starting location...</option>
        <option value="danone">Danone Plant</option>
        <option value="ontario">Northern Yard</option>
    </select>
    <div class="invalid-feedback">
        Please select your starting location
    </div>

    <label for="startingMileage" class="form-label mt-3">Starting Mileage</label>
        <input type="text" class="form-control" id="startingMileage" name="startingMileage" required>
        <div class="invalid-feedback">
            Enter your starting mileage
        </div>

    <button type="submit" class="btn btn-mron-fw mt-4">Begin Pre-Trip</button>
</form>