<?php
class PromotionController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function applyPromoCode($code) {
        $stmt = $this->pdo->prepare("SELECT * FROM promotions WHERE code = ? AND NOW() BETWEEN start_date AND end_date");
        $stmt->execute([$code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllPromotions() {
        $stmt = $this->pdo->query("SELECT * FROM promotions ORDER BY end_date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addPromotion($data) {
        $stmt = $this->pdo->prepare("INSERT INTO promotions (code, description, discount_percent, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['code'],
            $data['description'],
            $data['discount_percent'],
            $data['start_date'],
            $data['end_date']
        ]);
    }

    public function updatePromotion($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE promotions SET code = ?, description = ?, discount_percent = ?, start_date = ?, end_date = ? WHERE id = ?");
        return $stmt->execute([
            $data['code'],
            $data['description'],
            $data['discount_percent'],
            $data['start_date'],
            $data['end_date'],
            $id
        ]);
    }

    public function deletePromotion($id) {
        $stmt = $this->pdo->prepare("DELETE FROM promotions WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
