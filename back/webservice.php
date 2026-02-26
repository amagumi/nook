<?php
header("Content-Type: application/json"); // Salida en JSON
include "connection.php";

$action = isset($_GET['action']) ? $_GET['action'] : '';

if (empty($action)) {
    echo json_encode(["error" => "Acción no especificada"]);
    exit;
}

switch ($action) {
    case "list":
        $result = $conn->query("SELECT * FROM users");
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        echo json_encode($users);
        break;

    case "add":
        $username = $_GET['username'] ?? '';
        $name = $_GET['name'] ?? '';
        $surname = $_GET['surname'] ?? '';
        $email = $_GET['email'] ?? '';

        if ($username && $name && $surname && $email) {
            $stmt = $conn->prepare("INSERT INTO users (username, name, surname, email) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $name, $surname, $email);
            if ($stmt->execute()) {
                echo json_encode(["success" => "Usuario agregado"]);
            } else {
                echo json_encode(["error" => $stmt->error]);
            }
        } else {
            echo json_encode(["error" => "Faltan parámetros"]);
        }
        break;

    case "edit":
        $id = $_GET['id'] ?? '';
        $username = $_GET['username'] ?? '';
        $name = $_GET['name'] ?? '';
        $surname = $_GET['surname'] ?? '';
        $email = $_GET['email'] ?? '';

        if ($id && $username && $name && $surname && $email) {
            $stmt = $conn->prepare("UPDATE users SET username=?, name=?, surname=?, email=? WHERE id=?");
            $stmt->bind_param("ssssi", $username, $name, $surname, $email, $id);
            if ($stmt->execute()) {
                echo json_encode(["success" => "Usuario actualizado"]);
            } else {
                echo json_encode(["error" => $stmt->error]);
            }
        } else {
            echo json_encode(["error" => "Faltan parámetros"]);
        }
        break;

    case "delete":
        $id = $_GET['id'] ?? '';
        if ($id) {
            $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                echo json_encode(["success" => "Usuario eliminado"]);
            } else {
                echo json_encode(["error" => $stmt->error]);
            }
        } else {
            echo json_encode(["error" => "Falta el ID"]);
        }
        break;

    default:
        echo json_encode(["error" => "Acción no válida"]);
        break;
}
?>