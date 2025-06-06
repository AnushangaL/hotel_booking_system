<?php
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../config/db.php';
require_once '../../auth/auth_check.php';
require_once '../../controllers/' . $_SESSION['role'] . '/InventoryController.php';

$controller = new InventoryController($pdo, $_SESSION['role'] === 'cleaning_manager' ? 'cleaning' : ($_SESSION['role'] === 'transport_manager' ? 'transport' : 'kitchen'));

// Get employees for this department
$stmt = $pdo->prepare("SELECT id, name FROM employees WHERE role = ?");
$stmt->execute([str_replace('_manager', '', $_SESSION['role'])]);
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($controller->assignInventory($_POST['employee_id'], $_POST['item'], $_POST['quantity'], $_POST['note'])) {
        $success = "Inventory assigned successfully!";
    } else {
        $error = "Failed to assign inventory.";
    }
}
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Assign Inventory Task</h1>
  </section>

  <section class="content">
    <?php if (isset($success)): ?>
      <div class="alert alert-success"><?= $success ?></div>
    <?php elseif (isset($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="card card-primary">
      <div class="card-header"><h3 class="card-title">New Inventory Assignment</h3></div>
      <form method="POST">
        <div class="card-body">
          <div class="form-group">
            <label for="employee">Assign To</label>
            <select name="employee_id" class="form-control" required>
              <option value="">-- Select Employee --</option>
              <?php foreach ($employees as $emp): ?>
                <option value="<?= $emp['id'] ?>"><?= htmlspecialchars($emp['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="item">Inventory Item</label>
            <input type="text" class="form-control" name="item" placeholder="Item name" required>
          </div>
          <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" name="quantity" placeholder="Quantity" required min="1">
          </div>
          <div class="form-group">
            <label for="note">Note (optional)</label>
            <textarea class="form-control" name="note" rows="3"></textarea>
          </div>
        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Assign</button>
        </div>
      </form>
    </div>
  </section>
</div>

<?php require_once '../../includes/footer.php'; ?>
