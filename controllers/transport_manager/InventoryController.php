<?php
require_once __DIR__ . '/../../config/db.php'; // Adjust path if needed
require_once __DIR__ . '/../../auth/auth_check.php';

class InventoryController {
    private $pdo;
    private $department;

    public function __construct($pdo, $department) {
        $this->pdo = $pdo;
        $this->department = $department;
    }

    // Assign a new inventory task
    public function assignInventory($employeeId, $item, $quantity, $note) {
        $stmt = $this->pdo->prepare("INSERT INTO inventory_tasks (employee_id, department, item, quantity, note, status, assigned_by) VALUES (?, ?, ?, ?, ?, 'pending', ?)");
        return $stmt->execute([$employeeId, $this->department, $item, $quantity, $note, $_SESSION['user_id']]);
    }

    // Get all inventory tasks for this department
    public function getDepartmentInventory() {
        $stmt = $this->pdo->prepare("SELECT it.*, e.name AS employee_name 
                                     FROM inventory_tasks it 
                                     JOIN employees e ON it.employee_id = e.id 
                                     WHERE it.department = ? 
                                     ORDER BY it.created_at DESC");
        $stmt->execute([$this->department]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get tasks assigned to a specific employee
    public function getEmployeeInventory($employeeId) {
        $stmt = $this->pdo->prepare("SELECT * FROM inventory_tasks WHERE employee_id = ? AND department = ?");
        $stmt->execute([$employeeId, $this->department]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mark an inventory task as done
    public function markAsDone($taskId) {
        $stmt = $this->pdo->prepare("UPDATE inventory_tasks SET status = 'done', completed_at = NOW() WHERE id = ? AND department = ?");
        return $stmt->execute([$taskId, $this->department]);
    }
}
