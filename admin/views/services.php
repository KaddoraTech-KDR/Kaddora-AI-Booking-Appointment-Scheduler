<?php
global $wpdb;

$table = $wpdb->prefix . 'kaba_services';

// =======================
// ADD SERVICE
// =======================
if (isset($_POST['add_service'])) {
  $wpdb->insert($table, [
    'name' => sanitize_text_field($_POST['name'])
  ]);
}

// =======================
// DELETE SERVICE
// =======================
if (isset($_GET['delete'])) {
  $wpdb->delete($table, ['id' => intval($_GET['delete'])]);
  wp_redirect(remove_query_arg(['delete']));
  exit;
}

// =======================
// UPDATE SERVICE
// =======================
if (isset($_POST['update_service'])) {
  $wpdb->update(
    $table,
    ['name' => sanitize_text_field($_POST['name'])],
    ['id' => intval($_POST['id'])]
  );
}

// =======================
// EDIT MODE
// =======================
$edit_service = null;
if (isset($_GET['edit'])) {
  $edit_service = $wpdb->get_row(
    "SELECT * FROM $table WHERE id=" . intval($_GET['edit'])
  );
}

// FETCH
$services = $wpdb->get_results("SELECT * FROM $table");
?>

<div class="kaba-services">
  <h1 class="kaba-title">🛠 Services</h1>

  <div class="kaba-card">

    <!-- FORM -->
    <form method="post" class="kaba-form">

      <input type="hidden" name="id" value="<?php echo $edit_service->id ?? ''; ?>">

      <input type="text" name="name"
        class="kaba-input"
        placeholder="Service Name"
        value="<?php echo $edit_service->name ?? ''; ?>"
        required>

      <?php if ($edit_service): ?>
        <button type="submit" name="update_service" class="kaba-btn primary">
          Update
        </button>
      <?php else: ?>
        <button type="submit" name="add_service" class="kaba-btn success">
          Add Service
        </button>
      <?php endif; ?>

    </form>

    <hr class="kaba-divider">

    <!-- TABLE -->
    <table class="kaba-services-table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($services as $s): ?>
          <tr>
            <td><?php echo esc_html($s->name); ?></td>
            <td class="kaba-actions">
              <a href="?page=kaba-services&edit=<?php echo $s->id; ?>"
                class="kaba-link edit">Edit</a>

              <a href="?page=kaba-services&delete=<?php echo $s->id; ?>"
                class="kaba-link delete"
                onclick="return confirm('Delete this service?')">
                Delete
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>
</div>