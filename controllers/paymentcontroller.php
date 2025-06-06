<?php
class PaymentController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getPaymentHistory($filters = []) {
        $sql = "SELECT payments.*, guests.name AS guest_name 
                FROM payments 
                JOIN guests ON payments.guest_id = guests.id 
                WHERE 1";

        $params = [];

        if (!empty($filters['from'])) {
            $sql .= " AND payment_date >= ?";
            $params[] = $filters['from'];
        }

        if (!empty($filters['to'])) {
            $sql .= " AND payment_date <= ?";
            $params[] = $filters['to'];
        }

        if (!empty($filters['guest'])) {
            $sql .= " AND guests.name LIKE ?";
            $params[] = '%' . $filters['guest'] . '%';
        }

        if (!empty($filters['method'])) {
            $sql .= " AND payments.method = ?";
            $params[] = $filters['method'];
        }

        $sql .= " ORDER BY payment_date DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
