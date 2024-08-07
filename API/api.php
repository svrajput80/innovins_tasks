<?php
header("Content-Type: application/json; charset=UTF-8");
require '../dbfunctions.php';

$database = new DatabaseFunctions();
$db = $database->dbconn();

$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'GET':
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            get_item($id);
        } else {
            get_items();
        }
        break;
    case 'POST':
        add_item();
        break;
    case 'PUT':
        $id = intval($_GET["id"]);
        update_item($id);
        break;
    case 'DELETE':
        $id = intval($_GET["id"]);
        delete_item($id);
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_items() {
    global $db;
    $query = "SELECT * FROM items";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($items);
}

function get_item($id) {
    global $db;
    $query = "SELECT * FROM items WHERE id = :id LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($item);
}

function add_item() {
    global $db;
    $data = json_decode(file_get_contents("php://input"), true);
    $query = "INSERT INTO items (name, description, price) VALUES (:name, :description, :price)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':name', $data['name']);
    $stmt->bindParam(':description', $data['description']);
    $stmt->bindParam(':price', $data['price']);
    if ($stmt->execute()) {
        $response = array('status' => 1, 'message' => 'item added successfully.');
    } else {
        $response = array('status' => 0, 'message' => 'item addition failed.');
    }
    echo json_encode($response);
}

function update_item($id) {
    global $db;
    $data = json_decode(file_get_contents("php://input"), true);
    $query = "UPDATE items SET name = :name, description = :description, price = :price WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':name', $data['name']);
    $stmt->bindParam(':description', $data['description']);
    $stmt->bindParam(':price', $data['price']);
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
        $response = array('status' => 1, 'message' => 'item updated successfully.');
    } else {
        $response = array('status' => 0, 'message' => 'item update failed.');
    }
    echo json_encode($response);
}

function delete_item($id) {
    global $db;
    $query = "DELETE FROM items WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
        $response = array('status' => 1, 'message' => 'item deleted successfully.');
    } else {
        $response = array('status' => 0, 'message' => 'item deletion failed.');
    }
    echo json_encode($response);
}
?>
