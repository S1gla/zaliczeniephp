<?php
namespace App\Controllers;

use App\Database\Database;
use App\Models\Task;
use PDO;

class TaskController {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function all($sort = 'date') {
        $order = 'created_at ASC';
        if ($sort === 'az') $order = 'text COLLATE utf8mb4_unicode_ci ASC';
        if ($sort === 'za') $order = 'text COLLATE utf8mb4_unicode_ci DESC';
        $stmt = $this->pdo->query("SELECT * FROM tasks ORDER BY $order");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM tasks WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($text) {
        $stmt = $this->pdo->prepare('INSERT INTO tasks (text, completed, created_at) VALUES (?, 0, NOW())');
        $stmt->execute([$text]);
        return $this->get($this->pdo->lastInsertId());
    }

    public function update($id, $fields) {
        $parts = [];
        $values = [];
        if (isset($fields['text'])) { $parts[] = 'text = ?'; $values[] = $fields['text']; }
        if (isset($fields['completed'])) { $parts[] = 'completed = ?'; $values[] = $fields['completed'] ? 1 : 0; }
        if (empty($parts)) return $this->get($id);
        $values[] = $id;
        $sql = 'UPDATE tasks SET ' . implode(', ', $parts) . ' WHERE id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        return $this->get($id);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare('DELETE FROM tasks WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
