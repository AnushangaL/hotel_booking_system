<?php
require_once '../config/db.php';
require_once '../controllers/PromotionController.php';

$pdo = getDb(); // Your existing DB connection
$promoController = new PromotionController($pdo);
$isLoyal = false;
$discount = 0;
$promoMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nic = $_POST['nic'];
    $promoCode = $_POST['promo_code'];

    // Check if guest has 3 or more completed bookings
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE nic = ? AND status = 'completed'");
    $stmt->execute([$nic]);
    $count = $stmt->fetchColumn();

    if ($count >= 3) {
        $isLoyal = true;

        // Validate promo code
        if (!empty($promoCode)) {
            $promo = $promoController->applyPromoCode($promoCode);

            if ($promo) {
                $discount = $promo['discount_percent'];
                $promoMessage = "Promo applied: {$discount}% off!";
            } else {
                $promoMessage = "Invalid or expired promo code.";
            }
        }
    } else {
        $promoMessage = "You need at least 3 completed visits to apply a promo code.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Check Loyalty & Apply Promo</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h4>Check Loyalty & Apply Promo Code</h4>
    <form method="post">
        <div class="form-group">
            <label for="nic">NIC (used during booking):</label>
            <input type="text" name="nic" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="promo_code">Promo Code (optional):</label>
            <input type="text" name="promo_code" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Check</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <div class="mt-4 alert alert-info">
            <?= $promoMessage ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
