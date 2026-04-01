<?php
$services = (new Kaba_Services())->get_services();
?>

<div class="kaba-booking-wrapper">

  <form id="kaba-booking-form" class="kaba-form">

    <div class="kaba-form-header">
      <h2>Book Appointment</h2>
      <p>Fill the details below to schedule your service</p>
    </div>

    <div class="kaba-form-group">
      <input type="text" name="name" placeholder="Full Name" required>
    </div>

    <div class="kaba-form-group">
      <input type="email" name="email" placeholder="Email Address" required>
    </div>

    <div class="kaba-form-group">
      <input type="text" name="phone" placeholder="Phone Number" required>
    </div>

    <div class="kaba-form-group">
      <select name="service" required>
        <option value="">Select Service</option>
        <?php foreach ($services as $s): ?>
          <option value="<?php echo esc_attr($s->name); ?>">
            <?php echo esc_html($s->name); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Date & Time Row -->
    <div class="kaba-form-row kaba-datetime-row">
      <div class="kaba-form-group kaba-date-group">
        <input type="date" name="appointment_date" id="kaba-date" required>
        <span class="kaba-date-icon"></span>
      </div>

      <div class="kaba-form-group">
        <select name="appointment_time" id="kaba-time" required>
          <option value="">Select Time</option>
        </select>
      </div>
    </div>

    <div class="kaba-form-group">
      <button type="submit" class="kaba-btn">Book Appointment</button>
    </div>

    <p id="kaba-message" class="kaba-message"></p>

  </form>

</div>