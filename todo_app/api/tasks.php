<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$pdo = new PDO("mysql:host=localhost;dbname=baza;charset=utf8mb4", "root", "");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->query("SELECT * FROM tasks ORDER BY id ASC");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $text = $data['text'];

    $stmt = $pdo->prepare("INSERT INTO tasks (text) VALUES (?)");
    $stmt->execute([$text]);

    echo json_encode(["success" => true, "id" => $pdo->lastInsertId()]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);

    $stmt = $pdo->prepare("UPDATE tasks SET text=?, completed=? WHERE id=?");
    $stmt->execute([$data['text'], $data['completed'], $data['id']]);

    echo json_encode(["success" => true]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];

    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id=?");
    $stmt->execute([$id]);

    echo json_encode(["success" => true]);
    exit;
}
