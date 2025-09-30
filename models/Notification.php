<?php
declare(strict_types=1);

final class Notification {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function create(int $userId, string $message): int {
        $stmt = $this->pdo->prepare('INSERT INTO notifications (user_id, message, is_read, created_at) VALUES (?, ?, 0, ?)');
        $stmt->execute([$userId, $message, date('Y-m-d H:i:s')]);
        return (int)$this->pdo->lastInsertId();
    }

    public function listForUser(int $userId): array {
        $stmt = $this->pdo->prepare('SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function markRead(int $id, int $userId): void {
        $stmt = $this->pdo->prepare('UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
    }

    public function markAllRead(int $userId): void {
        $stmt = $this->pdo->prepare('UPDATE notifications SET is_read = 1 WHERE user_id = ?');
        $stmt->execute([$userId]);
    }

    public function countUnread(int $userId): int {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0');
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }
}
