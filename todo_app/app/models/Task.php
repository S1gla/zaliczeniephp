<?php
namespace App\Models;

class Task {
    private $id;
    private $text;
    private $completed;
    private $created_at;

    public function __construct($id = null, $text = '', $completed = 0, $created_at = null) {
        $this->id = $id;
        $this->text = $text;
        $this->completed = $completed;
        $this->created_at = $created_at;
    }

    public function getId() { return $this->id; }
    public function getText() { return $this->text; }
    public function setText($t) { $this->text = $t; }
    public function isCompleted() { return (bool)$this->completed; }
    public function setCompleted($c) { $this->completed = $c ? 1 : 0; }
    public function getCreatedAt() { return $this->created_at; }

    public function toArray() {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'completed' => (int)$this->completed,
            'created_at' => $this->created_at
        ];
    }
}
